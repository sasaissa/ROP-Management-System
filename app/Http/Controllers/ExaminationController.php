<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreExaminationRequest;
use App\Http\Requests\UpdateExaminationRequest;
use Illuminate\Support\Facades\Log;
use App\Services\TreatmentAutomationService;

class ExaminationController extends Controller
{
    protected $treatmentService;

    public function __construct(TreatmentAutomationService $treatmentService)
    {
        $this->treatmentService = $treatmentService;
    }

    public function index(Request $request): View
    {
        $query = Examination::with(['patient', 'examiner']);

        // Filter by patient if patient_id is provided
        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        $examinations = $query->latest()->paginate(10);

        return view('examinations.index', compact('examinations'));
    }

    public function selectPatient(): View
    {
        $patients = Patient::orderBy('last_name')->get();
        return view('examinations.select-patient', compact('patients'));
    }

    public function create(Patient $patient): View
    {
        return view('examinations.create', compact('patient'));
    }

    public function store(StoreExaminationRequest $request): RedirectResponse
    {
        // Log the incoming request data
        Log::info('Incoming examination request data:', $request->all());

        // Log the validated data
        Log::info('Validated examination data:', $request->validated());

        try {
            $examination = Examination::create($request->validated());

            // Log the created examination
            Log::info('Created examination:', $examination->toArray());

            // Analyze severity and suggest treatment
            $analysis = $this->treatmentService->analyzeSeverity($examination);

            // Log the analysis
            Log::info('Examination analysis:', $analysis);

            // If both eyes only need observation, create a follow-up examination
            if ($analysis['right_eye']['treatment'] === 'Observation' && 
                $analysis['left_eye']['treatment'] === 'Observation') {
                
                $nextExamination = new Examination();
                $nextExamination->patient_id = $examination->patient_id;
                $nextExamination->examiner_id = $examination->examiner_id;
                $nextExamination->status = 'scheduled';
                
                // Get the shorter follow-up period
                $rightFollowUpDays = $this->treatmentService->convertFollowUpTodays($analysis['right_eye']['follow_up']);
                $leftFollowUpDays = $this->treatmentService->convertFollowUpTodays($analysis['left_eye']['follow_up']);
                $followUpDays = min($rightFollowUpDays, $leftFollowUpDays);
                
                $nextExamination->examination_date = now()->addDays($followUpDays);
                $nextExamination->followup_of_examination_id = $examination->id;
                $nextExamination->save();

                return redirect()
                    ->route('patients.show', $examination->patient_id)
                    ->with('success', 'Follow-up examination scheduled for ' . $nextExamination->examination_date->format('d-m-Y'));
            }

            // Otherwise create a treatment plan
            $result = $this->treatmentService->acceptTreatmentPlan($examination);

            $message = 'Treatment plan accepted. ';
            if ($result instanceof Treatment) {
                $message .= 'Treatment has been scheduled for ' . $result->scheduled_date->format('Y-m-d');
            } else {
                $message .= 'Follow-up examination has been scheduled for ' . $result->examination_date->format('Y-m-d');
            }

            return redirect()
                ->route('patients.show', $examination->patient_id)
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Failed to create examination:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create examination. Please try again.');
        }
    }

    public function show(Examination $examination)
    {
        // If this is a scheduled follow-up examination, don't try to analyze severity
        if ($examination->status === 'scheduled') {
            return response()->json([
                'message' => 'Follow-up examination scheduled for ' . $examination->examination_date->format('d-m-Y'),
                'redirect_url' => route('patients.show', $examination->patient_id)
            ]);
        }

        $analysis = $this->treatmentService->analyzeSeverity($examination);

        return view('examinations.show', [
            'examination' => $examination,
            'analysis' => $analysis
        ]);
    }

    public function edit(Examination $examination): View
    {
        $examination->load(['patient', 'examiner']);
        return view('examinations.edit', compact('examination'));
    }

    /**
     * Accept the treatment plan for an examination
     */
    public function acceptPlan(Examination $examination): RedirectResponse
    {
        try {
            $result = $this->treatmentService->acceptTreatmentPlan($examination);

            $message = 'Treatment plan accepted. ';
            if ($result instanceof Treatment) {
                $message .= 'Treatment has been scheduled for ' . $result->scheduled_date->format('Y-m-d');
            } else {
                $message .= 'Follow-up examination has been scheduled for ' . $result->examination_date->format('Y-m-d');
            }

            return redirect()
                ->route('patients.show', $examination->patient_id)
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Failed to accept treatment plan:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to process treatment plan. Please try again.');
        }
    }

    public function update(UpdateExaminationRequest $request, Examination $examination): RedirectResponse
    {
        $examination->update($request->validated());

        return redirect()
            ->route('examinations.show', $examination)
            ->with('success', 'Examination record updated successfully.');
    }

    /**
     * Remove the specified examination from storage.
     *
     * @param  \App\Models\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Examination $examination)
    {
        try {
            $patientId = $examination->patient_id;
            $examination->delete();

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Examination deleted successfully'
                ]);
            }

            return redirect()
                ->route('patients.show', $patientId)
                ->with('success', 'Examination record deleted successfully.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting examination record.'
                ], 500);
            }

            return redirect()
                ->route('patients.show', $patientId)
                ->with('error', 'Error deleting examination record.');
        }
    }

    public function acceptTreatmentPlan(Examination $examination)
    {
        $analysis = $this->treatmentService->analyzeSeverity($examination);
        $result = $this->treatmentService->createTreatmentPlan($examination, $analysis);

        if ($result instanceof Treatment) {
            $message = 'Treatment has been scheduled';
            if ($result->treatment_date) {
                $message .= ' for ' . $result->treatment_date->format('d-m-Y');
            }
            $message .= '. Please review and adjust the details.';
            
            return response()->json([
                'redirect_url' => route('treatments.edit', $result),
                'message' => $message
            ]);
        } else {
            $message = 'Follow-up examination has been scheduled';
            if ($result->examination_date) {
                $message .= ' for ' . $result->examination_date->format('d-m-Y');
            }
            
            return response()->json([
                'redirect_url' => route('examinations.show', $result),
                'message' => $message
            ]);
        }
    }

    /**
     * Mark an examination as reviewed.
     */
    public function markReviewed(Examination $examination)
    {
        $examination->update([
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Examination marked as reviewed successfully',
            'examination' => $examination
        ]);
    }
}
