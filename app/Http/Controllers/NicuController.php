<?php

namespace App\Http\Controllers;

use App\Models\Nicu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NicuController extends Controller
{
    public function index()
    {
        $query = Nicu::with(['doctors', 'patients']);

        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $nicus = $query->paginate(10);
        return view('nicus.index', compact('nicus'));
    }

    public function create()
    {
        $doctors = User::role('nicu_doctor')->get();
        return view('nicus.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:nicus',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'doctor_ids' => 'array',
            'doctor_ids.*' => 'exists:users,id'
        ]);

        $nicu = Nicu::create($validated);

        if ($request->has('doctor_ids')) {
            $nicu->doctors()->attach($request->doctor_ids);
        }

        return redirect()->route('nicus.index')
            ->with('success', 'NICU created successfully');
    }

    public function show(Nicu $nicu)
    {
        $nicu->load(['doctors', 'patients']);
        return view('nicus.show', compact('nicu'));
    }

    public function edit(Nicu $nicu)
    {
        $doctors = User::role('nicu_doctor')->get();
        $assignedDoctors = $nicu->doctors->pluck('id')->toArray();
        return view('nicus.edit', compact('nicu', 'doctors', 'assignedDoctors'));
    }

    public function update(Request $request, Nicu $nicu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:nicus,name,' . $nicu->id,
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'doctor_ids' => 'array',
            'doctor_ids.*' => 'exists:users,id'
        ]);

        $nicu->update($validated);

        if ($request->has('doctor_ids')) {
            $nicu->doctors()->sync($request->doctor_ids);
        } else {
            $nicu->doctors()->detach();
        }

        return redirect()->route('nicus.show', $nicu)
            ->with('success', 'NICU updated successfully');
    }

    public function destroy(Nicu $nicu)
    {
        if ($nicu->patients()->count() > 0) {
            return back()->with('error', 'Cannot delete NICU with active patients');
        }

        $nicu->doctors()->detach();
        $nicu->delete();

        return redirect()->route('nicus.index')
            ->with('success', 'NICU deleted successfully');
    }

    public function assignDoctors(Request $request, Nicu $nicu)
    {
        $validated = $request->validate([
            'doctor_ids' => 'required|array',
            'doctor_ids.*' => 'exists:users,id'
        ]);

        $nicu->doctors()->sync($request->doctor_ids);

        return back()->with('success', 'Doctors assigned successfully');
    }
}
