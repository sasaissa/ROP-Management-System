<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ROP Management Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Section -->
            <div class="mb-6">
                <x-dashboard.statistics-card :statistics="$statistics" />
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('patients.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add New Patient
                        </a>
                        <a href="{{ route('examinations.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            New Examination
                        </a>
                        <a href="{{ route('treatments.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Record Treatment
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Urgent Cases -->
                <div class="col-span-1">
                    <x-dashboard.urgent-cases-card :urgentCases="$urgentCases" />
                </div>

                <!-- Follow-ups -->
                <div class="col-span-1">
                    <x-dashboard.followups-card :dueFollowups="$dueFollowups" />
                </div>

                <!-- New Examinations -->
                <div class="col-span-1">
                    <x-dashboard.new-examinations-card :newExaminations="$newExaminations" />
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function refreshDashboard() {
            fetch('/dashboard/refresh', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                window.location.reload();
            })
            .catch(error => {
                console.error('Error refreshing dashboard:', error);
            });
        }

        // Refresh dashboard every 5 minutes
        setInterval(refreshDashboard, 5 * 60 * 1000);
    </script>
    @endpush
</x-app-layout>