<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\CheckIn;
use App\Models\Event;
use App\Services\CheckInService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckInController extends Controller
{
    public function __construct(
        protected CheckInService $checkInService
    ) {}

    /**
     * Display the QR scanner and attendance interface for staff.
     */
    public function index(): View
    {
        $event = Event::current();
        $staffUser = Auth::user();

        $totalCheckedIn = CheckIn::where('event_id', $event->id)->count();
        $totalRegistrations = $event->registrations()->count();

        $recentCheckIns = CheckIn::where('event_id', $event->id)
            ->where('checked_in_by', $staffUser->id)
            ->with(['registration', 'ticket'])
            ->latest('checked_in_at')
            ->take(5)
            ->get();

        return view('staff.scanner', compact('event', 'staffUser', 'totalCheckedIn', 'totalRegistrations', 'recentCheckIns'));
    }

    /**
     * Authoritative server-side verification and check-in recording endpoint.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string', 'max:255'],
            'check_in_method' => ['nullable', 'string', 'in:qr_scanner,manual_input'],
            'gate_or_hall' => ['nullable', 'string', 'max:100'],
        ]);

        $event = Event::current();
        $staffUser = Auth::user();

        $result = $this->checkInService->verifyAndRecordCheckIn(
            rawToken: $validated['token'],
            staffUser: $staffUser,
            event: $event,
            method: $validated['check_in_method'] ?? 'qr_scanner',
            gate: $validated['gate_or_hall'] ?? 'Pintu Utama Delegasi'
        );

        // Map status to HTTP response codes
        $statusCode = match ($result['status']) {
            'success' => 200,
            'already_checked_in' => 200, // Business duplicate, returned with 200 for structured UI handling
            'wrong_event' => 422,
            'invalid_ticket' => 422,
            default => 400,
        };

        return response()->json($result, $statusCode);
    }
}
