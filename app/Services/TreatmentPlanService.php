<?php

namespace App\Services;

use App\Models\Examination;
use App\Models\TreatmentPlan;

class TreatmentPlanService
{
    public function suggestTreatment(Examination $examination): TreatmentPlan
    {
        $treatment = $this->determineTreatment($examination);
        
        return TreatmentPlan::create([
            'examination_id' => $examination->id,
            'suggested_treatment' => $treatment,
            'status' => 'suggested'
        ]);
    }

    private function determineTreatment(Examination $examination): string
    {
        $rightEyeTreatment = $this->getEyeTreatment(
            $examination->right_eye_zone,
            $examination->right_eye_stage,
            $examination->right_eye_plus,
            $examination->right_eye_aprop ?? false
        );

        $leftEyeTreatment = $this->getEyeTreatment(
            $examination->left_eye_zone,
            $examination->left_eye_stage,
            $examination->left_eye_plus,
            $examination->left_eye_aprop ?? false
        );

        return $this->combineTreatments($rightEyeTreatment, $leftEyeTreatment);
    }

    private function getEyeTreatment(?string $zone, ?string $stage, ?string $plus, bool $aprop): string
    {
        if (empty($zone) || empty($stage)) {
            return 'No treatment needed - continue monitoring';
        }

        // AP-ROP cases require immediate treatment
        if ($aprop) {
            return 'Immediate treatment required - Anti-VEGF injection and/or laser photocoagulation';
        }

        // Treatment criteria based on ICROP3 guidelines
        if ($zone === 'I') {
            if ($stage >= '3' || $plus === 'plus') {
                return 'Immediate treatment required - Consider anti-VEGF injection or laser photocoagulation';
            }
            if ($plus === 'pre-plus') {
                return 'Close monitoring required (24-48 hours) - Consider treatment if progression noted';
            }
        }

        if ($zone === 'posterior II' && $stage >= '3') {
            if ($plus === 'plus' || $plus === 'pre-plus') {
                return 'Treatment required - Laser photocoagulation recommended';
            }
            return 'Close monitoring required (3-7 days) - Consider treatment if progression noted';
        }

        if ($zone === 'II' && $stage >= '3' && $plus === 'plus') {
            return 'Treatment required - Laser photocoagulation recommended';
        }

        return 'Continue regular monitoring based on zone and stage progression';
    }

    private function combineTreatments(string $rightEye, string $leftEye): string
    {
        if ($rightEye === $leftEye) {
            return "Both eyes: $rightEye";
        }

        return "Right eye: $rightEye\nLeft eye: $leftEye";
    }
}
