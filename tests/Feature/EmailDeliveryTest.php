<?php

namespace Tests\Feature;

use App\Mail\RegistrationConfirmedMail;
use App\Models\EmailLog;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use App\Services\EmailDeliveryService;
use App\Services\TicketService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailDeliveryTest extends TestCase
{
    use RefreshDatabase;

    private function createRegistration(string $email = 'peserta@industri.co.id'): Registration
    {
        $event = Event::current();

        return Registration::create([
            'event_id' => $event->id,
            'registration_code' => Registration::generateCode($event->year),
            'full_name' => 'Prof. Hendra Kusuma',
            'email' => $email,
            'phone_number' => '+62 813-9876-5432',
            'position' => 'Direktur Operasional',
            'company_name' => 'PT Semen Nusantara KEK',
            'organization_type' => 'swasta',
            'country' => 'ID',
            'city' => 'Semarang',
            'participation_category' => 'investor',
            'privacy_agreed' => true,
            'status' => 'pending_verification',
        ]);
    }

    public function test_email_dispatch_and_logging_on_successful_send(): void
    {
        Mail::fake();

        $registration = $this->createRegistration();
        $emailDelivery = app(EmailDeliveryService::class);

        $log = $emailDelivery->sendRegistrationConfirmation($registration);

        $this->assertEquals('sent', $log->status);
        $this->assertEquals($registration->email, $log->recipient_email);
        $this->assertEquals('registration_confirmation', $log->email_type);
        $this->assertEquals(1, $log->attempt_count);
        $this->assertNotNull($log->sent_at);
        $this->assertNull($log->error_message);

        // Assert Mail was sent to correct recipient with correct data
        Mail::assertSent(RegistrationConfirmedMail::class, function ($mail) use ($registration) {
            return $mail->hasTo($registration->email) &&
                   $mail->registration->id === $registration->id &&
                   !empty($mail->signedTicketUrl) &&
                   !empty($mail->qrDataUri);
        });

        // Ensure ticket was associated with the log
        $this->assertNotNull($log->ticket_id);
    }

    public function test_mailable_content_contains_required_delegation_details(): void
    {
        $registration = $this->createRegistration();
        $ticket = app(TicketService::class)->issueTicket($registration);

        $mailable = new RegistrationConfirmedMail($registration, $ticket);
        $html = $mailable->render();

        $this->assertStringContainsString($registration->full_name, $html);
        $this->assertStringContainsString($registration->registration_code, $html);
        $this->assertStringContainsString($ticket->ticket_number, $html);
        $this->assertStringContainsString($mailable->signedTicketUrl, $html);
        $this->assertStringContainsString('Official Delegation Pass', $html);
    }

    public function test_email_failure_does_not_rollback_registration_and_logs_sanitized_error(): void
    {
        // Simulate Mail throwing an exception
        Mail::shouldReceive('to->send')
            ->once()
            ->andThrow(new Exception('Connection timed out on smtp.mailtrap.io with password=secret123&token=xyz987'));

        $registration = $this->createRegistration('gagal@domain.com');
        $emailDelivery = app(EmailDeliveryService::class);

        $log = $emailDelivery->sendRegistrationConfirmation($registration);

        // Registration remains intact
        $this->assertDatabaseHas('registrations', ['id' => $registration->id]);

        // Email log records failure
        $this->assertEquals('failed', $log->status);
        $this->assertNull($log->sent_at);

        // Verify password and token were redacted from DB log
        $this->assertStringNotContainsString('secret123', $log->error_message);
        $this->assertStringNotContainsString('xyz987', $log->error_message);
        $this->assertStringContainsString('password=[REDACTED]', $log->error_message);
    }

    public function test_resend_email_reuses_existing_ticket_without_duplicate(): void
    {
        Mail::fake();

        $registration = $this->createRegistration();
        $ticketService = app(TicketService::class);
        $initialTicket = $ticketService->issueTicket($registration);

        $response = $this->post('/registrasi/kirim-ulang-email', [
            'registration_code' => $registration->registration_code,
            'email' => $registration->email,
        ]);

        $response->assertSessionHas('resend_status');
        $response->assertSessionHasNoErrors();

        // Verify no duplicate ticket was created
        $this->assertEquals(1, Ticket::where('registration_id', $registration->id)->count());

        // Verify attempt count incremented
        $logs = EmailLog::where('registration_id', $registration->id)->get();
        $this->assertCount(1, $logs);
        $this->assertEquals(1, $logs->first()->attempt_count);
    }

    public function test_resend_email_rejects_invalid_combination(): void
    {
        $registration = $this->createRegistration();

        $response = $this->post('/registrasi/kirim-ulang-email', [
            'registration_code' => $registration->registration_code,
            'email' => 'wrong.email@domain.com',
        ]);

        $response->assertSessionHasErrors(['resend']);
        $this->assertEquals(0, EmailLog::count());
    }
}
