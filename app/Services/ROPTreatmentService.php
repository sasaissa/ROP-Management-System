<?php

namespace App\Services;

use App\Models\Examination;
use App\Models\TreatmentPlan;

class ROPTreatmentService
{
    public function analyzeFindingsAndCreatePlan(Examination $examination): TreatmentPlan
    {
        $rightEyePlan = $this->analyzeEye(
            $examination->right_eye_zone,
            $examination->right_eye_stage,
            $examination->right_eye_plus,
            $examination->right_eye_ap_rop,
            $examination->right_eye_clock_hours
        );

        $leftEyePlan = $this->analyzeEye(
            $examination->left_eye_zone,
            $examination->left_eye_stage,
            $examination->left_eye_plus,
            $examination->left_eye_ap_rop,
            $examination->left_eye_clock_hours
        );

        $plan = new TreatmentPlan();
        $plan->examination_id = $examination->id;
        $plan->suggested_treatment = $this->compileTreatmentPlan($rightEyePlan, $leftEyePlan);
        $plan->status = 'suggested';
        $plan->save();

        return $plan;
    }

    private function analyzeEye(?string $zone, ?string $stage, ?string $plus, ?bool $apROP, $clockHours): array
    {
        // Convert stage to integer if it's a numeric string, handling special cases like '4B'
        $numericStage = null;
        if ($stage) {
            if (preg_match('/^(\d+)[A-B]?$/', $stage, $matches)) {
                $numericStage = (int)$matches[1];
            }
        }

        if ($apROP) {
            return [
                'severity' => 'type_1',
                'treatment' => 'immediate_treatment',
                'treatment_type' => 'anti_vegf_preferred',
                'followup' => '2_days',
                'notes' => 'Aggressive ROP detected - requires immediate intervention'
            ];
        }

        // Handle stage 4 and 5 cases
        if ($numericStage >= 4) {
            return [
                'severity' => 'advanced',
                'treatment' => 'surgical_referral',
                'followup' => '24_hours',
                'notes' => "Stage $stage ROP - requires immediate surgical consultation"
            ];
        }

        // Type 1 ROP criteria
        if (
            ($zone === 'I' && $plus === 'plus') ||
            ($zone === 'I' && $numericStage === 3) ||
            ($zone === 'II' && $numericStage >= 2 && $plus === 'plus')
        ) {
            return [
                'severity' => 'type_1',
                'treatment' => 'immediate_treatment',
                'treatment_type' => $this->determineTreatmentType($zone, $numericStage),
                'followup' => '3_to_5_days',
                'notes' => 'Type 1 ROP - requires treatment'
            ];
        }

        // Type 2 ROP criteria
        if (
            ($zone === 'I' && $numericStage <= 2 && $plus !== 'plus') ||
            ($zone === 'II' && $numericStage === 3 && $plus !== 'plus')
        ) {
            return [
                'severity' => 'type_2',
                'treatment' => 'observation',
                'followup' => '2_to_4_days',
                'notes' => 'Type 2 ROP - requires close observation'
            ];
        }

        // Immature/less severe ROP
        return [
            'severity' => 'mild',
            'treatment' => 'observation',
            'followup' => $this->determineFollowupSchedule($zone, $numericStage),
            'notes' => 'Continue regular screening'
        ];
    }

    private function determineTreatmentType(string $zone, ?int $stage): string
    {
        if ($zone === 'I' || ($zone === 'II' && $stage <= 2)) {
            return 'anti_vegf_preferred';
        }
        return 'laser_preferred';
    }

    private function determineFollowupSchedule(?string $zone, ?int $stage): string
    {
        if (!$zone || !$stage) {
            return '1_week';
        }

        if ($zone === 'III') {
            return '2_to_3_weeks';
        }

        if ($zone === 'II' && $stage <= 2) {
            return '1_to_2_weeks';
        }

        return '1_week';
    }

    private function compileTreatmentPlan(array $rightEyePlan, array $leftEyePlan): string
    {
        $plan = [
            'right_eye' => $rightEyePlan,
            'left_eye' => $leftEyePlan,
            'overall_recommendation' => $this->determineOverallRecommendation($rightEyePlan, $leftEyePlan)
        ];

        return json_encode($plan);
    }

    private function determineOverallRecommendation(array $rightEyePlan, array $leftEyePlan): string
    {
        if ($rightEyePlan['severity'] === 'type_1' || $leftEyePlan['severity'] === 'type_1') {
            return 'Immediate treatment required. Schedule treatment within 48-72 hours.';
        }

        if ($rightEyePlan['severity'] === 'type_2' || $leftEyePlan['severity'] === 'type_2') {
            return 'Close observation required. Schedule follow-up within 2-4 days.';
        }

        return 'Continue regular screening according to schedule.';
    }
}
