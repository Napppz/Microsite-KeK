<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketService
{
    /**
     * Issue or retrieve an existing ticket for the registration (Idempotent).
     */
    public function issueTicket(Registration $registration): Ticket
    {
        // 1. Idempotency: Return existing ticket if already issued for this event
        $existing = Ticket::where('registration_id', $registration->id)
            ->where('event_id', $registration->event_id)
            ->first();

        if ($existing) {
            return $existing;
        }

        return DB::transaction(function () use ($registration) {
            // Re-check inside transaction to avoid race conditions
            $existing = Ticket::where('registration_id', $registration->id)
                ->where('event_id', $registration->event_id)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                return $existing;
            }

            $event = $registration->event ?? Event::current();

            // 2. Generate cryptographically secure unpredictable token (64 hex characters)
            $rawToken = bin2hex(random_bytes(32));

            // 3. Cryptographic hash for fast verification & indexing (SHA-256 = 64 hex chars)
            $hashedToken = hash('sha256', $rawToken);

            // 4. Encrypt raw token using Laravel's AES-256-CBC encryption for recovery in rendering
            $encryptedToken = Crypt::encryptString($rawToken);

            // 5. Generate unique readable ticket number
            $ticketNumber = $this->generateTicketNumber($event->year ?? '2025');

            return Ticket::create([
                'event_id' => $event->id,
                'registration_id' => $registration->id,
                'ticket_number' => $ticketNumber,
                'qr_token' => $hashedToken,
                'encrypted_token' => $encryptedToken,
                'status' => 'issued',
                'issued_at' => now(),
            ]);
        });
    }

    /**
     * Generate unique ticket number with format: TCK-{year}-{6_random_alnum}
     */
    protected function generateTicketNumber(string $year): string
    {
        do {
            $number = sprintf('TCK-%s-%s', $year, strtoupper(Str::random(6)));
        } while (Ticket::where('ticket_number', $number)->exists());

        return $number;
    }

    /**
     * Get the raw payload for the QR code.
     * Contains only the opaque token string, with NO PII (no names, emails, or phone numbers).
     */
    public function getQrPayload(Ticket $ticket): string
    {
        $raw = $ticket->getRawToken();

        // Fallback to qr_token hash if raw token cannot be decrypted
        return $raw ?: $ticket->qr_token;
    }

    /**
     * Generate high-contrast SVG QR code.
     * High contrast black on white background, 2-module quiet zone margin.
     */
    public function generateQrSvg(string $payload, int $size = 280): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle($size, 2),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        return $writer->writeString($payload);
    }

    /**
     * Generate base64 Data URI SVG for easy embedding in Blade and email templates.
     */
    public function generateQrDataUri(string $payload, int $size = 280): string
    {
        $svg = $this->generateQrSvg($payload, $size);

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
}
