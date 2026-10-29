<?php

namespace App\Mail;

use App\Models\Registration;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class RegistrationConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Registration $registration;
    public Ticket $ticket;
    public string $signedTicketUrl;
    public string $qrDataUri;
    public string $qrPayload;

    /**
     * Create a new message instance.
     */
    public function __construct(Registration $registration, Ticket $ticket)
    {
        $this->registration = $registration;
        $this->ticket = $ticket;

        // Generate protected signed ticket viewing URL (valid for 60 days)
        $this->signedTicketUrl = URL::temporarySignedRoute(
            'tickets.show',
            now()->addDays(60),
            ['ticketNumber' => $ticket->ticket_number]
        );

        $ticketService = app(TicketService::class);
        $this->qrPayload = $ticketService->getQrPayload($ticket);
        $this->qrDataUri = $ticketService->generateQrDataUri($this->qrPayload, 240);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $eventName = config('event.name', 'KEK Business Forum');

        return new Envelope(
            subject: sprintf('Konfirmasi Akreditasi Delegasi & E-Tiket: %s (%s)', $this->registration->registration_code, $eventName),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-confirmed',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
