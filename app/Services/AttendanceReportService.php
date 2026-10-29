<?php

namespace App\Services;

use App\Models\CheckIn;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttendanceReportService
{
    /**
     * Compute summary metric statistics scoped to the event.
     * Handles zero-participant events safely without division-by-zero.
     */
    public function getSummaryStats(Event $event): array
    {
        $baseRegistrations = Registration::where('event_id', $event->id)
            ->whereNotIn('status', ['cancelled', 'rejected']);

        $totalRegistered = (clone $baseRegistrations)->count();

        // Count distinct registrations that have a recorded check-in for this event
        $checkedInCount = CheckIn::where('event_id', $event->id)
            ->whereHas('registration', fn ($q) => $q->whereNotIn('status', ['cancelled', 'rejected']))
            ->distinct('registration_id')
            ->count('registration_id');

        $notCheckedIn = max(0, $totalRegistered - $checkedInCount);
        $attendanceRate = $totalRegistered > 0 ? round(($checkedInCount / $totalRegistered) * 100, 1) : 0.0;

        return [
            'total_registered' => $totalRegistered,
            'checked_in' => $checkedInCount,
            'not_checked_in' => $notCheckedIn,
            'attendance_rate' => $attendanceRate,
        ];
    }

    /**
     * Get attendance metrics grouped by participant category.
     */
    public function getCategoryBreakdown(Event $event): array
    {
        $categories = Registration::where('event_id', $event->id)
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->select('participation_category', DB::raw('count(*) as total'))
            ->groupBy('participation_category')
            ->get();

        $result = [];
        foreach ($categories as $cat) {
            $categoryKey = $cat->participation_category ?: 'umum';
            $checkedIn = CheckIn::where('event_id', $event->id)
                ->whereHas('registration', fn ($q) => $q->where('participation_category', $categoryKey)->whereNotIn('status', ['cancelled', 'rejected']))
                ->count();

            $total = (int) $cat->total;
            $rate = $total > 0 ? round(($checkedIn / $total) * 100, 1) : 0.0;

            $result[] = [
                'category' => $categoryKey,
                'name' => ucwords(str_replace('_', ' ', $categoryKey)),
                'total' => $total,
                'checked_in' => $checkedIn,
                'rate' => $rate,
            ];
        }

        return $result;
    }

    /**
     * Get hourly arrival distribution for successfully checked-in participants.
     */
    public function getHourlyArrivals(Event $event): array
    {
        $checkIns = CheckIn::where('event_id', $event->id)
            ->orderBy('checked_in_at', 'asc')
            ->get();

        $hourly = [];
        foreach ($checkIns as $ci) {
            $hour = $ci->checked_in_at->setTimezone('Asia/Jakarta')->format('H:00');
            $hourly[$hour] = ($hourly[$hour] ?? 0) + 1;
        }

        ksort($hourly);

        return $hourly;
    }

    /**
     * Build base query for filtered participant list.
     */
    public function buildParticipantsQuery(Event $event, array $filters = []): Builder
    {
        $query = Registration::where('event_id', $event->id)
            ->with(['checkIn.user', 'ticket']);

        // 1. Search term across name, code, company, or email (case-insensitive)
        if (! empty($filters['search'])) {
            $term = strtolower(trim($filters['search']));
            $query->where(function ($q) use ($term) {
                $q->whereRaw('LOWER(full_name) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(registration_code) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(company_name) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(email) LIKE ?', ["%{$term}%"]);
            });
        }

        // 2. Filter by Attendance Status
        if (! empty($filters['attendance_status'])) {
            if ($filters['attendance_status'] === 'checked_in') {
                $query->has('checkIn');
            } elseif ($filters['attendance_status'] === 'not_checked_in') {
                $query->doesntHave('checkIn');
            }
        }

        // 3. Filter by Participant Category
        if (! empty($filters['category']) && $filters['category'] !== 'all') {
            $query->where('participation_category', $filters['category']);
        }

        // 4. Filter by Registration Status
        if (! empty($filters['registration_status']) && $filters['registration_status'] !== 'all') {
            $query->where('status', $filters['registration_status']);
        }

        // 5. Date Range filter (created_at)
        if (! empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }
        if (! empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        return $query->latest('created_at');
    }

    /**
     * Get paginated participant list for the dashboard.
     */
    public function getPaginatedParticipants(Event $event, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->buildParticipantsQuery($event, $filters)->paginate($perPage);
    }

    /**
     * Sanitize untrusted text fields against CSV formula-injection attacks.
     * Prevents Excel/Calc from evaluating text starting with =, +, -, @, \t, or \r as executable formulas.
     */
    public function sanitizeFormula(?string $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        $trimmed = trim($value);
        if ($trimmed !== '' && in_array($trimmed[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $value;
        }

        return $value;
    }

    /**
     * Generate streamed CSV export respecting active filters and event scoping.
     */
    public function streamCsv(Event $event, array $filters = []): StreamedResponse
    {
        $filename = sprintf('laporan-kehadiran-%s-%s.csv', $event->slug ?: 'kek', date('Y-m-d'));

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0, no-store, private',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($event, $filters) {
            $output = fopen('php://output', 'w');

            // Write UTF-8 BOM so Microsoft Excel renders Indonesian characters correctly
            fputs($output, "\xEF\xBB\xBF");

            // CSV Column Headers
            fputcsv($output, [
                'No',
                'Nomor Registrasi',
                'Nomor Tiket',
                'Nama Lengkap Delegasi',
                'Instansi / Perusahaan',
                'Jabatan',
                'Kategori Delegasi',
                'Alamat Email',
                'Nomor Telepon',
                'Status Registrasi',
                'Status Kehadiran',
                'Waktu Check-in (WIB)',
                'Pintu / Gate',
                'Petugas Check-in',
            ]);

            $counter = 1;
            $query = $this->buildParticipantsQuery($event, $filters);

            // Chunk through database efficiently to maintain bounded memory usage
            $query->chunk(100, function ($registrations) use ($output, &$counter) {
                foreach ($registrations as $reg) {
                    $hasCheckedIn = $reg->checkIn !== null;
                    $checkedInTime = $hasCheckedIn
                        ? $reg->checkIn->checked_in_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') . ' WIB'
                        : '-';
                    $gate = $hasCheckedIn ? ($reg->checkIn->gate_or_hall ?: 'Pintu Utama Delegasi') : '-';
                    $staffName = $hasCheckedIn ? ($reg->checkIn->user?->name ?: 'Petugas Staf') : '-';
                    $ticketNumber = $reg->ticket?->ticket_number ?: '-';

                    fputcsv($output, [
                        $counter++,
                        $this->sanitizeFormula($reg->registration_code),
                        $this->sanitizeFormula($ticketNumber),
                        $this->sanitizeFormula($reg->full_name),
                        $this->sanitizeFormula($reg->company_name),
                        $this->sanitizeFormula($reg->position),
                        $this->sanitizeFormula(strtoupper($reg->participation_category)),
                        $this->sanitizeFormula($reg->email),
                        $this->sanitizeFormula($reg->phone_number),
                        $this->sanitizeFormula($reg->status),
                        $hasCheckedIn ? 'Hadir' : 'Belum Hadir',
                        $this->sanitizeFormula($checkedInTime),
                        $this->sanitizeFormula($gate),
                        $this->sanitizeFormula($staffName),
                    ]);
                }
            });

            fclose($output);
        }, 200, $headers);
    }

    /**
     * Generate Excel (XLSX) export using OpenSpout streaming writer.
     */
    public function generateXlsx(Event $event, array $filters = []): BinaryFileResponse
    {
        $filename = sprintf('laporan-kehadiran-%s-%s.xlsx', $event->slug ?: 'kek', date('Y-m-d'));
        $tempPath = storage_path('app/' . uniqid('export_xlsx_', true) . '.xlsx');

        $writer = new Writer();
        $writer->openToFile($tempPath);

        // Header Row
        $headerCells = [
            Cell::fromValue('No'),
            Cell::fromValue('Nomor Registrasi'),
            Cell::fromValue('Nomor Tiket'),
            Cell::fromValue('Nama Lengkap Delegasi'),
            Cell::fromValue('Instansi / Perusahaan'),
            Cell::fromValue('Jabatan'),
            Cell::fromValue('Kategori Delegasi'),
            Cell::fromValue('Alamat Email'),
            Cell::fromValue('Nomor Telepon'),
            Cell::fromValue('Status Registrasi'),
            Cell::fromValue('Status Kehadiran'),
            Cell::fromValue('Waktu Check-in (WIB)'),
            Cell::fromValue('Pintu / Gate'),
            Cell::fromValue('Petugas Check-in'),
        ];
        $writer->addRow(new Row($headerCells));

        $counter = 1;
        $query = $this->buildParticipantsQuery($event, $filters);

        $query->chunk(100, function ($registrations) use ($writer, &$counter) {
            foreach ($registrations as $reg) {
                $hasCheckedIn = $reg->checkIn !== null;
                $checkedInTime = $hasCheckedIn
                    ? $reg->checkIn->checked_in_at->setTimezone('Asia/Jakarta')->format('d M Y, H:i:s') . ' WIB'
                    : '-';
                $gate = $hasCheckedIn ? ($reg->checkIn->gate_or_hall ?: 'Pintu Utama Delegasi') : '-';
                $staffName = $hasCheckedIn ? ($reg->checkIn->user?->name ?: 'Petugas Staf') : '-';
                $ticketNumber = $reg->ticket?->ticket_number ?: '-';

                $rowCells = [
                    Cell::fromValue($counter++),
                    Cell::fromValue($this->sanitizeFormula($reg->registration_code)),
                    Cell::fromValue($this->sanitizeFormula($ticketNumber)),
                    Cell::fromValue($this->sanitizeFormula($reg->full_name)),
                    Cell::fromValue($this->sanitizeFormula($reg->company_name)),
                    Cell::fromValue($this->sanitizeFormula($reg->position)),
                    Cell::fromValue($this->sanitizeFormula(strtoupper($reg->participation_category))),
                    Cell::fromValue($this->sanitizeFormula($reg->email)),
                    Cell::fromValue($this->sanitizeFormula($reg->phone_number)),
                    Cell::fromValue($this->sanitizeFormula($reg->status)),
                    Cell::fromValue($hasCheckedIn ? 'Hadir' : 'Belum Hadir'),
                    Cell::fromValue($this->sanitizeFormula($checkedInTime)),
                    Cell::fromValue($this->sanitizeFormula($gate)),
                    Cell::fromValue($this->sanitizeFormula($staffName)),
                ];

                $writer->addRow(new Row($rowCells));
            }
        });

        $writer->close();

        return response()->download($tempPath, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0, no-store, private',
        ])->deleteFileAfterSend(true);
    }
}
