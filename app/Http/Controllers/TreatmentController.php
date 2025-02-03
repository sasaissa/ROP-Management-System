<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the treatments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Treatment::with(['patient', 'treatingDoctor'])
            ->latest();

        // Search by patient name or treating doctor
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('patient', function ($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%");
            })->orWhereHas('treatingDoctor', function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by treatment type
        if ($request->filled('type')) {
            $query->where('treatment_type', $request->type);
        }

        $treatments = $query->paginate(10)
            ->withQueryString();

        return view('treatments.index', compact('treatments'));
    }

    /**
     * Display the specified treatment.
     *
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment $treatment)
    {
        $treatment->load(['patient', 'treatingDoctor', 'examination']);
        return view('treatments.show', compact('treatment'));
    }

    /**
     * Show the form for editing the specified treatment.
     *
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function edit(Treatment $treatment)
    {
        $doctors = Doctor::all();
        return view('treatments.edit', compact('treatment', 'doctors'));
    }

    /**
     * Update the specified treatment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'treatment_type' => 'required|in:laser,anti_vegf,combined',
            'treating_doctor_id' => 'required|exists:doctors,id',
            'follow_up_date' => 'nullable|date',
            'right_eye_treated' => 'boolean',
            'left_eye_treated' => 'boolean',
            'right_eye_treatment_notes' => 'nullable|string',
            'left_eye_treatment_notes' => 'nullable|string',
            'post_treatment_instructions' => 'nullable|string',
        ]);

        $treatment->update($validated);
        $treatment->load('patient'); // Load the patient relationship

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Treatment updated successfully',
                'redirect' => route('patients.show', $treatment->patient)
            ]);
        }

        return redirect()
            ->route('patients.show', $treatment->patient)
            ->with('success', 'Treatment updated successfully');
    }

    /**
     * Remove the specified treatment from storage.
     *
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Treatment $treatment)
    {
        try {
            $treatment->delete();

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Treatment deleted successfully'
                ]);
            }

            return redirect()->route('treatments.index')
                ->with('success', 'Treatment record deleted successfully.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting treatment record.'
                ], 500);
            }

            return redirect()->route('treatments.index')
                ->with('error', 'Error deleting treatment record.');
        }
    }

    /**
     * Mark a treatment as complete.
     */
    public function complete(Treatment $treatment)
    {
        try {
            $treatment->update([
                'status' => 'completed'
            ]);

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Treatment marked as completed successfully'
                ]);
            }

            return redirect()->back()
                ->with('success', 'Treatment marked as completed successfully');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error marking treatment as completed.'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Error marking treatment as completed.');
        }
    }

    /**
     * Show patient selection page before creating a treatment.
     */
    public function selectPatient(): \Illuminate\View\View
    {
        $patients = Patient::with(['examinations' => function($query) {
            $query->latest();
        }])->orderBy('last_name')->get();
        
        return view('treatments.select-patient', compact('patients'));
    }

    /**
     * Show the form for creating a new treatment.
     */
    public function create(Patient $patient): View
    {
        $doctors = Doctor::whereHas('roles', function($query) {
            $query->where('name', 'ophthalmologist');
        })->get();
        
        $latestExamination = $patient->examinations()->latest()->first();
        
        return view('treatments.create', [
            'patient' => $patient,
            'doctors' => $doctors,
            'examination' => $latestExamination
        ]);
    }

    /**
     * Store a newly created treatment in storage.
     */
    public function store(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'treating_doctor_id' => 'required|exists:doctors,id',
            'treatment_date' => 'required|date',
            'treatment_type' => 'required|in:laser,anti_vegf,combined',
            'location' => 'required|string',
            'pre_treatment_instructions' => 'nullable|string',
            'scheduling_notes' => 'nullable|string',
            'right_eye' => 'required|boolean',
            'left_eye' => 'required|boolean',
            'examination_id' => 'nullable|exists:examinations,id'
        ]);

        // Create the treatment
        $treatment = $patient->treatments()->create([
            'treating_doctor_id' => $validated['treating_doctor_id'],
            'treatment_date' => $validated['treatment_date'],
            'treatment_type' => $validated['treatment_type'],
            'location' => $validated['location'],
            'pre_treatment_instructions' => $validated['pre_treatment_instructions'],
            'scheduling_notes' => $validated['scheduling_notes'],
            'right_eye_treated' => $validated['right_eye'],
            'left_eye_treated' => $validated['left_eye'],
            'status' => 'scheduled',
            'examination_id' => $validated['examination_id']
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Treatment scheduled successfully.',
                'treatment' => $treatment
            ]);
        }

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Treatment scheduled successfully.');
    }
}
