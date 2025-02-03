<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('medical_record_number', 'like', "%{$request->search}%")
                  ->orWhere('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%");
            });
        }

        if ($request->nicu_location) {
            $query->where('nicu_location', $request->nicu_location);
        }

        $patients = $query->paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        $patient = new Patient();
        return view('patients.create', compact('patient'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_record_number' => 'required|string|unique:patients',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gestational_age' => 'required|numeric|min:24|max:36',
            'birth_weight' => 'required|numeric|min:500|max:2500',
            'gender' => 'required|in:male,female,other',
            'nicu_location' => 'required|in:NICU-A,NICU-B',
            'medical_history' => 'array',
            'medical_history_notes' => 'nullable|string',
            'parent_contact' => 'required|string',
            'admission_date' => 'required|date'
        ]);

        $patient = Patient::create($validated);
        return redirect()->route('patients.show', $patient)->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['examinations.examiner', 'treatments.treatingDoctor']);
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'medical_record_number' => 'required|unique:patients,medical_record_number,' . $patient->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'nicu_location' => 'required|string',
            'medical_history' => 'array',
            'medical_history.*' => 'boolean',
            'medical_history_notes' => 'nullable|string',
            'parent_contact' => 'required|string',
            'admission_date' => 'required|date',
            'gestational_age' => 'required|numeric|min:24|max:36',
            'birth_weight' => 'required|numeric|min:500|max:2500',
            'weight_at_examination' => 'nullable|numeric|min:500',
            'head_circumference' => 'nullable|numeric|min:20|max:40',
            'multiple_birth_status' => 'nullable|string',
            'mode_of_delivery' => 'nullable|string',
            'maternal_complications' => 'nullable|string',
            'antenatal_steroids_received' => 'nullable|boolean',
            'days_on_oxygen' => 'nullable|integer|min:0',
            'days_on_ventilation' => 'nullable|integer|min:0',
            'highest_fio2_received' => 'nullable|numeric|min:21|max:100',
            'surfactant_therapy' => 'nullable|string',
            'post_menstrual_age' => 'nullable|numeric|min:24|max:50'
        ]);

        // Convert medical history values to booleans
        if (isset($validated['medical_history'])) {
            $validated['medical_history'] = array_map(function($value) {
                return (bool)$value;
            }, $validated['medical_history']);
        }

        $patient->update($validated);
        return redirect()->route('patients.show', $patient)->with('success', 'Patient updated successfully');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully');
    }
}
