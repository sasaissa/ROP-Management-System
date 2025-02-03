<?php

namespace App\Services;

use App\Models\Examination;
use App\Models\Treatment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    protected $treatmentService;

    public function __construct(TreatmentAutomationService $treatmentService)
    {
        $this->treatmentService = $treatmentService;
    }

    /**
     * Get all dashboard data
     */
    public function getDashboardData(): array
    {
        return [
            'urgent_cases' => $this->getUrgentCases(),
            'due_followups' => $this->getDueFollowups(),
            'new_examinations' => $this->getNewExaminations(),
            'statistics' => $this->getStatistics(),
        ];
    }

    /**
     * Get urgent cases requiring immediate attention
     */
    public function getUrgentCases(): array
    {
        $urgentExaminations = Examination::with(['patient', 'examiner'])
            ->whereDoesntHave('treatments')
            ->where(function ($query) {
                $query->where(function ($q) {
                    // Zone I cases with stage 3 or plus disease
                    $q->where('right_eye_zone', 'I')
                      ->where(function ($sq) {
                          $sq->where('right_eye_stage', '3')
                             ->orWhere('right_eye_plus_disease', true);
                      });
                })->orWhere(function ($q) {
                    // Zone II cases with stage 3 and plus disease
                    $q->where('right_eye_zone', 'II')
                      ->where('right_eye_stage', '3')
                      ->where('right_eye_plus_disease', true);
                })->orWhere(function ($q) {
                    // Same conditions for left eye
                    $q->where('left_eye_zone', 'I')
                      ->where(function ($sq) {
                          $sq->where('left_eye_stage', '3')
                             ->orWhere('left_eye_plus_disease', true);
                      });
                })->orWhere(function ($q) {
                    $q->where('left_eye_zone', 'II')
                      ->where('left_eye_stage', '3')
                      ->where('left_eye_plus_disease', true);
                })->orWhere(function ($q) {
                    // AP-ROP cases
                    $q->where('right_eye_ap_rop', true)
                      ->orWhere('left_eye_ap_rop', true);
                });
            })
            ->latest()
            ->get();

        return [
            'count' => $urgentExaminations->count(),
            'examinations' => $urgentExaminations,
        ];
    }

    /**
     * Get follow-ups due today or overdue
     */
    public function getDueFollowups(): array
    {
        $today = Carbon::today();
        
        $dueFollowups = Examination::with(['patient', 'examiner'])
            ->where('follow_up_date', '<=', $today)
            ->whereDoesntHave('followupExamination')
            ->latest('follow_up_date')
            ->get();

        return [
            'count' => $dueFollowups->count(),
            'examinations' => $dueFollowups,
            'overdue' => $dueFollowups->where('follow_up_date', '<', $today)->count(),
        ];
    }

    /**
     * Get new examinations that need review
     */
    public function getNewExaminations(): array
    {
        $newExaminations = Examination::with(['patient', 'examiner'])
            ->whereNull('reviewed_at')
            ->latest()
            ->get();

        return [
            'count' => $newExaminations->count(),
            'examinations' => $newExaminations,
        ];
    }

    /**
     * Get general statistics
     */
    public function getStatistics(): array
    {
        $today = Carbon::today();
        $thisMonth = Carbon::today()->startOfMonth();

        return [
            'total_active_patients' => Patient::whereHas('examinations', function ($query) {
                $query->whereNull('discharged_at');
            })->count(),
            'treatments_this_month' => Treatment::where('created_at', '>=', $thisMonth)->count(),
            'examinations_today' => Examination::whereDate('created_at', $today)->count(),
            'pending_followups' => Examination::where('follow_up_date', '>', $today)->count(),
        ];
    }
}
