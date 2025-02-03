<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('NICU Details') }}: {{ $nicu->name }}
            </h2>
            @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('nicus.edit', $nicu) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Edit NICU
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">NICU Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <span class="font-medium">Name:</span>
                                    <span class="ml-2">{{ $nicu->name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Location:</span>
                                    <span class="ml-2">{{ $nicu->location }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Capacity:</span>
                                    <span class="ml-2">{{ $nicu->capacity }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Status:</span>
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $nicu->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($nicu->status) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="font-medium">Description:</span>
                                    <p class="mt-1">{{ $nicu->description ?? 'No description available' }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Assigned Doctors</h3>
                            <div class="space-y-2">
                                @forelse($nicu->doctors as $doctor)
                                    <div class="flex items-center p-2 bg-gray-50 rounded">
                                        <div>
                                            <div class="font-medium">{{ $doctor->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $doctor->email }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No doctors assigned to this NICU</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-lg font-semibold mb-4">Current Patients</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-6 py-3 text-left">MRN</th>
                                            <th class="px-6 py-3 text-left">Name</th>
                                            <th class="px-6 py-3 text-left">Date of Birth</th>
                                            <th class="px-6 py-3 text-left">Admission Date</th>
                                            <th class="px-6 py-3 text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($nicu->patients as $patient)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4">{{ $patient->medical_record_number }}</td>
                                                <td class="px-6 py-4">{{ $patient->full_name }}</td>
                                                <td class="px-6 py-4">{{ $patient->date_of_birth->format('Y-m-d') }}</td>
                                                <td class="px-6 py-4">{{ $patient->admission_date->format('Y-m-d') }}</td>
                                                <td class="px-6 py-4">
                                                    <a href="{{ route('patients.show', $patient) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No patients currently in this NICU</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
