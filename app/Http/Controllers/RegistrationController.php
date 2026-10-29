<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Event;
use App\Models\Registration;
use App\Services\EmailDeliveryService;
use App\Services\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function __construct(
        protected TicketService $ticketService,
        protected EmailDeliveryService $emailDeliveryService
    ) {}

    /**
     * Show the formal registration form.
     */
    public function create(): View
    {
        $event = Event::current();

        return view('registration.create', compact('event'));
    }

    /**
     * Store a newly created participant registration in PostgreSQL,
     * issue an idempotent ticket, and dispatch confirmation email after commit.
     */
    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $event = Event::current();
        $ticket = null;

        try {
            // 1. Persist registration and issue ticket inside transaction
            $registration = DB::transaction(function () use ($request, $event, &$ticket) {
                $reg = Registration::create([
                    'event_id' => $event->id,
                    'registration_code' => Registration::generateCode($event->year),
                    'full_name' => $request->input('full_name'),
                    'email' => $request->input('email'),
                    'phone_number' => $request->input('phone_number'),
                    'position' => $request->input('position'),
                    'company_name' => $request->input('company_name'),
                    'organization_type' => $request->input('organization_type'),
                    'country' => $request->input('country'),
                    'city' => $request->input('city'),
                    'participation_category' => $request->input('participation_category', 'investor'),
                    'sectors' => $request->input('sectors', []),
                    'sessions' => $request->input('sessions', ['plenary']),
                    'privacy_agreed' => true,
                    'status' => 'pending_verification',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                // Issue secure ticket associated with this registration
                $ticket = $this->ticketService->issueTicket($reg);

                return $reg;
            });

            // 2. Dispatch confirmation email AFTER database transaction has committed
            $emailLog = null;
            if ($ticket) {
                $emailLog = $this->emailDeliveryService->sendRegistrationConfirmation($registration, $ticket);
            }

            return redirect()
                ->route('registration.success', ['code' => $registration->registration_code])
                ->with('status', 'Registrasi berhasil diserahkan dan e-Badge resmi telah diterbitkan.')
                ->with('email_status', $emailLog?->status ?? 'pending');

        } catch (\Throwable $e) {
            Log::error('Registration persistence failed', [
                'error' => $e->getMessage(),
                'email' => $request->input('email'),
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'general' => 'Terjadi kendala sistem saat menyimpan data akreditasi. Silakan coba kembali atau hubungi meja bantuan sekretariat.',
                ]);
        }
    }

    /**
     * Show registration confirmation screen with digital ticket link and email status.
     */
    public function success(string $code): View
    {
        $registration = Registration::where('registration_code', $code)
            ->with(['event', 'ticket', 'emailLogs'])
            ->firstOrFail();

        $signedTicketUrl = null;
        if ($registration->ticket) {
            $signedTicketUrl = URL::temporarySignedRoute(
                'tickets.show',
                now()->addDays(60),
                ['ticketNumber' => $registration->ticket->ticket_number]
            );
        }

        $latestEmailLog = $registration->emailLogs()->latest()->first();

        return view('registration.success', compact('registration', 'signedTicketUrl', 'latestEmailLog'));
    }

    /**
     * Rate-limited endpoint to resend confirmation email.
     */
    public function resendEmail(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'registration_code' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $normalizedEmail = trim(strtolower($validated['email']));

        $registration = Registration::where('registration_code', $validated['registration_code'])
            ->where('email', $normalizedEmail)
            ->with(['ticket', 'event'])
            ->first();

        if (! $registration) {
            return back()->withErrors([
                'resend' => 'Data pendaftaran dengan kode referensi dan email tersebut tidak ditemukan.',
            ]);
        }

        $emailLog = $this->emailDeliveryService->sendRegistrationConfirmation($registration, $registration->ticket);

        if ($emailLog->status === 'sent') {
            return back()->with('resend_status', sprintf('Email konfirmasi dan e-Badge berhasil dikirimkan ulang ke %s.', $normalizedEmail));
        }

        return back()->withErrors([
            'resend' => 'Pengiriman email mengalami gangguan teknis. Silakan akses tiket Anda langsung melalui tombol e-Badge di bawah.',
        ]);
    }
}
