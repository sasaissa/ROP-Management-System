<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb and Actions -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg> Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <a href="{{ route('patients.show', $examination->patient) }}" class="text-gray-500 hover:text-gray-700 ml-1 md:ml-2">{{ $examination->patient->full_name }}</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-500 ml-1 md:ml-2">Examination Details</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Examination Details</h1>
                </div>
            </div>

            @php
                // Get analysis from either the view data or session flash data
                $analysisData = $analysis ?? session('analysis');
            @endphp
            
            <!-- Treatment Analysis -->
            @if(isset($analysisData))
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Suggested Treatment Plan</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Based on examination findings</p>
                        </div>
                        @if(!$examination->treatment)
                            <button 
                                type="button"
                                onclick="openConfirmModal()"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Accept Plan
                            </button>
                        @endif
                    </div>
                </div>

                <div class="border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                        <!-- Right Eye Analysis -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-3">Right Eye</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Severity:</dt>
                                    <dd class="text-sm text-gray-900 {{ $analysisData['right_eye']['urgent'] ? 'font-bold text-red-600' : '' }}">
                                        {{ ucfirst($analysisData['right_eye']['severity']) }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Recommended Treatment:</dt>
                                    <dd class="text-sm text-gray-900">{{ $analysisData['right_eye']['treatment'] }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Follow-up:</dt>
                                    <dd class="text-sm text-gray-900">{{ $analysisData['right_eye']['follow_up'] }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Left Eye Analysis -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-3">Left Eye</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Severity:</dt>
                                    <dd class="text-sm text-gray-900 {{ $analysisData['left_eye']['urgent'] ? 'font-bold text-red-600' : '' }}">
                                        {{ ucfirst($analysisData['left_eye']['severity']) }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Recommended Treatment:</dt>
                                    <dd class="text-sm text-gray-900">{{ $analysisData['left_eye']['treatment'] }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Follow-up:</dt>
                                    <dd class="text-sm text-gray-900">{{ $analysisData['left_eye']['follow_up'] }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    @if($analysisData['right_eye']['urgent'] || $analysisData['left_eye']['urgent'])
                    <div class="px-6 py-4 bg-red-50 border-t border-red-100">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Urgent Attention Required</h3>
                                <p class="mt-2 text-sm text-red-700">
                                    This case requires immediate attention. Please review and take necessary action as soon as possible.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Confirmation Modal -->
            <div id="confirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Accept Treatment Plan</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to accept this treatment plan? This action cannot be undone.
                            </p>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button id="acceptButton" onclick="acceptTreatmentPlan()" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                <span>Accept Plan</span>
                                <div id="acceptSpinner" class="hidden inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                            </button>
                            <button onclick="closeConfirmModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300 ml-2">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-8">
                <!-- Basic Info -->
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Examination Information</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Conducted on {{ $examination->examination_date->format('d-m-Y') }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $examination->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($examination->status) }}
                        </span>
                    </div>
                </div>

                <!-- Examination Details Grid -->
                <div class="border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">

<!-- Right Eye Section -->
<div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="px-4 py-3 bg-gray-50 rounded-t-lg border-b border-gray-200">
                                <h4 class="text-lg font-medium text-gray-900">Right Eye</h4>
                            </div>
                            <div class="p-4 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Zone</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $examination->right_eye_zone ?? 'Not specified' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Stage</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $examination->right_eye_stage ?? 'Not specified' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Clock Hours</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if(is_array($examination->right_eye_clock_hours))
                                                {{ implode(', ', $examination->right_eye_clock_hours) }}
                                            @elseif($examination->right_eye_clock_hours)
                                                {{ $examination->right_eye_clock_hours }}
                                            @else
                                                Not specified
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Disease Status</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if($examination->right_eye_plus_disease || $examination->right_eye_pre_plus || $examination->right_eye_ap_rop)
                                                <ul class="list-disc list-inside">
                                                    @if($examination->right_eye_plus_disease)
                                                        <li>Plus Disease</li>
                                                    @endif
                                                    @if($examination->right_eye_pre_plus)
                                                        <li>Pre-plus Disease</li>
                                                    @endif
                                                    @if($examination->right_eye_ap_rop)
                                                        <li>AP-ROP</li>
                                                    @endif
                                                </ul>
                                            @else
                                                None
                                            @endif
                                        </dd>
                                    </div>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $examination->right_eye_description ?? 'No description provided' }}</dd>
                                </div>
                            </div>
                        </div>

                        <!-- Left Eye Section -->
                        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="px-4 py-3 bg-gray-50 rounded-t-lg border-b border-gray-200">
                                <h4 class="text-lg font-medium text-gray-900">Left Eye</h4>
                            </div>
                            <div class="p-4 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Zone</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $examination->left_eye_zone ?? 'Not specified' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Stage</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $examination->left_eye_stage ?? 'Not specified' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Clock Hours</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if(is_array($examination->left_eye_clock_hours))
                                                {{ implode(', ', $examination->left_eye_clock_hours) }}
                                            @elseif($examination->left_eye_clock_hours)
                                                {{ $examination->left_eye_clock_hours }}
                                            @else
                                                Not specified
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Disease Status</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if($examination->left_eye_plus_disease || $examination->left_eye_pre_plus || $examination->left_eye_ap_rop)
                                                <ul class="list-disc list-inside">
                                                    @if($examination->left_eye_plus_disease)
                                                        <li>Plus Disease</li>
                                                    @endif
                                                    @if($examination->left_eye_pre_plus)
                                                        <li>Pre-plus Disease</li>
                                                    @endif
                                                    @if($examination->left_eye_ap_rop)
                                                        <li>AP-ROP</li>
                                                    @endif
                                                </ul>
                                            @else
                                                None
                                            @endif
                                        </dd>
                                    </div>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $examination->left_eye_description ?? 'No description provided' }}</dd>
                                </div>
                            </div>
                        </div>

                        

                        <!-- Additional Information -->
                        <div class="md:col-span-2 bg-white rounded-lg border border-gray-200 shadow-sm">
                            <div class="px-4 py-3 bg-gray-50 rounded-t-lg border-b border-gray-200">
                                <h4 class="text-lg font-medium text-gray-900">Additional Information</h4>
                            </div>
                            <div class="p-4 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">AP-ROP Status</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if($examination->right_eye_ap_rop)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">
                                                    Right Eye: Present
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                                                    Right Eye: Absent
                                                </span>
                                            @endif
                                            @if($examination->left_eye_ap_rop)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Left Eye: Present
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Left Eye: Absent
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Plus Disease</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if($examination->right_eye_plus_disease)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">
                                                    Right Eye: Present
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                                                    Right Eye: Absent
                                                </span>
                                            @endif
                                            @if($examination->left_eye_plus_disease)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Left Eye: Present
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Left Eye: Absent
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Next Examination</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $examination->next_examination_date ? $examination->next_examination_date->format('d-m-Y') : 'Not scheduled' }}</dd>
                                    </div>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $examination->notes ?? 'No additional notes' }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($examination->treatmentPlan)
                <!-- Treatment Plan Section -->
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Treatment Plan</h3>
                    <p class="mt-1 text-sm text-gray-500">Status: {{ ucfirst($examination->treatmentPlan->status) }}</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    @php
                        $plan = json_decode($examination->treatmentPlan->suggested_treatment, true);
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Right Eye Plan -->
                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <h4 class="font-medium text-gray-900 mb-2">Right Eye Plan</h4>
                            <dl class="divide-y divide-gray-200">
                                <div class="py-2">
                                    <dt class="text-sm font-medium text-gray-500">Severity</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $plan['right_eye']['severity'])) }}</dd>
                                </div>
                                <div class="py-2">
                                    <dt class="text-sm font-medium text-gray-500">Treatment</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $plan['right_eye']['treatment'])) }}</dd>
                                </div>
                                @if(isset($plan['right_eye']['treatment_type']))
                                    <div class="py-2">
                                        <dt class="text-sm font-medium text-gray-500">Treatment Type</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $plan['right_eye']['treatment_type'])) }}</dd>
                                    </div>
                                @endif
                                <div class="py-2">
                                    <dt class="text-sm font-medium text-gray-500">Follow-up</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $plan['right_eye']['followup'])) }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Left Eye Plan -->
                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <h4 class="font-medium text-gray-900 mb-2">Left Eye Plan</h4>
                            <dl class="divide-y divide-gray-200">
                                <div class="py-2">
                                    <dt class="text-sm font-medium text-gray-500">Severity</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $plan['left_eye']['severity'])) }}</dd>
                                </div>
                                <div class="py-2">
                                    <dt class="text-sm font-medium text-gray-500">Treatment</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $plan['left_eye']['treatment'])) }}</dd>
                                </div>
                                @if(isset($plan['left_eye']['treatment_type']))
                                    <div class="py-2">
                                        <dt class="text-sm font-medium text-gray-500">Treatment Type</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $plan['left_eye']['treatment_type'])) }}</dd>
                                    </div>
                                @endif
                                <div class="py-2">
                                    <dt class="text-sm font-medium text-gray-500">Follow-up</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $plan['left_eye']['followup'])) }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Overall Recommendation -->
                    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Overall Recommendation</h3>
                                <p class="mt-2 text-sm text-yellow-700">{{ $plan['overall_recommendation'] }}</p>
                            </div>
                        </div>
                    </div>

                    @if($examination->treatmentPlan->status === 'suggested')
                        <div class="mt-6 flex space-x-3">
                            <form action="{{ route('treatment-plans.accept', $examination->treatmentPlan) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Accept Plan
                                </button>
                            </form>
                            <form action="{{ route('treatment-plans.cancel', $examination->treatmentPlan) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel Plan
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
    function acceptTreatmentPlan() {
        fetch(window.location.href + '/accept-treatment-plan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.message) {
                sessionStorage.setItem('success_message', data.message);
            }
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing your request. Please try again.');
        });
    }

    function openConfirmModal() {
        const modal = document.getElementById('confirmModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Wait for DOM to be loaded
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('confirmModal');
        
        // Add click outside listener if modal exists
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeConfirmModal();
                }
            });
        }

        // Add escape key listener
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeConfirmModal();
            }
        });
    });
</script>
