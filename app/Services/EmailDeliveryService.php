<?php

namespace App\Services;

use App\Mail\RegistrationConfirmedMail;
use App\Models\EmailLog;
use App\Models\Registration;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EmailDeliveryService
{
    public function __construct(
        protected TicketService $ticketService
    ) {}

    /**
     * Send or retry the registration confirmation email and record to email_logs.
     */
    public function sendRegistrationConfirmation(Registration $registration, ?Ticket $ticket = null): EmailLog
    {
        // 1. Ensure a valid ticket exists (Idempotent: reuses existing if present)
        $ticket = $ticket ?? $this->ticketService->issueTicket($registration);

        // 2. Count prior attempts for this registration & email type
        $priorAttempts = EmailLog::where('registration_id', $registration->id)
            ->where('email_type', 'registration_confirmation')
            ->count();

        // 3. Create tracking log entry
        $log = EmailLog::create([
            'registration_id' => $registration->id,
            'ticket_id' => $ticket->id,
            'recipient_email' => $registration->email,
            'email_type' => 'registration_confirmation',
            'status' => 'pending',
            'attempt_count' => $priorAttempts + 1,
            'error_message' => null,
        ]);

        try {
            // 4. Send email through configured mail transport
            Mail::to($registration->email)->send(new RegistrationConfirmedMail($registration, $ticket));

            // 5. Update log on success
            $log->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error_message' => null,
            ]);

            Log::info('Registration confirmation email sent successfully', [
                'registration_code' => $registration->registration_code,
                'email' => $registration->email,
                'ticket_number' => $ticket->ticket_number,
                'attempt' => $log->attempt_count,
            ]);
        } catch (Throwable $e) {
            // 6. Handle failures gracefully: Never expose secrets/passwords, never break the registration
            $sanitizedError = $this->sanitizeErrorMessage($e->getMessage());

            $log->update([
                'status' => 'failed',
                'error_message' => $sanitizedError,
            ]);

            Log::warning('Registration confirmation email delivery failed', [
                'registration_code' => $registration->registration_code,
                'email' => $registration->email,
                'error' => $sanitizedError,
                'attempt' => $log->attempt_count,
            ]);
        }

        return $log;
    }

    /**
     * Sanitize error message to prevent leaking passwords, tokens, or system secrets in DB logs.
     */
    protected function sanitizeErrorMessage(string $message): string
    {
        // Redact any auth strings, passwords, or token keys
        $sanitized = preg_replace('/(password|pass|secret|token|key)=([^\s;&]+)/i', '$1=[REDACTED]', $message);
        
        // Truncate to reasonable length
        return mb_substr($sanitized, 0, 500);
    }
}
