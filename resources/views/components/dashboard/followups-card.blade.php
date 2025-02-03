@props(['dueFollowups'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-orange-600">
                Follow-ups Due
                @if($dueFollowups['count'] > 0)
                    <span class="ml-2 px-2 py-1 text-sm bg-orange-100 text-orange-800 rounded-full">
                        {{ $dueFollowups['count'] }}
                    </span>
                @endif
            </h2>
            @if($dueFollowups['overdue'] > 0)
                <span class="text-sm text-orange-600 font-medium">
                    {{ $dueFollowups['overdue'] }} overdue
                </span>
            @endif
        </div>

        @if($dueFollowups['count'] === 0)
            <p class="text-gray-500 text-sm">No follow-ups due today</p>
        @else
            <div class="space-y-4">
                @foreach($dueFollowups['examinations'] as $examination)
                    <div class="p-4 bg-orange-50 rounded-lg border border-orange-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-orange-900">
                                    <a href="{{ route('patients.show', $examination->patient) }}" class="hover:underline">
                                        {{ $examination->patient->full_name }}
                                    </a>
                                </h3>
                                <div class="mt-1 space-y-1">
                                    <p class="text-sm text-orange-700">
                                        Follow-up Due: {{ $examination->follow_up_date->format('M d, Y') }}
                                        @if($examination->follow_up_date->isPast())
                                            <span class="text-orange-600 font-medium">(Overdue)</span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-orange-700">
                                        Last Exam: {{ $examination->examination_date->format('M d, Y') }}
                                    </p>
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $examination->follow_up_date->isPast() ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $examination->follow_up_date->isPast() 
                                                ? $examination->follow_up_date->diffForHumans() . ' ago'
                                                : 'Due ' . $examination->follow_up_date->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('patients.examinations.create', $examination->patient) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-orange-300 text-sm leading-5 font-medium rounded-md text-orange-700 bg-orange-50 hover:text-orange-500 hover:bg-orange-100 focus:outline-none focus:border-orange-700 focus:shadow-outline-orange active:bg-orange-200 transition ease-in-out duration-150">
                                    New Examination
                                </a>
                                <button onclick="markFollowupComplete({{ $examination->id }})"
                                        class="inline-flex items-center px-3 py-1 border border-orange-300 text-sm leading-5 font-medium rounded-md text-white bg-orange-600 hover:bg-orange-500 focus:outline-none focus:border-orange-700 focus:shadow-outline-orange active:bg-orange-800 transition ease-in-out duration-150">
                                    Mark Complete
                                </button>
                            </div>
                        </div>
                        @if($examination->notes)
                            <div class="mt-2 text-sm text-orange-600">
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
    function markFollowupComplete(examinationId) {
        // Show loading state
        const button = event.target;
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'Marking...';

        // Make API call
        fetch(`/examinations/${examinationId}/complete-followup`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Refresh dashboard data
                refreshDashboard();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.textContent = originalText;
            button.disabled = false;
            alert('Failed to mark follow-up as complete. Please try again.');
        });
    }
</script>
@endpush
