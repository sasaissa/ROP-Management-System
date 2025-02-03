<?php

namespace App\Http\Controllers;

use App\Models\TreatmentPlan;
use App\Models\Examination;
use App\Models\Treatment;
use App\Services\ROPTreatmentService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TreatmentPlanController extends Controller
{
    protected $treatmentService;

    public function __construct(ROPTreatmentService $treatmentService)
    {
        $this->treatmentService = $treatmentService;
    }

    public function accept(TreatmentPlan $treatmentPlan): RedirectResponse
    {
        $treatmentPlan->update([
            'status' => 'accepted',
            'final_treatment' => $treatmentPlan->suggested_treatment
        ]);

        // Create a new treatment record
        $examination = $treatmentPlan->examination;
        $suggestedTreatment = json_decode($treatmentPlan->suggested_treatment, true);
        
        $treatment = Treatment::create([
            'patient_id' => $examination->patient_id,
            'examination_id' => $examination->id,
            'treating_doctor_id' => auth()->id(),
            'examiner_id' => $examination->examiner_id,
            'treatment_date' => now(),
            'treatment_type' => $suggestedTreatment['treatment_type'] ?? 'laser',
            'right_eye_treated' => isset($suggestedTreatment['right_eye']['treatment']),
            'left_eye_treated' => isset($suggestedTreatment['left_eye']['treatment']),
            'right_eye_treatment_notes' => $suggestedTreatment['right_eye']['treatment'] ?? null,
            'left_eye_treatment_notes' => $suggestedTreatment['left_eye']['treatment'] ?? null,
            'follow_up_date' => $suggestedTreatment['follow_up_date'] ?? now()->addDays(7),
            'post_treatment_instructions' => $suggestedTreatment['instructions'] ?? 'Standard post-treatment care instructions',
        ]);

        return redirect()->route('treatments.show', $treatment)
            ->with('success', 'Treatment plan accepted and treatment record created successfully.');
    }

    public function update(Request $request, TreatmentPlan $treatmentPlan): RedirectResponse
    {
        $validated = $request->validate([
            'final_treatment' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $treatmentPlan->update([
            'status' => 'edited',
            'final_treatment' => $validated['final_treatment'],
            'notes' => $validated['notes']
        ]);

        return back()->with('success', 'Treatment plan updated successfully.');
    }

    public function cancel(TreatmentPlan $treatmentPlan): RedirectResponse
    {
        $treatmentPlan->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Treatment plan cancelled.');
    }

    public function generate(Examination $examination): RedirectResponse
    {
        $treatmentPlan = $this->treatmentService->analyzeFindingsAndCreatePlan($examination);
        return back()->with('success', 'Treatment plan generated successfully.');
    }
}
