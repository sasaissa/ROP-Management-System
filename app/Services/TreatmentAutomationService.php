<?php

namespace App\Services;

use App\Models\Examination;
use App\Models\Treatment;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UrgentTreatmentRequired;
use App\Notifications\FollowUpScheduled;
use Illuminate\Support\Facades\Log;

class TreatmentAutomationService
{
    /**
     * Analyze examination and suggest treatment plan
     */
    public function analyzeSeverity(Examination $examination): array
    {
        $analysis = [
            'right_eye' => $this->analyzeEye($examination, 'right'),
            'left_eye' => $this->analyzeEye($examination, 'left')
        ];

        return $analysis;
    }

    private function analyzeEye(Examination $examination, string $eye): array
    {
        $zone = $examination->{$eye . '_eye_zone'};
        $stage = (int) $examination->{$eye . '_eye_stage'};
        $plusDisease = (bool) $examination->{$eye . '_eye_plus_disease'};
        $clockHours = $examination->{$eye . '_eye_clock_hours'};
        
        // Parse clock hours to get extent - handle both array and string formats
        $clockHourCount = 0;
        if (is_array($clockHours)) {
            $clockHourCount = count($clockHours);
        } elseif (is_string($clockHours) && !empty($clockHours)) {
            $clockHourCount = count(explode(',', $clockHours));
        }
        
        // Type 1 ROP criteria based on ICROP3
        $requiresTreatment = 
            ($zone === 'I' && $stage >= 3) ||  // Zone I, stage 3
            ($zone === 'I' && $plusDisease) ||  // Zone I with plus
            (in_array($zone, ['II', 'posterior II']) && $stage >= 3 && $plusDisease); // Zone II, stage 3 with plus
        
        // Determine severity based on zone, stage, and plus disease
        $severity = $this->determineSeverity($zone, $stage, $plusDisease, $clockHourCount, $requiresTreatment);
        
        // Urgent if Type 1 ROP
        $urgent = $requiresTreatment;
        
        // Treatment determination based on ICROP3
        if ($requiresTreatment) {
            if ($zone === 'I' || $zone === 'posterior II') {
                $treatment = 'Anti-VEGF treatment recommended (consider Laser as alternative)';
            } else {
                $treatment = 'Laser treatment recommended (consider Anti-VEGF as alternative)';
            }

            // Add additional warning for urgent cases
            if ($urgent) {
                $treatment .= ' - Urgent treatment required within 48 hours';
            }
        } else {
            $treatment = 'Observation';
            // Add note for Zone III stage 3
            if ($zone === 'III' && $stage === 3) {
                $treatment .= ' - Zone III ROP typically has good prognosis without treatment';
            }
        }
        
        return [
            'severity' => $severity,
            'treatment' => $treatment,
            'follow_up' => $this->determineFollowUp($zone, $stage, $plusDisease, $requiresTreatment),
            'urgent' => $urgent
        ];
    }

    private function determineSeverity(string $zone, int $stage, bool $plusDisease, int $clockHourCount, bool $requiresTreatment): string
    {
        // Type 1 ROP is always severe
        if ($requiresTreatment) {
            return 'Severe';
        }
        
        // Zone III stage 3 without plus disease is moderate
        if ($zone === 'III' && $stage === 3 && !$plusDisease) {
            return 'Moderate';
        }
        
        // Other severe conditions
        if ($zone === 'I' || ($stage >= 3 && $plusDisease)) {
            return 'Severe';
        }
        
        // Moderate conditions
        if ($stage >= 2 || in_array($zone, ['II', 'posterior II']) || $clockHourCount >= 6) {
            return 'Moderate';
        }
        
        return 'Mild';
    }

    private function determineFollowUp(string $zone, int $stage, bool $plusDisease, bool $requiresTreatment): string
    {
        if ($requiresTreatment) {
            return '24-48 hours';
        } elseif ($plusDisease || $zone === 'I') {
            return '3-5 days';
        } elseif ($zone === 'III' && $stage === 3) {
            return '1-2 weeks'; // Zone III stage 3 needs closer follow-up
        } elseif ($stage >= 2 || in_array($zone, ['II', 'posterior II'])) {
            return '1 week';
        }
        return '2 weeks';
    }

    /**
     * Create treatment plan and schedule follow-up
     */
    public function createTreatmentPlan(Examination $examination, array $analysis)
    {
        // Both eyes need observation, so don't create a treatment
        if ($analysis['right_eye']['treatment'] === 'Observation' && 
            $analysis['left_eye']['treatment'] === 'Observation') {
            return null;
        }

        // Create treatment for the eye(s) that need it
        $treatment = new Treatment();
        $treatment->patient_id = $examination->patient_id;
        $treatment->examination_id = $examination->id;
        $treatment->treating_doctor_id = $examination->examiner_id;
        $treatment->status = 'scheduled';
        
        // Set treatment type based on analysis
        $treatmentType = '';
        if ($analysis['right_eye']['treatment'] !== 'Observation') {
            $treatmentType .= 'Right Eye: ' . $analysis['right_eye']['treatment'];
        }
        if ($analysis['left_eye']['treatment'] !== 'Observation') {
            if ($treatmentType) $treatmentType .= ', ';
            $treatmentType .= 'Left Eye: ' . $analysis['left_eye']['treatment'];
        }
        
        $treatment->treatment_type = $treatmentType;

        // Set treatment date based on urgency
        $isUrgent = $analysis['right_eye']['urgent'] || $analysis['left_eye']['urgent'];
        $daysUntilTreatment = $isUrgent ? 2 : 7; // 2 days for urgent, 7 for regular
        $treatment->treatment_date = now()->addDays($daysUntilTreatment);

        $treatment->save();

        Log::info('Created treatment:', [
            'id' => $treatment->id,
            'treatment_date' => $treatment->treatment_date,
            'treatment_type' => $treatment->treatment_type,
            'days_until_treatment' => $daysUntilTreatment,
            'is_urgent' => $isUrgent
        ]);

        return $treatment;
    }

    private function createScheduledExamination(Examination $examination, array $analysis)
    {
        // Determine follow-up days based on the shorter follow-up period
        $rightFollowUpDays = $this->convertFollowUpTodays($analysis['right_eye']['follow_up']);
        $leftFollowUpDays = $this->convertFollowUpTodays($analysis['left_eye']['follow_up']);
        $followUpDays = min($rightFollowUpDays, $leftFollowUpDays);

        $nextExamination = new Examination();
        $nextExamination->patient_id = $examination->patient_id;
        $nextExamination->examiner_id = $examination->examiner_id;
        $nextExamination->status = 'scheduled';
        $nextExamination->examination_date = now()->addDays($followUpDays);
        $nextExamination->followup_of_examination_id = $examination->id;
        $nextExamination->save();

        \Log::info('Created follow-up examination:', [
            'id' => $nextExamination->id,
            'examination_date' => $nextExamination->examination_date,
            'follow_up_days' => $followUpDays,
            'right_follow_up' => $analysis['right_eye']['follow_up'],
            'left_follow_up' => $analysis['left_eye']['follow_up']
        ]);

        return $nextExamination;
    }

    private function convertFollowUpTodays(string $followUp): int
    {
        $parts = explode(' ', strtolower($followUp));
        $number = (int) $parts[0];
        $unit = $parts[1];

        return match ($unit) {
            'day', 'days' => $number,
            'week', 'weeks' => $number * 7,
            'month', 'months' => $number * 30,
            default => 7 // Default to 1 week if unknown format
        };
    }

    private function notifyUrgentTreatment(Treatment $treatment)
    {
        $admins = User::role('admin')->get();
        $doctors = User::role('ophthalmologist')->get();

        Notification::send(
            $admins->merge($doctors),
            new UrgentTreatmentRequired($treatment)
        );
    }

    private function notifyFollowUpScheduled(Examination $examination)
    {
        $doctor = $examination->patient->doctor;
        if ($doctor) {
            Notification::send($doctor, new FollowUpScheduled($examination));
        }
    }

    /**
     * Handle the acceptance of a treatment plan by a doctor
     */
    public function acceptTreatmentPlan(Examination $examination)
    {
        // Mark the current examination as complete
        $examination->status = 'complete';
        $examination->save();

        // Get the analysis to determine the next steps
        $analysis = $this->analyzeSeverity($examination);

        // Create appropriate follow-up (either treatment or examination)
        return $this->createTreatmentPlan($examination, $analysis);
    }
}
