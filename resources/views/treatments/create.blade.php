<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Schedule New Treatment
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="treatment-form" method="POST" action="{{ route('patients.treatments.store', $patient) }}" class="space-y-6">
                        @if ($errors->any())
                            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                                <div class="font-medium">{{ __('Whoops! Something went wrong.') }}</div>
                                <ul class="mt-3 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @csrf
                        <input type="hidden" name="examination_id" value="{{ $examination->id }}">

                        <!-- Treatment Date and Time -->
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label for="treatment_date" class="block text-sm font-medium text-gray-700">Treatment Date</label>
                                <input type="datetime-local" name="treatment_date" id="treatment_date" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <div class="mt-1 text-sm text-red-600 hidden" id="treatment_date-error"></div>
                            </div>
                        </div>

                        <!-- Treatment Type -->
                        <div>
                            <label for="treatment_type" class="block text-sm font-medium text-gray-700">Treatment Type</label>
                            <select name="treatment_type" id="treatment_type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select treatment type</option>
                                <option value="laser">Laser</option>
                                <option value="anti_vegf">Anti-VEGF</option>
                                <option value="combined">Combined</option>
                            </select>
                            <div class="mt-1 text-sm text-red-600 hidden" id="treatment_type-error"></div>
                        </div>

                        <!-- Treating Doctor -->
                        <div>
                            <label for="treating_doctor_id" class="block text-sm font-medium text-gray-700">Treating Doctor</label>
                            <select name="treating_doctor_id" id="treating_doctor_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select treating doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                            <div class="mt-1 text-sm text-red-600 hidden" id="treating_doctor_id-error"></div>
                        </div>

                        <!-- Treatment Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Treatment Location</label>
                            <input type="text" name="location" id="location" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="e.g., Operating Room 3, NICU Treatment Room">
                            <div class="mt-1 text-sm text-red-600 hidden" id="location-error"></div>
                        </div>

                        <!-- Eyes to be Treated -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Eyes to be Treated</label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="hidden" name="right_eye" value="0">
                                    <input type="checkbox" name="right_eye" id="right_eye" value="1"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <label for="right_eye" class="ml-2 text-sm text-gray-700">Right Eye</label>
                                </div>
                                <div class="mt-1 text-sm text-red-600 hidden" id="right_eye-error"></div>
                                <div class="flex items-center">
                                    <input type="hidden" name="left_eye" value="0">
                                    <input type="checkbox" name="left_eye" id="left_eye" value="1"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <label for="left_eye" class="ml-2 text-sm text-gray-700">Left Eye</label>
                                </div>
                                <div class="mt-1 text-sm text-red-600 hidden" id="left_eye-error"></div>
                            </div>
                        </div>

                        <!-- Pre-treatment Instructions -->
                        <div>
                            <label for="pre_treatment_instructions" class="block text-sm font-medium text-gray-700">Pre-treatment Instructions</label>
                            <textarea name="pre_treatment_instructions" id="pre_treatment_instructions" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Enter any pre-treatment instructions..."></textarea>
                            <div class="mt-1 text-sm text-red-600 hidden" id="pre_treatment_instructions-error"></div>
                        </div>

                        <!-- Scheduling Notes -->
                        <div>
                            <label for="scheduling_notes" class="block text-sm font-medium text-gray-700">Scheduling Notes</label>
                            <textarea name="scheduling_notes" id="scheduling_notes" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Enter any scheduling notes..."></textarea>
                            <div class="mt-1 text-sm text-red-600 hidden" id="scheduling_notes-error"></div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('patients.show', $patient) }}" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button id="submit-btn" type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Schedule Treatment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('treatment-form');
        const submitBtn = document.getElementById('submit-btn');
        const errorAlert = document.getElementById('error-alert');
        const errorList = document.getElementById('error-list');
        const successAlert = document.getElementById('success-alert');

        // Clear error message when input changes
        form.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('input', () => {
                const errorDiv = document.getElementById(`${input.name}-error`);
                if (errorDiv) {
                    errorDiv.textContent = '';
                    errorDiv.classList.add('hidden');
                }
            });
        });

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;

            // Reset error messages
            errorAlert.classList.add('hidden');
            errorList.innerHTML = '';
            document.querySelectorAll('[id$="-error"]').forEach(el => {
                el.textContent = '';
                el.classList.add('hidden');
            });

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: new FormData(form)
                });

                const data = await response.json();

                if (!response.ok) {
                    // Show validation errors
                    if (data.errors) {
                        errorAlert.classList.remove('hidden');
                        Object.entries(data.errors).forEach(([field, messages]) => {
                            const errorDiv = document.getElementById(`${field}-error`);
                            if (errorDiv) {
                                errorDiv.textContent = messages[0];
                                errorDiv.classList.remove('hidden');
                            }
                            errorList.innerHTML += `<li>${messages[0]}</li>`;
                        });
                    }
                } else {
                    // Show success message and redirect
                    successAlert.classList.remove('hidden');
                    setTimeout(() => {
                        window.location.href = "{{ route('patients.show', $patient) }}";
                    }, 1000);
                }
            } catch (error) {
                errorAlert.classList.remove('hidden');
                errorList.innerHTML = '<li>An unexpected error occurred. Please try again.</li>';
            }

            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Schedule Treatment';
        });
    });
</script>
@endpush
