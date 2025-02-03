<div class="grid grid-cols-2 gap-6">
    <div class="col-span-2 sm:col-span-1">
        <x-input-label for="medical_record_number" value="Medical Record Number" />
        <x-text-input id="medical_record_number" type="text" name="medical_record_number" 
            value="{{ old('medical_record_number', $patient->medical_record_number ?? '') }}" 
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
        <x-input-error :messages="$errors->get('medical_record_number')" class="mt-2" />
    </div>

    <div class="col-span-2 sm:col-span-1">
        <x-input-label for="first_name" value="First Name" />
        <x-text-input id="first_name" type="text" name="first_name" 
            value="{{ old('first_name', $patient->first_name ?? '') }}" 
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
    </div>

    <div class="col-span-2 sm:col-span-1">
        <x-input-label for="last_name" value="Last Name" />
        <x-text-input id="last_name" type="text" name="last_name" 
            value="{{ old('last_name', $patient->last_name ?? '') }}" 
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
    </div>

    <div class="col-span-2 sm:col-span-1">
        <x-input-label for="date_of_birth" value="Date of Birth" />
        <x-text-input id="date_of_birth" type="date" name="date_of_birth" 
            value="{{ old('date_of_birth', $patient->date_of_birth?->format('Y-m-d') ?? '') }}" 
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
    </div>

    <div class="col-span-2 sm:col-span-1">
        <x-input-label for="gender" value="Gender" />
        <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="">Select Gender</option>
            <option value="male" {{ old('gender', $patient->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender', $patient->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ old('gender', $patient->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
    </div>

    <div class="col-span-2 sm:col-span-1">
        <x-input-label for="nicu_location" value="NICU Location" />
        <select id="nicu_location" name="nicu_location" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="">Select NICU Location</option>
            <option value="NICU-A" {{ old('nicu_location', $patient->nicu_location ?? '') == 'NICU-A' ? 'selected' : '' }}>NICU-A</option>
            <option value="NICU-B" {{ old('nicu_location', $patient->nicu_location ?? '') == 'NICU-B' ? 'selected' : '' }}>NICU-B</option>
        </select>
        <x-input-error :messages="$errors->get('nicu_location')" class="mt-2" />
    </div>

    <div class="col-span-2 sm:col-span-1">
        <x-input-label for="gestational_age" value="Gestational Age (weeks)" />
        <x-text-input id="gestational_age" type="number" name="gestational_age" 
            value="{{ old('gestational_age', $patient->gestational_age ?? '') }}" 
            min="24" max="36" 
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
        <x-input-error :messages="$errors->get('gestational_age')" class="mt-2" />
        <p class="mt-1 text-sm text-gray-500">Enter value between 24 and 36 weeks</p>
    </div>

    <div class="col-span-2 sm:col-span-1">
        <x-input-label for="birth_weight" value="Birth Weight (grams)" />
        <x-text-input id="birth_weight" type="number" name="birth_weight" 
            value="{{ old('birth_weight', $patient->birth_weight ?? '') }}" 
            min="500" max="2500" 
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
        <x-input-error :messages="$errors->get('birth_weight')" class="mt-2" />
        <p class="mt-1 text-sm text-gray-500">Enter value between 500 and 2500 grams</p>
    </div>

    <div class="col-span-2">
        <x-input-label for="parent_contact" value="Parent Contact" />
        <x-text-input id="parent_contact" type="text" name="parent_contact" 
            value="{{ old('parent_contact', $patient->parent_contact ?? '') }}" 
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
        <x-input-error :messages="$errors->get('parent_contact')" class="mt-2" />
    </div>

    <div class="col-span-2">
        <x-input-label for="medical_history" value="Medical History and Risk Factors" />
        <div class="space-y-2">
            @php
                $conditions = [
                    'respiratory_distress_syndrome' => 'Respiratory Distress Syndrome',
                    'sepsis' => 'Sepsis',
                    'blood_transfusion' => 'Blood Transfusion',
                    'patent_ductus_arteriosus' => 'Patent Ductus Arteriosus',
                    'intraventricular_hemorrhage' => 'Intraventricular Hemorrhage',
                    'necrotizing_enterocolitis' => 'Necrotizing Enterocolitis',
                    'mechanical_ventilation' => 'Mechanical Ventilation'
                ];
            @endphp

            @foreach($conditions as $key => $label)
                <div class="flex items-center">
                    <input type="hidden" name="medical_history[{{ $key }}]" value="0">
                    <input type="checkbox" 
                           id="medical_history_{{ $key }}" 
                           name="medical_history[{{ $key }}]" 
                           value="1"
                           {{ isset($patient->medical_history[$key]) && $patient->medical_history[$key] ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <label for="medical_history_{{ $key }}" class="ml-2 text-sm text-gray-600">{{ $label }}</label>
                </div>
            @endforeach

            <div class="mt-2">
                <textarea id="medical_history_notes" name="medical_history_notes" rows="3" 
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    placeholder="Additional notes about medical history, complications, or risk factors...">{{ old('medical_history_notes', $patient->medical_history_notes ?? '') }}</textarea>
            </div>
        </div>
        <x-input-error :messages="$errors->get('medical_history')" class="mt-2" />
    </div>

    <div class="col-span-2">
        <x-input-label for="admission_date" value="Admission Date" />
        <x-text-input id="admission_date" type="date" name="admission_date" 
            value="{{ old('admission_date', $patient->admission_date?->format('Y-m-d') ?? '') }}" 
            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required />
        <x-input-error :messages="$errors->get('admission_date')" class="mt-2" />
    </div>

    <div class="col-span-2">
        <h3 class="text-lg font-semibold mb-4">Birth and Growth Data</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="multiple_birth_status" value="Multiple Birth Status" />
                <select id="multiple_birth_status" name="multiple_birth_status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select status</option>
                    <option value="singleton" {{ old('multiple_birth_status', $patient->multiple_birth_status ?? '') == 'singleton' ? 'selected' : '' }}>Singleton</option>
                    <option value="twin" {{ old('multiple_birth_status', $patient->multiple_birth_status ?? '') == 'twin' ? 'selected' : '' }}>Twin</option>
                    <option value="triplet" {{ old('multiple_birth_status', $patient->multiple_birth_status ?? '') == 'triplet' ? 'selected' : '' }}>Triplet</option>
                    <option value="quadruplet" {{ old('multiple_birth_status', $patient->multiple_birth_status ?? '') == 'quadruplet' ? 'selected' : '' }}>Quadruplet</option>
                </select>
                <x-input-error :messages="$errors->get('multiple_birth_status')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="head_circumference" value="Head Circumference (cm)" />
                <x-text-input id="head_circumference" name="head_circumference" type="number" step="0.1" class="mt-1 block w-full" :value="old('head_circumference', $patient->head_circumference ?? '')" />
                <x-input-error :messages="$errors->get('head_circumference')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="col-span-2">
        <h3 class="text-lg font-semibold mb-4">Maternal Data</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="mode_of_delivery" value="Mode of Delivery" />
                <select id="mode_of_delivery" name="mode_of_delivery" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select mode</option>
                    <option value="vaginal" {{ old('mode_of_delivery', $patient->mode_of_delivery ?? '') == 'vaginal' ? 'selected' : '' }}>Vaginal Delivery</option>
                    <option value="c-section" {{ old('mode_of_delivery', $patient->mode_of_delivery ?? '') == 'c-section' ? 'selected' : '' }}>Cesarean Section</option>
                </select>
                <x-input-error :messages="$errors->get('mode_of_delivery')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="antenatal_steroids_received" value="Antenatal Steroids" />
                <div class="mt-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="antenatal_steroids_received" value="1" class="form-radio" {{ old('antenatal_steroids_received', $patient->antenatal_steroids_received ?? '') ? 'checked' : '' }}>
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" name="antenatal_steroids_received" value="0" class="form-radio" {{ old('antenatal_steroids_received', $patient->antenatal_steroids_received ?? '') === false ? 'checked' : '' }}>
                        <span class="ml-2">No</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('antenatal_steroids_received')" class="mt-2" />
            </div>

            <div class="col-span-2">
                <x-input-label for="maternal_complications" value="Maternal Complications" />
                <textarea id="maternal_complications" name="maternal_complications" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('maternal_complications', $patient->maternal_complications ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('maternal_complications')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="col-span-2">
        <h3 class="text-lg font-semibold mb-4">NICU Data</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="days_on_oxygen" value="Days on Oxygen" />
                <x-text-input id="days_on_oxygen" name="days_on_oxygen" type="number" class="mt-1 block w-full" :value="old('days_on_oxygen', $patient->days_on_oxygen ?? '')" />
                <x-input-error :messages="$errors->get('days_on_oxygen')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="days_on_ventilation" value="Days on Ventilation" />
                <x-text-input id="days_on_ventilation" name="days_on_ventilation" type="number" class="mt-1 block w-full" :value="old('days_on_ventilation', $patient->days_on_ventilation ?? '')" />
                <x-input-error :messages="$errors->get('days_on_ventilation')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="highest_fio2_received" value="Highest FiO2 Received (%)" />
                <x-text-input id="highest_fio2_received" type="number" name="highest_fio2_received" 
                    value="{{ old('highest_fio2_received', $patient->highest_fio2_received ?? '') }}" 
                    min="21" max="100" step="1"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                <p class="mt-1 text-sm text-gray-500">Must be between 21% and 100%</p>
                <x-input-error :messages="$errors->get('highest_fio2_received')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="surfactant_therapy" value="Surfactant Therapy" />
                <select id="surfactant_therapy" name="surfactant_therapy" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Select status</option>
                    <option value="not_given" {{ old('surfactant_therapy', $patient->surfactant_therapy ?? '') == 'not_given' ? 'selected' : '' }}>Not Given</option>
                    <option value="single_dose" {{ old('surfactant_therapy', $patient->surfactant_therapy ?? '') == 'single_dose' ? 'selected' : '' }}>Single Dose</option>
                    <option value="multiple_doses" {{ old('surfactant_therapy', $patient->surfactant_therapy ?? '') == 'multiple_doses' ? 'selected' : '' }}>Multiple Doses</option>
                </select>
                <x-input-error :messages="$errors->get('surfactant_therapy')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="col-span-2">
        <h3 class="text-lg font-semibold mb-4">Growth Data</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="weight_at_examination" value="Weight at Examination (g)" />
                <x-text-input id="weight_at_examination" type="number" name="weight_at_examination" 
                    value="{{ old('weight_at_examination', $patient->weight_at_examination ?? '') }}" 
                    min="500" step="1"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                <p class="mt-1 text-sm text-gray-500">Must be at least 500g</p>
                <x-input-error :messages="$errors->get('weight_at_examination')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="post_menstrual_age" value="Post-Menstrual Age (weeks)" />
                <x-text-input id="post_menstrual_age" name="post_menstrual_age" type="number" step="0.1" class="mt-1 block w-full" :value="old('post_menstrual_age', $patient->post_menstrual_age ?? '')" />
                <x-input-error :messages="$errors->get('post_menstrual_age')" class="mt-2" />
            </div>
        </div>
    </div>
</div>
