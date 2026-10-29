<?php

namespace App\Services;

use App\Models\CheckIn;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckInService
{
    /**
     * Authoritatively verify a ticket token and atomically record attendance.
     *
     * @param string $rawToken
     * @param User $staffUser
     * @param Event $event
     * @param string $method ('qr_scanner' or 'manual_input')
     * @param string|null $gate
     * @return array
     */
    public function verifyAndRecordCheckIn(
        string $rawToken,
        User $staffUser,
        Event $event,
        string $method = 'qr_scanner',
        ?string $gate = null
    ): array {
        $trimmedToken = trim($rawToken);

        if (empty($trimmedToken)) {
            return [
                'status' => 'invalid_ticket',
                'message' => 'Kode token tidak boleh kosong.',
            ];
        }

        // 1. Hash the incoming token using exactly the same convention as Stage 3 (SHA-256)
        $tokenHash = hash('sha256', $trimmedToken);

        try {
            return DB::transaction(function () use ($tokenHash, $staffUser, $event, $method, $gate) {
                // 2. Lock ticket record for update
                $ticket = Ticket::where('qr_token', $tokenHash)
                    ->with(['registration', 'event'])
                    ->lockForUpdate()
                    ->first();

                // 3. Reject if ticket not found
                if (! $ticket) {
                    return [
                        'status' => 'invalid_ticket',
                        'message' => 'QR Code tiket tidak valid atau tidak terdaftar dalam sistem.',
                    ];
                }

                // 4. Verify event scoping
                if ((int) $ticket->event_id !== (int) $event->id) {
                    return [
                        'status' => 'wrong_event',
                        'message' => 'Tiket ini terdaftar untuk forum acara yang berbeda.',
                    ];
                }

                // 5. Verify ticket status
                if ($ticket->status !== 'issued') {
                    return [
                        'status' => 'invalid_ticket',
                        'message' => sprintf('Tiket tidak aktif (Status: %s).', $ticket->status),
                    ];
                }

                // 6. Check for existing attendance record
                $existingCheckIn = CheckIn::where('event_id', $event->id)
                    ->where('registration_id', $ticket->registration_id)
                    ->first();

                if ($existingCheckIn) {
                    return [
                        'status' => 'already_checked_in',
                        'message' => 'Peserta Sudah Check-in Sebelumnya',
                        'checked_in_at' => $existingCheckIn->checked_in_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') . ' WIB',
                        'participant' => [
                            'name' => $ticket->registration->full_name,
                            'company' => $ticket->registration->company_name,
                            'position' => $ticket->registration->position,
                            'registration_code' => $ticket->registration->registration_code,
                            'category' => $ticket->registration->participation_category,
                            'ticket_number' => $ticket->ticket_number,
                        ],
                    ];
                }

                // 7. Atomically create check-in record
                $checkIn = CheckIn::create([
                    'event_id' => $event->id,
                    'registration_id' => $ticket->registration_id,
                    'ticket_id' => $ticket->id,
                    'checked_in_by' => $staffUser->id,
                    'checked_in_at' => now(),
                    'check_in_method' => $method,
                    'gate_or_hall' => $gate ?? 'Pintu Utama Delegasi',
                ]);

                Log::info('Staff check-in recorded successfully', [
                    'event_id' => $event->id,
                    'registration_code' => $ticket->registration->registration_code,
                    'ticket_number' => $ticket->ticket_number,
                    'staff_id' => $staffUser->id,
                    'method' => $method,
                ]);

                return [
                    'status' => 'success',
                    'message' => 'Check-in Berhasil',
                    'checked_in_at' => $checkIn->checked_in_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') . ' WIB',
                    'participant' => [
                        'name' => $ticket->registration->full_name,
                        'company' => $ticket->registration->company_name,
                        'position' => $ticket->registration->position,
                        'registration_code' => $ticket->registration->registration_code,
                        'category' => $ticket->registration->participation_category,
                        'ticket_number' => $ticket->ticket_number,
                    ],
                ];
            });
        } catch (QueryException $e) {
            // Handle PostgreSQL unique constraint violation (23505) under concurrent scan attempts
            if ($e->getCode() === '23505') {
                $existingCheckIn = CheckIn::where('event_id', $event->id)
                    ->whereHas('ticket', fn ($q) => $q->where('qr_token', $tokenHash))
                    ->with('registration')
                    ->first();

                if ($existingCheckIn) {
                    return [
                        'status' => 'already_checked_in',
                        'message' => 'Peserta Sudah Check-in Sebelumnya',
                        'checked_in_at' => $existingCheckIn->checked_in_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') . ' WIB',
                        'participant' => [
                            'name' => $existingCheckIn->registration?->full_name ?? 'Delegasi Terdaftar',
                            'company' => $existingCheckIn->registration?->company_name ?? '-',
                            'position' => $existingCheckIn->registration?->position ?? '-',
                            'registration_code' => $existingCheckIn->registration?->registration_code ?? '-',
                            'category' => $existingCheckIn->registration?->participation_category ?? '-',
                            'ticket_number' => $existingCheckIn->ticket?->ticket_number ?? '-',
                        ],
                    ];
                }
            }

            Log::error('Check-in transaction error', ['error' => $e->getMessage()]);

            return [
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem saat memproses check-in.',
            ];
        }
    }
}
