<?php

namespace Tests\Feature;

use App\Models\CheckIn;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use App\Models\User;
use App\Services\AttendanceReportService;
use App\Services\TicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function createStaff(): User
    {
        return User::factory()->create([
            'email' => 'admin.protokoler@kek.go.id',
            'role' => 'staff',
        ]);
    }

    private function setupEventWithParticipants(Event $event, int $count = 5): array
    {
        $ticketService = app(TicketService::class);
        $registrations = [];

        for ($i = 1; $i <= $count; $i++) {
            $reg = Registration::create([
                'event_id' => $event->id,
                'registration_code' => sprintf('KEK-%s-DLG-%02d%04d', $event->year, $event->id, $i),
                'full_name' => "Delegasi Ke-{$i} Nusantara (Event {$event->id})",
                'email' => "delegasi{$i}_event{$event->id}@perusahaan.co.id",
                'phone_number' => "+62 811-0000-000{$i}",
                'position' => "Direktur Ke-{$i}",
                'company_name' => "PT Industri Strategis {$i}",
                'organization_type' => 'swasta',
                'country' => 'ID',
                'city' => 'Jakarta',
                'participation_category' => $i % 2 === 0 ? 'speaker' : 'investor',
                'privacy_agreed' => true,
                'status' => 'pending_verification',
            ]);

            $ticket = $ticketService->issueTicket($reg);
            $registrations[] = [$reg, $ticket];
        }

        return $registrations;
    }

    public function test_authorized_staff_can_access_dashboard(): void
    {
        $staff = $this->createStaff();
        $event = Event::current();

        $response = $this->actingAs($staff)->get(route('staff.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Kehadiran');
        $response->assertSee($event->name);
        $response->assertSee('Total Delegasi');
        $response->assertSee('Sudah Check-in');
        $response->assertSee('Belum Check-in');
        $response->assertSee('Tingkat Kehadiran');
        $response->assertSee('Unduh CSV');
        $response->assertSee('Unduh Excel (.xlsx)');
    }

    public function test_unauthenticated_request_cannot_access_dashboard(): void
    {
        $response = $this->get(route('staff.dashboard'));

        $response->assertRedirect(route('staff.login'));
    }

    public function test_unauthorized_role_receives_403_on_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'general_public']);

        $response = $this->actingAs($user)->get(route('staff.dashboard'));

        $response->assertStatus(403);
    }

    public function test_summary_metrics_calculated_accurately(): void
    {
        $staff = $this->createStaff();
        $event = Event::current();
        $items = $this->setupEventWithParticipants($event, 4);

        // Check-in 1 participant
        CheckIn::create([
            'event_id' => $event->id,
            'registration_id' => $items[0][0]->id,
            'ticket_id' => $items[0][1]->id,
            'checked_in_by' => $staff->id,
            'checked_in_at' => now(),
            'check_in_method' => 'qr_scanner',
        ]);

        $reportService = app(AttendanceReportService::class);
        $stats = $reportService->getSummaryStats($event);

        $this->assertEquals(4, $stats['total_registered']);
        $this->assertEquals(1, $stats['checked_in']);
        $this->assertEquals(3, $stats['not_checked_in']);
        $this->assertEquals(25.0, $stats['attendance_rate']);
    }

    public function test_zero_registered_participants_handles_division_by_zero_safely(): void
    {
        $event = Event::current();
        $reportService = app(AttendanceReportService::class);
        $stats = $reportService->getSummaryStats($event);

        $this->assertEquals(0, $stats['total_registered']);
        $this->assertEquals(0, $stats['checked_in']);
        $this->assertEquals(0, $stats['not_checked_in']);
        $this->assertEquals(0.0, $stats['attendance_rate']);
    }

    public function test_statistics_do_not_mix_different_events(): void
    {
        $staff = $this->createStaff();
        $event1 = Event::current();

        $event2 = Event::create([
            'name' => 'Acara Lain 2026',
            'slug' => 'acara-lain-2026',
            'year' => '2026',
            'status' => 'active',
        ]);

        // Event 1 has 2 participants
        $this->setupEventWithParticipants($event1, 2);

        // Event 2 has 5 participants
        $this->setupEventWithParticipants($event2, 5);

        $reportService = app(AttendanceReportService::class);
        $stats1 = $reportService->getSummaryStats($event1);
        $stats2 = $reportService->getSummaryStats($event2);

        $this->assertEquals(2, $stats1['total_registered']);
        $this->assertEquals(5, $stats2['total_registered']);
    }

    public function test_search_and_attendance_status_filters(): void
    {
        $staff = $this->createStaff();
        $event = Event::current();
        $items = $this->setupEventWithParticipants($event, 3);

        // Check in participant 1
        CheckIn::create([
            'event_id' => $event->id,
            'registration_id' => $items[0][0]->id,
            'ticket_id' => $items[0][1]->id,
            'checked_in_by' => $staff->id,
            'checked_in_at' => now(),
            'check_in_method' => 'qr_scanner',
        ]);

        // 1. Search for Delegasi Ke-1
        $responseSearch = $this->actingAs($staff)->get(route('staff.dashboard', ['search' => 'Delegasi Ke-1']));
        $responseSearch->assertStatus(200);
        $responseSearch->assertSee('Delegasi Ke-1 Nusantara');
        $responseSearch->assertDontSee('Delegasi Ke-2 Nusantara');

        // 2. Filter by attendance_status = checked_in
        $responseCheckedIn = $this->actingAs($staff)->get(route('staff.dashboard', ['attendance_status' => 'checked_in']));
        $responseCheckedIn->assertStatus(200);
        $responseCheckedIn->assertSee('Delegasi Ke-1 Nusantara');
        $responseCheckedIn->assertDontSee('Delegasi Ke-2 Nusantara');

        // 3. Filter by attendance_status = not_checked_in
        $responseNotCheckedIn = $this->actingAs($staff)->get(route('staff.dashboard', ['attendance_status' => 'not_checked_in']));
        $responseNotCheckedIn->assertStatus(200);
        $responseNotCheckedIn->assertSee('Delegasi Ke-2 Nusantara');
        $responseNotCheckedIn->assertSee('Delegasi Ke-3 Nusantara');
        $responseNotCheckedIn->assertDontSee('Delegasi Ke-1 Nusantara');
    }

    public function test_csv_export_returns_streamed_file_with_sanitized_formulas(): void
    {
        $staff = $this->createStaff();
        $event = Event::current();

        // Create participant with formula-like text injection
        $reg = Registration::create([
            'event_id' => $event->id,
            'registration_code' => 'KEK-2025-DLG-9999',
            'full_name' => '=1+1 Injec Delegasi',
            'email' => 'hacker@test.com',
            'phone_number' => '+62 811-9999-9999',
            'position' => '@Special Advisor',
            'company_name' => '-PT Formula Exploit',
            'organization_type' => 'swasta',
            'country' => 'ID',
            'city' => 'Jakarta',
            'participation_category' => 'investor',
            'privacy_agreed' => true,
            'status' => 'pending_verification',
        ]);

        $response = $this->actingAs($staff)->get(route('staff.reports.attendance.csv'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('attachment; filename=', $response->headers->get('Content-Disposition'));

        // Capture CSV stream content
        $csvContent = $response->streamedContent();

        // Verify headers
        $this->assertStringContainsString('Nomor Registrasi', $csvContent);
        $this->assertStringContainsString('Nama Lengkap Delegasi', $csvContent);
        $this->assertStringContainsString('Status Kehadiran', $csvContent);

        // Verify formula injection protection (escaped with single quote)
        $this->assertStringContainsString("'=1+1 Injec Delegasi", $csvContent);
        $this->assertStringContainsString("'@Special Advisor", $csvContent);
        $this->assertStringContainsString("'-PT Formula Exploit", $csvContent);

        // Verify no raw token / secret keys are leaked
        $this->assertStringNotContainsString('encrypted_token', $csvContent);
        $this->assertStringNotContainsString('password', $csvContent);
    }

    public function test_xlsx_export_returns_download_response(): void
    {
        $staff = $this->createStaff();
        $event = Event::current();
        $this->setupEventWithParticipants($event, 2);

        $response = $this->actingAs($staff)->get(route('staff.reports.attendance.xlsx'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $this->assertStringContainsString('.xlsx', $response->headers->get('Content-Disposition'));
    }

    public function test_unauthorized_user_cannot_export_reports(): void
    {
        $user = User::factory()->create(['role' => 'public_user']);

        $responseCsv = $this->actingAs($user)->get(route('staff.reports.attendance.csv'));
        $responseCsv->assertStatus(403);

        $responseXlsx = $this->actingAs($user)->get(route('staff.reports.attendance.xlsx'));
        $responseXlsx->assertStatus(403);
    }
}
