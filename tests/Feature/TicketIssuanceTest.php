<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class TicketIssuanceTest extends TestCase
{
    use RefreshDatabase;

    private function createRegistration(): Registration
    {
        $event = Event::current();

        return Registration::create([
            'event_id' => $event->id,
            'registration_code' => Registration::generateCode($event->year),
            'full_name' => 'Dr. H. Bambang Widjaja, M.Si.',
            'email' => 'bambang.widjaja@investasi-kek.go.id',
            'phone_number' => '+62 811-2233-4455',
            'position' => 'Direktur Utama',
            'company_name' => 'PT Nusantara Sejahtera Port',
            'organization_type' => 'bumn',
            'country' => 'ID',
            'city' => 'Jakarta Pusat',
            'participation_category' => 'investor',
            'privacy_agreed' => true,
            'status' => 'pending_verification',
        ]);
    }

    public function test_ticket_issuance_creates_opaque_token_without_pii(): void
    {
        $registration = $this->createRegistration();
        $ticketService = app(TicketService::class);

        $ticket = $ticketService->issueTicket($registration);

        $this->assertInstanceOf(Ticket::class, $ticket);
        $this->assertEquals($registration->id, $ticket->registration_id);
        $this->assertEquals($registration->event_id, $ticket->event_id);
        $this->assertStringStartsWith('TCK-2025-', $ticket->ticket_number);

        // Verify SHA-256 hash length (64 hex characters) in qr_token
        $this->assertEquals(64, strlen($ticket->qr_token));
        $this->assertMatchesRegularExpression('/^[a-f0-9]{64}$/', $ticket->qr_token);

        // Verify recovered raw payload is opaque and does NOT leak participant PII
        $rawPayload = $ticketService->getQrPayload($ticket);
        $this->assertNotEmpty($rawPayload);
        $this->assertStringNotContainsString($registration->full_name, $rawPayload);
        $this->assertStringNotContainsString($registration->email, $rawPayload);
        $this->assertStringNotContainsString($registration->phone_number, $rawPayload);
        $this->assertStringNotContainsString($registration->company_name, $rawPayload);
    }

    public function test_duplicate_issuance_is_idempotent(): void
    {
        $registration = $this->createRegistration();
        $ticketService = app(TicketService::class);

        $ticket1 = $ticketService->issueTicket($registration);
        $ticket2 = $ticketService->issueTicket($registration);

        $this->assertEquals($ticket1->id, $ticket2->id);
        $this->assertEquals($ticket1->ticket_number, $ticket2->ticket_number);
        $this->assertEquals($ticket1->qr_token, $ticket2->qr_token);
        $this->assertEquals(1, Ticket::count());
    }

    public function test_ticket_rendering_produces_valid_high_contrast_svg(): void
    {
        $ticketService = app(TicketService::class);
        $svg = $ticketService->generateQrSvg('test-opaque-payload-12345', 240);

        $this->assertStringContainsString('<svg', $svg);
        $this->assertStringContainsString('</svg>', $svg);
        $this->assertStringContainsString('viewBox', $svg);
    }

    public function test_unauthorized_ticket_access_without_signature_is_forbidden(): void
    {
        $registration = $this->createRegistration();
        $ticketService = app(TicketService::class);
        $ticket = $ticketService->issueTicket($registration);

        // 1. Direct access without signature
        $response = $this->get('/tiket/' . $ticket->ticket_number);
        $response->assertStatus(403);

        // 2. Tampered signature
        $responseTampered = $this->get('/tiket/' . $ticket->ticket_number . '?signature=tampered123');
        $responseTampered->assertStatus(403);
    }

    public function test_signed_ticket_access_renders_pass_with_anti_indexing_headers(): void
    {
        $registration = $this->createRegistration();
        $ticketService = app(TicketService::class);
        $ticket = $ticketService->issueTicket($registration);

        $signedUrl = URL::temporarySignedRoute(
            'tickets.show',
            now()->addHour(),
            ['ticketNumber' => $ticket->ticket_number]
        );

        $response = $this->get($signedUrl);

        $response->assertStatus(200);
        $response->assertSee($ticket->ticket_number);
        $response->assertSee($registration->full_name);
        $response->assertSee($registration->company_name);
        $response->assertSee('Official Delegation Pass');
        $response->assertSee('<svg', false);

        // Security and Anti-Indexing Headers
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('private', $response->headers->get('Cache-Control'));
        $response->assertHeader('Referrer-Policy', 'no-referrer');
    }
}
