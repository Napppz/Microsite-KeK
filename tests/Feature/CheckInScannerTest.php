<?php

namespace Tests\Feature;

use App\Models\CheckIn;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckInScannerTest extends TestCase
{
    use RefreshDatabase;

    private function createStaffUser(): User
    {
        return User::factory()->create([
            'name' => 'Aditya Pratama',
            'email' => 'aditya@kek.go.id',
            'role' => 'staff',
        ]);
    }

    private function createParticipantAndTicket(?Event $event = null): array
    {
        $event = $event ?? Event::current();

        $registration = Registration::create([
            'event_id' => $event->id,
            'registration_code' => Registration::generateCode($event->year),
            'full_name' => 'Dr. Ing. Ridwan Kamil',
            'email' => 'ridwan.kamil@infrastruktur.co.id',
            'phone_number' => '+62 811-1234-5678',
            'position' => 'Komisaris Utama',
            'company_name' => 'PT West Java Infrastructure KEK',
            'organization_type' => 'bumn',
            'country' => 'ID',
            'city' => 'Bandung',
            'participation_category' => 'speaker',
            'privacy_agreed' => true,
            'status' => 'pending_verification',
        ]);

        $ticketService = app(TicketService::class);
        $ticket = $ticketService->issueTicket($registration);
        $rawToken = $ticketService->getQrPayload($ticket);

        return [$registration, $ticket, $rawToken];
    }

    public function test_scanner_page_renders_with_event_and_staff_context(): void
    {
        $staff = $this->createStaffUser();
        $event = Event::current();

        $response = $this->actingAs($staff)->get(route('staff.scanner'));

        $response->assertStatus(200);
        $response->assertSee($event->name);
        $response->assertSee($event->year);
        $response->assertSee($staff->name);
        $response->assertSee('STAFF');
        $response->assertSee('qr-reader');
        $response->assertSee('manual-token-input');
    }

    public function test_valid_ticket_records_check_in_and_returns_success(): void
    {
        $staff = $this->createStaffUser();
        [$registration, $ticket, $rawToken] = $this->createParticipantAndTicket();

        $response = $this->actingAs($staff)->postJson(route('staff.check-in.store'), [
            'token' => $rawToken,
            'check_in_method' => 'qr_scanner',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Check-in Berhasil',
            'participant' => [
                'name' => $registration->full_name,
                'company' => $registration->company_name,
                'registration_code' => $registration->registration_code,
                'ticket_number' => $ticket->ticket_number,
            ],
        ]);

        $this->assertDatabaseHas('check_ins', [
            'event_id' => $registration->event_id,
            'registration_id' => $registration->id,
            'ticket_id' => $ticket->id,
            'checked_in_by' => $staff->id,
            'check_in_method' => 'qr_scanner',
        ]);

        $this->assertEquals(1, CheckIn::count());
    }

    public function test_duplicate_check_in_returns_already_checked_in_and_preserves_timestamp(): void
    {
        $staff = $this->createStaffUser();
        [$registration, $ticket, $rawToken] = $this->createParticipantAndTicket();

        // 1. First scan
        $firstResponse = $this->actingAs($staff)->postJson(route('staff.check-in.store'), [
            'token' => $rawToken,
        ]);
        $firstResponse->assertStatus(200);
        $firstTimestamp = CheckIn::first()->checked_in_at;

        // 2. Second scan with identical token
        $secondResponse = $this->actingAs($staff)->postJson(route('staff.check-in.store'), [
            'token' => $rawToken,
        ]);

        $secondResponse->assertStatus(200);
        $secondResponse->assertJson([
            'status' => 'already_checked_in',
            'message' => 'Peserta Sudah Check-in Sebelumnya',
            'participant' => [
                'name' => $registration->full_name,
                'registration_code' => $registration->registration_code,
            ],
        ]);

        // Still only 1 record exists and timestamp is unchanged
        $this->assertEquals(1, CheckIn::count());
        $this->assertEquals(
            $firstTimestamp->format('Y-m-d H:i:s'),
            CheckIn::first()->checked_in_at->format('Y-m-d H:i:s')
        );
    }

    public function test_invalid_token_is_rejected_without_exposing_pii(): void
    {
        $staff = $this->createStaffUser();

        $response = $this->actingAs($staff)->postJson(route('staff.check-in.store'), [
            'token' => 'invalid-fake-token-1234567890',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'invalid_ticket',
        ]);

        $this->assertEquals(0, CheckIn::count());
    }

    public function test_token_from_different_event_is_rejected(): void
    {
        $staff = $this->createStaffUser();

        // Create secondary event
        $event2 = Event::create([
            'name' => 'Forum Investasi Pariwisata 2026',
            'slug' => 'forum-pariwisata-2026',
            'year' => '2026',
            'status' => 'active',
        ]);

        // Ticket belongs to Event 2
        [$registration2, $ticket2, $rawToken2] = $this->createParticipantAndTicket($event2);

        // Attempt scan on active event (which is Event::current() 2025)
        $response = $this->actingAs($staff)->postJson(route('staff.check-in.store'), [
            'token' => $rawToken2,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'status' => 'wrong_event',
        ]);

        $this->assertEquals(0, CheckIn::count());
    }

    public function test_empty_or_malformed_token_returns_validation_error(): void
    {
        $staff = $this->createStaffUser();

        $response = $this->actingAs($staff)->postJson(route('staff.check-in.store'), [
            'token' => '',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['token']);
    }

    public function test_manual_input_method_is_recorded_accurately(): void
    {
        $staff = $this->createStaffUser();
        [$registration, $ticket, $rawToken] = $this->createParticipantAndTicket();

        $response = $this->actingAs($staff)->postJson(route('staff.check-in.store'), [
            'token' => $rawToken,
            'check_in_method' => 'manual_input',
            'gate_or_hall' => 'Meja VIP Hall A',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('check_ins', [
            'ticket_id' => $ticket->id,
            'check_in_method' => 'manual_input',
            'gate_or_hall' => 'Meja VIP Hall A',
        ]);
    }
}
