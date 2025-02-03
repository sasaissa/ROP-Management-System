<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Patient Details') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('patients.examinations.create', $patient) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    New Examination
                </a>
                <a href="{{ route('patients.edit', $patient) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Patient
                </a>
                <a href="{{ route('patients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Patient Summary Card -->
            <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow p-6">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</h3>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <span class="inline-flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                MRN: {{ $patient->medical_record_number }}
                            </span>
                            <span class="inline-flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                DOB: {{ $patient->date_of_birth->format('d-m-Y') }}
                            </span>
                            <span class="inline-flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                NICU: {{ $patient->nicu_location }}
                            </span>
                        </div>
                    </div>
                    <!-- Quick Stats -->
                    <div class="hidden md:flex space-x-4">
                        <div class="text-center">
                            <span class="text-sm font-medium text-gray-500">Next Exam</span>
                            <p class="text-lg font-semibold text-blue-600">Pending</p>
                        </div>
                        <div class="text-center">
                            <span class="text-sm font-medium text-gray-500">Last Treatment</span>
                            <p class="text-lg font-semibold text-blue-600">None</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Tabs -->
            <div class="mb-6">
                <nav class="flex space-x-4" aria-label="Tabs" x-data="{ 
                    activeTab: 'overview',
                    switchTab(tab) {
                        this.activeTab = tab;
                        if (tab !== 'overview') {
                            setTimeout(() => {
                                document.getElementById(tab + '-section').scrollIntoView({ behavior: 'smooth' });
                            }, 150);
                        }
                    }
                }">
                    <button @click="switchTab('overview')" 
                            :class="{ 'text-blue-700 bg-blue-100': activeTab === 'overview', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'overview' }"
                            class="px-3 py-2 text-sm font-medium rounded-md">
                        Overview
                    </button>
                    <button @click="switchTab('examinations')"
                            :class="{ 'text-blue-700 bg-blue-100': activeTab === 'examinations', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'examinations' }"
                            class="px-3 py-2 text-sm font-medium rounded-md">
                        Examinations
                    </button>
                    <button @click="switchTab('treatments')"
                            :class="{ 'text-blue-700 bg-blue-100': activeTab === 'treatments', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'treatments' }"
                            class="px-3 py-2 text-sm font-medium rounded-md">
                        Treatments
                    </button>
                    <button @click="switchTab('images')"
                            :class="{ 'text-blue-700 bg-blue-100': activeTab === 'images', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'images' }"
                            class="px-3 py-2 text-sm font-medium rounded-md">
                        Images
                    </button>
                    <button @click="switchTab('reports')"
                            :class="{ 'text-blue-700 bg-blue-100': activeTab === 'reports', 'text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'reports' }"
                            class="px-3 py-2 text-sm font-medium rounded-md">
                        Reports
                    </button>
                </nav>

                <!-- Tab Content -->
                <div class="mt-4">
                    <!-- Overview Tab -->
                    <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <!-- Existing overview content -->
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Patient Summary</h2>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <!-- Left Column - Patient Info -->
                                    <div class="lg:col-span-2 space-y-6">
                                        <!-- Birth and Growth Data -->
                                        <div class="bg-white rounded-lg shadow">
                                            <div class="px-4 py-5 sm:p-6">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    Birth and Growth Data
                                                </h3>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Birth Weight</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $patient->birth_weight }} g</dd>
                                                    </div>
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Current Weight</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $patient->weight_at_examination }} g</dd>
                                                    </div>
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Gestational Age</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $patient->gestational_age }} weeks</dd>
                                                    </div>
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Post-menstrual Age</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $patient->post_menstrual_age }} weeks</dd>
                                                    </div>
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Head Circumference</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $patient->head_circumference }} cm</dd>
                                                    </div>
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Multiple Birth</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ ucfirst($patient->multiple_birth_status) }}</dd>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Maternal Data -->
                                        <div class="bg-white rounded-lg shadow">
                                            <div class="px-4 py-5 sm:p-6">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                    </svg>
                                                    Maternal Data
                                                </h3>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Mode of Delivery</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ ucfirst($patient->mode_of_delivery) }}</dd>
                                                    </div>
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Antenatal Steroids</dt>
                                                        <dd class="mt-1">
                                                            @if($patient->antenatal_steroids_received)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                    Received
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                    Not Received
                                                                </span>
                                                            @endif
                                                        </dd>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- NICU Data -->
                                        <div class="bg-white rounded-lg shadow">
                                            <div class="px-4 py-5 sm:p-6">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                    </svg>
                                                    NICU Data
                                                </h3>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Days on Oxygen</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $patient->days_on_oxygen }} days</dd>
                                                    </div>
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Days on Ventilation</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $patient->days_on_ventilation }} days</dd>
                                                    </div>
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Highest FiO2 Received</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $patient->highest_fio2_received }}%</dd>
                                                    </div>
                                                    <div class="bg-gray-50 rounded p-3">
                                                        <dt class="text-sm font-medium text-gray-500">Surfactant Therapy</dt>
                                                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $patient->surfactant_therapy)) }}</dd>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Medical History -->
                                        <div class="bg-white rounded-lg shadow">
                                            <div class="px-4 py-5 sm:p-6">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    Medical History
                                                </h3>
                                                
                                                @php
                                                    $allConditions = [
                                                        'respiratory_support_required' => 'Respiratory Support Required',
                                                        'respiratory_distress_syndrome' => 'Respiratory Distress Syndrome',
                                                        'sepsis' => 'Sepsis',
                                                        'blood_transfusion' => 'Blood Transfusion',
                                                        'patent_ductus_arteriosus' => 'Patent Ductus Arteriosus',
                                                        'intraventricular_hemorrhage' => 'Intraventricular Hemorrhage',
                                                        'necrotizing_enterocolitis' => 'Necrotizing Enterocolitis',
                                                        'mechanical_ventilation' => 'Mechanical Ventilation'
                                                    ];

                                                    $presentConditions = [];
                                                    
                                                    // Check both direct properties and medical_history array
                                                    foreach ($allConditions as $key => $label) {
                                                        if ((isset($patient->$key) && $patient->$key) || 
                                                            (isset($patient->medical_history[$key]) && $patient->medical_history[$key])) {
                                                            $presentConditions[] = $label;
                                                        }
                                                    }
                                                    
                                                    // Remove duplicates
                                                    $presentConditions = array_unique($presentConditions);
                                                @endphp

                                                @if(count($presentConditions) > 0)
                                                    <div class="grid grid-cols-2 gap-4">
                                                        @foreach($presentConditions as $condition)
                                                            <div class="bg-yellow-50 rounded p-3 border border-yellow-100">
                                                                <span class="text-sm font-medium text-yellow-800">{{ $condition }}</span>
                                                                <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                    Present
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="text-center py-4 text-gray-500">
                                                        No significant medical conditions reported
                                                    </div>
                                                @endif

                                                @if($patient->medical_history_notes)
                                                    <div class="mt-6 bg-gray-50 rounded p-4">
                                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Additional Notes</h4>
                                                        <p class="text-sm text-gray-700">{{ $patient->medical_history_notes }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column - Quick Actions and Upcoming -->
                                    <div class="space-y-6">
                                        <!-- Quick Actions -->
                                        <div class="bg-white rounded-lg shadow">
                                            <div class="px-4 py-5 sm:p-6">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                                                <div class="space-y-3">
                                                    <a href="{{ route('patients.examinations.create', $patient) }}" class="block w-full px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                                        New Examination
                                                    </a>
                                                    <a href="{{ route('patients.treatments.create', $patient) }}" class="block w-full px-4 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-md hover:bg-green-700">
                                                        Schedule Treatment
                                                    </a>
                                                    <a href="#" class="block w-full px-4 py-2 text-sm font-medium text-center text-white bg-purple-600 rounded-md hover:bg-purple-700">
                                                        Upload Images
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Recent Examinations -->
                                        <div class="bg-white rounded-lg shadow">
                                            <div class="px-4 py-5 sm:p-6">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Examinations</h3>
                                                <div class="space-y-3">
                                                    @forelse($patient->examinations()->latest()->take(5)->get() as $examination)
                                                        <a href="{{ route('examinations.show', $examination) }}" class="flex items-center justify-between p-3 text-base font-medium text-gray-600 rounded-lg bg-gray-50 hover:bg-gray-100 hover:text-gray-900">
                                                            <div class="flex items-center">
                                                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                                </svg>
                                                                <span>{{ $examination->examination_date->format('d-m-Y') }}</span>
                                                            </div>
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $examination->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                                {{ ucfirst($examination->status) }}
                                                            </span>
                                                        </a>
                                                    @empty
                                                        <p class="text-gray-500 text-sm">No examinations yet.</p>
                                                    @endforelse
                                                    
                                                    @if($patient->examinations()->count() > 5)
                                                        <div class="text-center mt-4">
                                                            <a href="{{ route('examinations.index', ['patient_id' => $patient->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-900">View all examinations</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Upcoming Appointments -->
                                        <div class="bg-white rounded-lg shadow">
                                            <div class="px-4 py-5 sm:p-6">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Appointments</h3>
                                                <div class="text-sm text-gray-500 text-center py-8">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <p class="mt-2">No upcoming appointments</p>
                                                    <button class="mt-4 text-blue-600 hover:text-blue-800">Schedule Follow-up</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Recent Activity -->
                                        <div class="bg-white rounded-lg shadow">
                                            <div class="px-4 py-5 sm:p-6">
                                                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                                                <div class="text-sm text-gray-500 text-center py-8">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <p class="mt-2">No recent activity</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Examinations Tab -->
                    <div id="examinations-section" x-show="activeTab === 'examinations'" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Examination History</h2>
                                    <a href="{{ route('patients.examinations.create', $patient) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        New Examination
                                    </a>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Right Eye</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Left Eye</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AP-ROP Status</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plus Disease Status</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Examiner</th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($patient->examinations->sortByDesc('examination_date') as $examination)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $examination->examination_date->format('d-m-Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Zone {{ $examination->right_eye_zone }}, Stage {{ $examination->right_eye_stage }}
                                                        {!! $examination->right_eye_plus ? '<br>Plus Disease' : '' !!}
                                                        {!! $examination->right_eye_pre_plus ? '<br>Pre-plus Disease' : '' !!}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Zone {{ $examination->left_eye_zone }}, Stage {{ $examination->left_eye_stage }}
                                                        {!! $examination->left_eye_plus ? '<br>Plus Disease' : '' !!}
                                                        {!! $examination->left_eye_pre_plus ? '<br>Pre-plus Disease' : '' !!}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="space-y-1">
                                                            @if($examination->right_eye_ap_rop)
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                    Right: Present
                                                                </span>
                                                            @endif
                                                            @if($examination->left_eye_ap_rop)
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                    Left: Present
                                                                </span>
                                                            @endif
                                                            @if(!$examination->right_eye_ap_rop && !$examination->left_eye_ap_rop)
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    Both: Absent
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="space-y-1">
                                                            @if($examination->right_eye_plus_disease)
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                    Right: Present
                                                                </span>
                                                            @endif
                                                            @if($examination->left_eye_plus_disease)
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                    Left: Present
                                                                </span>
                                                            @endif
                                                            @if(!$examination->right_eye_plus_disease && !$examination->left_eye_plus_disease)
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    Both: Absent
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $examination->examiner ? $examination->examiner->name : 'No examiner assigned' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <div class="flex items-center justify-end space-x-3">
                                                            <a href="{{ route('examinations.show', $examination) }}" 
                                                               class="text-blue-600 hover:text-blue-900"
                                                               title="View Examination">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                </svg>
                                                            </a>

                                                            <a href="{{ route('examinations.edit', $examination) }}"
                                                               class="text-yellow-600 hover:text-yellow-900"
                                                               title="Edit Examination">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                </svg>
                                                            </a>
                                                            
                                                            <button onclick="handleExaminationDelete({{ $examination->id }}, this)"
                                                                    class="text-red-600 hover:text-red-900"
                                                                    title="Delete Examination">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Treatments Tab -->
                    <div id="treatments-section" x-show="activeTab === 'treatments'" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Treatment History</h2>
                                    <a href="{{ route('treatments.create', ['patient_id' => $patient->id]) }}"
                                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Schedule Treatment
                                    </a>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eyes Treated</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($patient->treatments->sortByDesc('treatment_date') as $treatment)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $treatment->treatment_date->format('M d, Y H:i') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ Str::title(str_replace('_', ' ', $treatment->treatment_type)) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $treatment->location }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            {{ $treatment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                               ($treatment->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : 
                                                               'bg-gray-100 text-gray-800') }}">
                                                            {{ Str::title($treatment->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        @if($treatment->right_eye_treated && $treatment->left_eye_treated)
                                                            Both Eyes
                                                        @elseif($treatment->right_eye_treated)
                                                            Right Eye
                                                        @elseif($treatment->left_eye_treated)
                                                            Left Eye
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $treatment->treatingDoctor->name ?? 'Not Assigned' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <div class="flex items-center justify-end space-x-3">
                                                            <a href="{{ route('treatments.show', $treatment) }}" 
                                                               class="text-blue-600 hover:text-blue-900"
                                                               title="View Treatment">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                </svg>
                                                            </a>
                                                            
                                                            @if($treatment->status === 'scheduled')
                                                                <button onclick="handleComplete({{ $treatment->id }}, this)"
                                                                        class="text-green-600 hover:text-green-900"
                                                                        title="Mark as Complete">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                    </svg>
                                                                </button>
                                                            @endif

                                                            <a href="{{ route('treatments.edit', $treatment) }}"
                                                               class="text-yellow-600 hover:text-yellow-900"
                                                               title="Edit Treatment">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                </svg>
                                                            </a>
                                                            
                                                            <button onclick="handleDelete({{ $treatment->id }}, this)"
                                                                    class="text-red-600 hover:text-red-900"
                                                                    title="Delete Treatment">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Images Tab -->
                    <div id="images-section" x-show="activeTab === 'images'" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Image Gallery</h2>
                                    <a href="#" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Upload Images
                                    </a>
                                </div>
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No images</h3>
                                    <p class="mt-1 text-sm text-gray-500">Upload retinal images to start building the gallery.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reports Tab -->
                    <div id="reports-section" x-show="activeTab === 'reports'" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Reports</h2>
                                    <a href="#" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Generate Report
                                    </a>
                                </div>
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No reports</h3>
                                    <p class="mt-1 text-sm text-gray-500">Generate reports to track patient progress over time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ showScrollTop: false }" class="fixed bottom-8 right-8">
        <button
            @scroll.window="showScrollTop = (window.pageYOffset > 100)"
            x-show="showScrollTop"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="bg-blue-600 text-white rounded-full p-3 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg z-50"
            aria-label="Scroll to top">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    </div>

    <!-- JavaScript for AJAX actions -->
    <script>
        function handleDelete(treatmentId, button) {
            if (confirm('Are you sure you want to delete this treatment?')) {
                fetch(`/treatments/${treatmentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        button.closest('tr').remove();
                        
                        // Show success notification
                        showNotification('Treatment deleted successfully', 'success');
                    }
                })
                .catch(error => {
                    showNotification('Error deleting treatment', 'error');
                });
            }
        }

        function handleComplete(treatmentId, button) {
            fetch(`/treatments/${treatmentId}/complete`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the status badge
                    const statusCell = button.closest('tr').querySelector('td:nth-child(4)');
                    statusCell.innerHTML = `
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Completed
                        </span>
                    `;
                    
                    // Hide the complete button
                    button.style.display = 'none';
                    
                    // Show success notification
                    showNotification('Treatment marked as completed', 'success');
                }
            })
            .catch(error => {
                showNotification('Error completing treatment', 'error');
            });
        }

        function handleExaminationDelete(examinationId, button) {
            if (confirm('Are you sure you want to delete this examination?')) {
                fetch(`/examinations/${examinationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        button.closest('tr').remove();
                        
                        // Show success notification
                        showNotification('Examination deleted successfully', 'success');
                    }
                })
                .catch(error => {
                    showNotification('Error deleting examination', 'error');
                });
            }
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} transition-opacity duration-500`;
            notification.style.zIndex = '50';
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Fade out and remove after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }
    </script>
</x-app-layout>
