<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb and Actions -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-gray-700">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <a href="{{ route('patients.show', $treatment->patient) }}" class="text-gray-500 hover:text-gray-700 ml-1 md:ml-2">{{ $treatment->patient->first_name }} {{ $treatment->patient->last_name }}</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-500 ml-1 md:ml-2">Treatment Details</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">Treatment Details</h2>
                        <div class="flex space-x-3">
                            <a href="{{ route('treatments.edit', $treatment) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-md shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Treatment
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Patient Information -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Patient Information</h3>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="px-4 py-3 bg-gray-50 rounded-t-lg border-b border-gray-200">
                                    <h4 class="text-lg font-medium text-gray-900">Basic Information</h4>
                                </div>
                                <div class="p-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Name</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $treatment->patient->first_name }} {{ $treatment->patient->last_name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Medical Record Number</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $treatment->patient->medical_record_number }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $treatment->patient->date_of_birth->format('Y-m-d') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="px-4 py-3 bg-gray-50 rounded-t-lg border-b border-gray-200">
                                    <h4 class="text-lg font-medium text-gray-900">Clinical Information</h4>
                                </div>
                                <div class="p-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Gestational Age</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $treatment->patient->gestational_age }} weeks</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Current Weight</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $treatment->patient->weight_at_examination }} g</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">NICU Location</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $treatment->patient->nicu_location }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Treatment Information -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Treatment Information</h3>
                    </div>
                    <div class="border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                            <!-- Right Eye Treatment -->
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="px-4 py-3 bg-gray-50 rounded-t-lg border-b border-gray-200">
                                    <h4 class="text-lg font-medium text-gray-900">Right Eye Treatment</h4>
                                </div>
                                <div class="p-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Treatment Type</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($treatment->treatment_type) }}</p>
                                    </div>
                                    @if($treatment->examination)
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Zone</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->examination->right_eye_zone ?: 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Stage</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->examination->right_eye_stage ?: 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Plus Disease</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->examination->right_eye_plus_disease ? 'Present' : 'Absent' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">AP-ROP</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->examination->right_eye_ap_rop ? 'Present' : 'Absent' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Clock Hours</label>
                                            <p class="mt-1 text-sm text-gray-900">
                                                @if(is_array($treatment->examination->right_eye_clock_hours))
                                                    {{ implode(', ', $treatment->examination->right_eye_clock_hours) }}
                                                @elseif($treatment->examination->right_eye_clock_hours)
                                                    {{ $treatment->examination->right_eye_clock_hours }}
                                                @else
                                                    Not specified
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Pre-Plus Disease</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->examination->right_eye_pre_plus ? 'Present' : 'Absent' }}</p>
                                        </div>
                                    </div>
                                    @else
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">No examination data available for this treatment.</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Treatment Notes</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $treatment->right_eye_note ?: 'No notes available' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Left Eye Treatment -->
                            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="px-4 py-3 bg-gray-50 rounded-t-lg border-b border-gray-200">
                                    <h4 class="text-lg font-medium text-gray-900">Left Eye Treatment</h4>
                                </div>
                                <div class="p-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Treatment Type</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($treatment->treatment_type) }}</p>
                                    </div>
                                    @if($treatment->examination)
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Zone</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->examination->left_eye_zone ?: 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Stage</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->examination->left_eye_stage ?: 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Plus Disease</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->examination->left_eye_plus_disease ? 'Present' : 'Absent' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">AP-ROP</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->examination->left_eye_ap_rop ? 'Present' : 'Absent' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Clock Hours</label>
                                            <p class="mt-1 text-sm text-gray-900">
                                                @if(is_array($treatment->examination->left_eye_clock_hours))
                                                    {{ implode(', ', $treatment->examination->left_eye_clock_hours) }}
                                                @elseif($treatment->examination->left_eye_clock_hours)
                                                    {{ $treatment->examination->left_eye_clock_hours }}
                                                @else
                                                    Not specified
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Pre-Plus Disease</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->examination->left_eye_pre_plus ? 'Present' : 'Absent' }}</p>
                                        </div>
                                    </div>
                                    @else
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">No examination data available for this treatment.</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Treatment Notes</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $treatment->left_eye_note ?: 'No notes available' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Treatment Details -->
                            <div class="md:col-span-2 bg-white rounded-lg border border-gray-200 shadow-sm">
                                <div class="px-4 py-3 bg-gray-50 rounded-t-lg border-b border-gray-200">
                                    <h4 class="text-lg font-medium text-gray-900">Treatment Details</h4>
                                </div>
                                <div class="p-4 space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Treatment Date</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->created_at->format('Y-m-d') }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Treating Doctor</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->treatingDoctor ? $treatment->treatingDoctor->name : 'Not assigned' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Follow-up Date</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $treatment->follow_up_date ? $treatment->follow_up_date->format('Y-m-d') : 'Not scheduled' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Post-Treatment Instructions -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900">Post-Treatment Instructions</h3>
                    </div>
                    <div class="p-6">
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                            <p class="text-sm text-gray-900">{{ $treatment->post_treatment_instructions ?: 'No instructions provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
