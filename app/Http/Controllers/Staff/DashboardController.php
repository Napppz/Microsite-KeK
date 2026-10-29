<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\CheckIn;
use App\Models\Event;
use App\Models\Registration;
use App\Services\AttendanceReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function __construct(
        protected AttendanceReportService $reportService
    ) {}

    /**
     * Display the comprehensive attendance monitoring dashboard.
     */
    public function index(Request $request): View
    {
        $event = Event::current();
        $staffUser = Auth::user();

        // 1. Core Summary Metrics
        $summary = $this->reportService->getSummaryStats($event);

        // 2. Analytical Breakdowns
        $categoryBreakdown = $this->reportService->getCategoryBreakdown($event);
        $hourlyArrivals = $this->reportService->getHourlyArrivals($event);

        // 3. Paginated Participant Table with Active Filters
        $filters = $request->only([
            'search',
            'attendance_status',
            'category',
            'registration_status',
            'start_date',
            'end_date',
        ]);
        $participants = $this->reportService->getPaginatedParticipants($event, $filters, 15);

        // 4. Recent Check-in Activity
        $recentCheckIns = CheckIn::where('event_id', $event->id)
            ->with(['registration', 'ticket', 'user'])
            ->latest('checked_in_at')
            ->take(5)
            ->get();

        // 5. Available Categories for Filter Dropdown
        $availableCategories = Registration::where('event_id', $event->id)
            ->distinct()
            ->pluck('participation_category')
            ->filter();

        return view('staff.dashboard', compact(
            'event',
            'staffUser',
            'summary',
            'categoryBreakdown',
            'hourlyArrivals',
            'participants',
            'recentCheckIns',
            'availableCategories',
            'filters'
        ));
    }

    /**
     * Export attendance data as streamed CSV.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $event = Event::current();
        $filters = $request->only([
            'search',
            'attendance_status',
            'category',
            'registration_status',
            'start_date',
            'end_date',
        ]);

        return $this->reportService->streamCsv($event, $filters);
    }

    /**
     * Export attendance data as formatted Excel (XLSX).
     */
    public function exportXlsx(Request $request): BinaryFileResponse
    {
        $event = Event::current();
        $filters = $request->only([
            'search',
            'attendance_status',
            'category',
            'registration_status',
            'start_date',
            'end_date',
        ]);

        return $this->reportService->generateXlsx($event, $filters);
    }
}
