@props(['urgentCases'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-red-600">
                Urgent Cases
                @if($urgentCases['count'] > 0)
                    <span class="ml-2 px-2 py-1 text-sm bg-red-100 text-red-800 rounded-full">
                        {{ $urgentCases['count'] }}
                    </span>
                @endif
            </h2>
            @if($urgentCases['count'] > 0)
                <button onclick="refreshDashboard()" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            @endif
        </div>

        @if($urgentCases['count'] === 0)
            <p class="text-gray-500 text-sm">No urgent cases requiring attention</p>
        @else
            <div class="space-y-4">
                @foreach($urgentCases['examinations'] as $examination)
                    <div class="p-4 bg-red-50 rounded-lg border border-red-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-red-900">
                                    <a href="{{ route('patients.show', $examination->patient) }}" class="hover:underline">
                                        {{ $examination->patient->full_name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-red-700 mt-1">
                                    Examined: {{ $examination->examination_date->format('M d, Y') }}
                                </p>
                                <div class="mt-2 space-y-1">
                                    @if($examination->right_eye_ap_rop || ($examination->right_eye_zone === 'I' && ($examination->right_eye_stage === '3' || $examination->right_eye_plus_disease)))
                                        <p class="text-sm text-red-800">
                                            Right Eye: 
                                            @if($examination->right_eye_ap_rop)
                                                AP-ROP
                                            @else
                                                Zone {{ $examination->right_eye_zone }}, Stage {{ $examination->right_eye_stage }}
                                                {{ $examination->right_eye_plus_disease ? '(Plus)' : '' }}
                                            @endif
                                        </p>
                                    @endif
                                    @if($examination->left_eye_ap_rop || ($examination->left_eye_zone === 'I' && ($examination->left_eye_stage === '3' || $examination->left_eye_plus_disease)))
                                        <p class="text-sm text-red-800">
                                            Left Eye: 
                                            @if($examination->left_eye_ap_rop)
                                                AP-ROP
                                            @else
                                                Zone {{ $examination->left_eye_zone }}, Stage {{ $examination->left_eye_stage }}
                                                {{ $examination->left_eye_plus_disease ? '(Plus)' : '' }}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('examinations.show', $examination) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-red-300 text-sm leading-5 font-medium rounded-md text-red-700 bg-red-50 hover:text-red-500 hover:bg-red-100 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-200 transition ease-in-out duration-150">
                                    View Details
                                </a>
                                <button onclick="acceptTreatmentPlan({{ $examination->id }})"
                                        class="inline-flex items-center px-3 py-1 border border-red-300 text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-800 transition ease-in-out duration-150">
                                    Schedule Treatment
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function acceptTreatmentPlan(examinationId) {
        // Show loading state
        const button = event.target;
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'Scheduling...';

        // Make API call
        fetch(`/examinations/${examinationId}/accept-treatment-plan`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.textContent = originalText;
            button.disabled = false;
            alert('Failed to schedule treatment. Please try again.');
        });
    }
</script>
@endpush
