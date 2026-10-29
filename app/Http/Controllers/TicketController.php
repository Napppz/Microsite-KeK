<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(
        protected TicketService $ticketService
    ) {}

    /**
     * Display the digital ticket / e-Badge with protected signed URL and security headers.
     */
    public function show(Request $request, string $ticketNumber): View|Response
    {
        // Enforce cryptographic URL signature to prevent enumeration via predictable ticket numbers
        if (! $request->hasValidSignature()) {
            abort(403, 'Akses e-Badge tidak sah atau tautan telah kedaluwarsa. Silakan gunakan tautan resmi yang dikirimkan ke email Anda.');
        }

        $ticket = Ticket::where('ticket_number', $ticketNumber)
            ->with(['registration', 'event'])
            ->firstOrFail();

        $registration = $ticket->registration;
        $event = $ticket->event;

        $qrPayload = $this->ticketService->getQrPayload($ticket);
        $qrSvg = $this->ticketService->generateQrSvg($qrPayload, 260);

        return response()
            ->view('tickets.show', compact('ticket', 'registration', 'event', 'qrSvg', 'qrPayload'))
            ->withHeaders([
                'X-Robots-Tag' => 'noindex, nofollow, noarchive',
                'Cache-Control' => 'private, no-store, max-age=0, must-revalidate',
                'Pragma' => 'no-cache',
                'Referrer-Policy' => 'no-referrer',
            ]);
    }
}
