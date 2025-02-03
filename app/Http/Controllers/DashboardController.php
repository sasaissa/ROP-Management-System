<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Patient;
use App\Models\Examination;
use App\Models\Treatment;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(): View
    {
        $dashboardData = $this->dashboardService->getDashboardData();

        return view('dashboard', [
            'urgentCases' => $dashboardData['urgent_cases'],
            'dueFollowups' => $dashboardData['due_followups'],
            'newExaminations' => $dashboardData['new_examinations'],
            'statistics' => $dashboardData['statistics']
        ]);
    }

    /**
     * Mark an examination as reviewed
     */
    public function markReviewed(Request $request, Examination $examination)
    {
        $examination->update(['reviewed_at' => now()]);

        return response()->json([
            'message' => 'Examination marked as reviewed',
            'examination' => $examination
        ]);
    }

    /**
     * Get updated dashboard data (for real-time updates)
     */
    public function refresh()
    {
        return response()->json($this->dashboardService->getDashboardData());
    }
}
