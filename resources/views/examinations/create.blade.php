<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('New Examination for Patient: ') }}
            <a href="{{ route('patients.show', $patient) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                {{ $patient->full_name }}
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('patients.examinations.store', $patient) }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                        <input type="hidden" name="examiner_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="status" value="completed">
                        <input type="hidden" name="right_eye_plus_disease" value="0">
                        <input type="hidden" name="right_eye_pre_plus" value="0">
                        <input type="hidden" name="right_eye_ap_rop" value="0">
                        <input type="hidden" name="left_eye_plus_disease" value="0">
                        <input type="hidden" name="left_eye_pre_plus" value="0">
                        <input type="hidden" name="left_eye_ap_rop" value="0">

                        <!-- Examination Date -->
                        <div>
                            <x-input-label for="examination_date" :value="__('Examination Date')" />
                            <x-text-input id="examination_date" type="date" name="examination_date" 
                                :value="old('examination_date', now()->format('Y-m-d'))" 
                                class="block w-full mt-1" required />
                            <x-input-error :messages="$errors->get('examination_date')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4 md:grid-cols-2">
                            <!-- Right Eye Section -->
                            <x-eye-examination-fields side="right" />

                            <!-- Left Eye Section -->
                            <x-eye-examination-fields side="left" />
                        </div>

                        <!-- Notes -->
                        <div class="mt-4">
                            <x-input-label for="notes" :value="__('Notes')" />
                            <x-textarea-input id="notes" name="notes" class="block w-full mt-1" rows="3">{{ old('notes') }}</x-textarea-input>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <!-- Follow-up Date -->
                        <div class="mt-4">
                            <x-input-label for="follow_up_date" :value="__('Follow-up Date (Optional)')" />
                            <x-text-input id="follow_up_date" type="date" name="follow_up_date" :value="old('follow_up_date')" class="block w-full mt-1" />
                            <p class="mt-1 text-sm text-gray-500">Leave empty to automatically set based on treatment plan suggestion</p>
                            <x-input-error :messages="$errors->get('follow_up_date')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Create Examination') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const validateEyeFields = (side) => {
                const zoneSelect = document.getElementById(`${side}_eye_zone`);
                const stageSelect = document.getElementById(`${side}_eye_stage`);
                const plusDiseaseCheckbox = document.getElementById(`${side}_eye_plus_disease`);
                const prePlusCheckbox = document.getElementById(`${side}_eye_pre_plus`);
                const apRopCheckbox = document.getElementById(`${side}_eye_ap_rop`);

                // Function to show validation message
                const showValidationMessage = (message) => {
                    const existingMsg = document.getElementById(`${side}_validation_msg`);
                    if (existingMsg) existingMsg.remove();
                    
                    const msgDiv = document.createElement('div');
                    msgDiv.id = `${side}_validation_msg`;
                    msgDiv.className = 'text-red-600 text-sm mt-2';
                    msgDiv.textContent = message;
                    apRopCheckbox.parentElement.appendChild(msgDiv);
                };

                // Clear validation message
                const clearValidationMessage = () => {
                    const existingMsg = document.getElementById(`${side}_validation_msg`);
                    if (existingMsg) existingMsg.remove();
                };

                const validateFields = () => {
                    const zone = zoneSelect.value;
                    const stage = stageSelect.value;
                    const hasPlus = plusDiseaseCheckbox.checked;
                    const hasPrePlus = prePlusCheckbox.checked;
                    const hasApRop = apRopCheckbox.checked;

                    clearValidationMessage();

                    // Validation Rule 1: AP-ROP constraints
                    if (hasApRop) {
                        if (zone === 'III' || (stage === '1' && !hasPlus)) {
                            showValidationMessage('AP-ROP typically occurs in Zone I or posterior Zone II with plus disease and higher stages');
                            apRopCheckbox.checked = false;
                            return false;
                        }
                    }

                    // Validation Rule 2: Plus and Pre-plus cannot coexist
                    if (hasPlus && hasPrePlus) {
                        showValidationMessage('An eye cannot have both plus disease and pre-plus disease');
                        prePlusCheckbox.checked = false;
                        return false;
                    }

                    // Validation Rule 3: Stage 4-5 implications
                    if (stage.startsWith('4') || stage.startsWith('5')) {
                        if (!hasPlus && !hasPrePlus) {
                            showValidationMessage('Advanced stages (4-5) typically present with plus or pre-plus disease');
                        }
                    }

                    // Validation Rule 4: Zone III constraints
                    if (zone === 'III' && hasApRop) {
                        showValidationMessage('AP-ROP is not typically found in Zone III');
                        apRopCheckbox.checked = false;
                        return false;
                    }

                    return true;
                };

                // Add event listeners
                [zoneSelect, stageSelect].forEach(element => {
                    element.addEventListener('change', validateFields);
                });

                [plusDiseaseCheckbox, prePlusCheckbox, apRopCheckbox].forEach(checkbox => {
                    checkbox.addEventListener('change', validateFields);
                });
            };

            // Initialize validation for both eyes
            validateEyeFields('right');
            validateEyeFields('left');
        });
    </script>
    @endpush
</x-app-layout>
