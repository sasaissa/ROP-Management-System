<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb and Header -->
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
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-500 ml-1 md:ml-2">Edit Examination</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="mt-4 text-2xl font-bold text-gray-900">Edit Examination</h1>
            </div>

            <!-- Main Content -->
            <div class="bg-white shadow-sm rounded-lg">
                <form method="POST" action="{{ route('examinations.update', $examination) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="p-6 grid grid-cols-1 gap-6">
                        <!-- Patient Information -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Patient Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $examination->patient->full_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $examination->patient->date_of_birth->format('d-m-Y') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Medical Record</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $examination->patient->medical_record }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Examination Details -->
                        <div class="border rounded-lg p-4">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Examination Details</h2>
                            
                            <!-- Examination Date -->
                            <div class="mb-4">
                                <x-input-label for="examination_date" value="Examination Date" />
                                <x-text-input id="examination_date" type="date" name="examination_date" class="mt-1 block w-full"
                                    value="{{ old('examination_date', $examination->examination_date->format('Y-m-d')) }}" required />
                                <x-input-error :messages="$errors->get('examination_date')" class="mt-2" />
                            </div>

                            <!-- Eyes Grid -->
                            <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-2">
                                <!-- Right Eye Section -->
                                <x-eye-examination-fields side="right" :examination="$examination" />

                                <!-- Left Eye Section -->
                                <x-eye-examination-fields side="left" :examination="$examination" />
                            </div>

                            <!-- Additional Information -->
                            <div class="mt-6 border rounded-lg p-4">
                                <h3 class="text-md font-medium text-gray-900 mb-4">Additional Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <x-input-label for="ap_rop" value="AP-ROP Status" />
                                        <select name="ap_rop" id="ap_rop" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="0" {{ old('ap_rop', $examination->ap_rop) == 0 ? 'selected' : '' }}>Absent</option>
                                            <option value="1" {{ old('ap_rop', $examination->ap_rop) == 1 ? 'selected' : '' }}>Present</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('ap_rop')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="plus_disease" value="Plus Disease" />
                                        <select name="plus_disease" id="plus_disease" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="0" {{ old('plus_disease', $examination->plus_disease) == 0 ? 'selected' : '' }}>Absent</option>
                                            <option value="1" {{ old('plus_disease', $examination->plus_disease) == 1 ? 'selected' : '' }}>Present</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('plus_disease')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="next_examination_date" value="Next Examination Date" />
                                        <x-text-input id="next_examination_date" type="date" name="next_examination_date" class="mt-1 block w-full"
                                            value="{{ old('next_examination_date', $examination->next_examination_date ? $examination->next_examination_date->format('Y-m-d') : '') }}" />
                                        <x-input-error :messages="$errors->get('next_examination_date')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <x-input-label for="notes" value="Notes" />
                                    <x-textarea-input id="notes" name="notes" class="mt-1 block w-full" rows="3">{{ old('notes', $examination->notes) }}</x-textarea-input>
                                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 flex items-center justify-end space-x-3 rounded-b-lg">
                        <x-secondary-button onclick="window.history.back()">Cancel</x-secondary-button>
                        <x-primary-button>Update Examination</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
