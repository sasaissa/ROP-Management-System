<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Select Patient for New Examination') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <input type="text" id="search" placeholder="Search patients..." class="w-full px-4 py-2 border rounded-lg">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left">Medical Record #</th>
                                    <th class="px-6 py-3 text-left">Name</th>
                                    <th class="px-6 py-3 text-left">Date of Birth</th>
                                    <th class="px-6 py-3 text-left">NICU Location</th>
                                    <th class="px-6 py-3 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="patients-table">
                                @foreach ($patients as $patient)
                                    <tr class="patient-row hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $patient->medical_record_number }}</td>
                                        <td class="px-6 py-4">{{ $patient->full_name }}</td>
                                        <td class="px-6 py-4">{{ $patient->date_of_birth->format('Y-m-d') }}</td>
                                        <td class="px-6 py-4">{{ $patient->nicu_location }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('patients.examinations.create', $patient) }}" 
                                               class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                                Create Examination
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.getElementsByClassName('patient-row');
            
            Array.from(rows).forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
