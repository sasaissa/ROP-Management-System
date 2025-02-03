@props(['newExaminations'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-blue-600">
                New Examinations
                @if($newExaminations['count'] > 0)
                    <span class="ml-2 px-2 py-1 text-sm bg-blue-100 text-blue-800 rounded-full">
                        {{ $newExaminations['count'] }}
                    </span>
                @endif
            </h2>
        </div>

        @if($newExaminations['count'] === 0)
            <p class="text-gray-500 text-sm">No new examinations to review</p>
        @else
            <div class="space-y-4">
                @foreach($newExaminations['examinations'] as $examination)
                    <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-blue-900">
                                    <a href="{{ route('patients.show', $examination->patient) }}" class="hover:underline">
                                        {{ $examination->patient->full_name }}
                                    </a>
                                </h3>
                                <div class="mt-1 space-y-1">
                                    <p class="text-sm text-blue-700">
                                        Examined: {{ $examination->examination_date->format('M d, Y') }}
                                    </p>
                                    <p class="text-sm text-blue-700">
                                        By: {{ $examination->examiner?->name ?? 'Unknown' }}
                                    </p>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @if($examination->right_eye_zone)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Right Eye: Zone {{ $examination->right_eye_zone }}, Stage {{ $examination->right_eye_stage }}
                                            </span>
                                        @endif
                                        @if($examination->left_eye_zone)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Left Eye: Zone {{ $examination->left_eye_zone }}, Stage {{ $examination->left_eye_stage }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('examinations.show', $examination) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-blue-300 text-sm leading-5 font-medium rounded-md text-blue-700 bg-blue-50 hover:text-blue-500 hover:bg-blue-100 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-200 transition ease-in-out duration-150">
                                    View Details
                                </a>
                                <button onclick="markExaminationReviewed({{ $examination->id }})"
                                        class="inline-flex items-center px-3 py-1 border border-blue-300 text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-800 transition ease-in-out duration-150">
                                    Mark Reviewed
                                </button>
                            </div>
                        </div>
                        @if($examination->notes)
                            <div class="mt-2 text-sm text-blue-600">
                                <p class="font-medium">Notes:</p>
                                <p>{{ $examination->notes }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function markExaminationReviewed(examinationId) {
        // Show loading state
        const button = event.target;
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'Marking...';

        // Make API call
        fetch(`/examinations/${examinationId}/mark-reviewed`, {
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
            // Remove the examination card from the UI
            const card = button.closest('.bg-blue-50');
            card.remove();
            
            // Update the count
            const countElement = document.querySelector('.text-blue-600 .text-blue-800');
            if (countElement) {
                const currentCount = parseInt(countElement.textContent);
                if (currentCount > 1) {
                    countElement.textContent = currentCount - 1;
                } else {
                    // If this was the last examination, show the "no examinations" message
                    const container = document.querySelector('.space-y-4');
                    container.innerHTML = '<p class="text-gray-500 text-sm">No new examinations to review</p>';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.textContent = originalText;
            button.disabled = false;
            alert('Failed to mark examination as reviewed. Please try again.');
        });
    }
</script>
@endpush
