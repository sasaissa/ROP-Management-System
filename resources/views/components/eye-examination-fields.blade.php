@props(['side', 'examination' => null])

<div class="p-6 border rounded-lg bg-white shadow-sm">
    <h3 class="mb-4 text-xl font-semibold text-gray-800">{{ ucfirst($side) }} Eye</h3>
    
    <!-- Primary Assessment Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <!-- Zone Selection -->
        <div>
            <x-tooltip text="The zone indicates the location of ROP in relation to the retina:
            Zone I: Within 2 disc diameters of the optic nerve
            Zone II: From Zone I to the nasal ora serrata
            Zone III: The remaining temporal crescent">
                <x-input-label for="{{ $side }}_eye_zone" :value="__('Zone')" class="font-medium" />
            </x-tooltip>
            <select name="{{ $side }}_eye_zone" id="{{ $side }}_eye_zone" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Select Zone</option>
                <option value="I" {{ old($side.'_eye_zone', $examination ? $examination->{$side.'_eye_zone'} : '') === 'I' ? 'selected' : '' }}>I</option>
                <option value="posterior II" {{ old($side.'_eye_zone', $examination ? $examination->{$side.'_eye_zone'} : '') === 'posterior II' ? 'selected' : '' }}>Posterior II</option>
                <option value="II" {{ old($side.'_eye_zone', $examination ? $examination->{$side.'_eye_zone'} : '') === 'II' ? 'selected' : '' }}>II</option>
                <option value="III" {{ old($side.'_eye_zone', $examination ? $examination->{$side.'_eye_zone'} : '') === 'III' ? 'selected' : '' }}>III</option>
            </select>
            <x-input-error :messages="$errors->get($side.'_eye_zone')" class="mt-2" />
        </div>

        <!-- Stage Selection -->
        <div>
            <x-tooltip text="Stage describes the severity of abnormal blood vessel growth:
            Stage 1: Demarcation line
            Stage 2: Ridge
            Stage 3: Ridge with extraretinal fibrovascular proliferation
            Stage 4A/B: Partial retinal detachment
            Stage 5A/B/C: Complete retinal detachment with different funnel configurations">
                <x-input-label for="{{ $side }}_eye_stage" :value="__('Stage')" class="font-medium" />
            </x-tooltip>
            <select name="{{ $side }}_eye_stage" id="{{ $side }}_eye_stage" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Select Stage</option>
                @foreach(['1', '2', '3', '4A', '4B', '5A', '5B', '5C'] as $stage)
                    <option value="{{ $stage }}" {{ old($side.'_eye_stage', $examination ? $examination->{$side.'_eye_stage'} : '') == $stage ? 'selected' : '' }}>{{ $stage }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get($side.'_eye_stage')" class="mt-2" />
        </div>
    </div>

    <!-- Disease Status Section -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <x-tooltip text="Disease status includes additional characteristics that indicate the severity and progression of ROP">
            <h4 class="text-lg font-medium mb-4 text-gray-700">Disease Status</h4>
        </x-tooltip>
        <div class="grid grid-cols-1 gap-4">
            <!-- Plus Disease -->
            <div class="flex items-center">
                <input type="checkbox" 
                    name="{{ $side }}_eye_plus_disease" 
                    id="{{ $side }}_eye_plus_disease" 
                    value="1"
                    {{ old($side.'_eye_plus_disease', $examination ? $examination->{$side.'_eye_plus_disease'} : false) ? 'checked' : '' }}
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <x-tooltip text="Plus disease indicates increased blood vessel dilation and tortuosity">
                    <label for="{{ $side }}_eye_plus_disease" class="ml-2 block text-sm font-medium text-gray-700">Plus Disease</label>
                </x-tooltip>
            </div>

            <!-- Pre-plus Disease -->
            <div class="flex items-center">
                <input type="checkbox" 
                    name="{{ $side }}_eye_pre_plus" 
                    id="{{ $side }}_eye_pre_plus" 
                    value="1"
                    {{ old($side.'_eye_pre_plus', $examination ? $examination->{$side.'_eye_pre_plus'} : false) ? 'checked' : '' }}
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <x-tooltip text="Pre-plus disease indicates abnormal vessel changes not meeting plus disease criteria">
                    <label for="{{ $side }}_eye_pre_plus" class="ml-2 block text-sm font-medium text-gray-700">Pre-plus Disease</label>
                </x-tooltip>
            </div>

            <!-- AP-ROP -->
            <div class="flex items-center">
                <input type="checkbox" 
                    name="{{ $side }}_eye_ap_rop" 
                    id="{{ $side }}_eye_ap_rop" 
                    value="1"
                    {{ old($side.'_eye_ap_rop', $examination ? $examination->{$side.'_eye_ap_rop'} : false) ? 'checked' : '' }}
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <x-tooltip text="Aggressive Posterior ROP (AP-ROP) is a severe, rapidly progressing form">
                    <label for="{{ $side }}_eye_ap_rop" class="ml-2 block text-sm font-medium text-gray-700">AP-ROP</label>
                </x-tooltip>
            </div>
        </div>
    </div>

    <!-- Clock Hours Section -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-2">
            <x-tooltip text="Clock hours represent the extent of ROP around the retinal circumference:
            - Uses a clock face analogy (1-12)
            - Helps document the extent and location of ROP
            - Important for tracking disease progression and planning treatment">
                <x-input-label :value="__('Extent (Clock Hours)')" class="text-lg font-medium" />
            </x-tooltip>
            <span class="text-sm text-gray-500">Select all affected hours</span>
        </div>
        <div class="p-4 bg-gray-50 rounded-lg">
            @php
                $clockHours = old($side.'_eye_clock_hours', 
                    $examination && is_array($examination->{$side.'_eye_clock_hours'}) 
                        ? $examination->{$side.'_eye_clock_hours'}
                        : ($examination && is_string($examination->{$side.'_eye_clock_hours'})
                            ? explode(',', $examination->{$side.'_eye_clock_hours'})
                            : []));
            @endphp
            
            <div class="flex flex-col space-y-6">
                <!-- Row 1: 12, 1, 2, 3, 4 -->
                <div class="flex flex-wrap justify-center gap-4">
                    @foreach([12, 1, 2, 3, 4] as $hour)
                        <label class="inline-flex items-center bg-white px-6 py-3 rounded-lg border hover:border-indigo-500 cursor-pointer min-w-[80px] justify-center">
                            <input type="checkbox" 
                                   name="{{ $side }}_eye_clock_hours[]" 
                                   value="{{ $hour }}"
                                   {{ in_array($hour, $clockHours) ? 'checked' : '' }}
                                   class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-lg font-medium">{{ $hour }}</span>
                        </label>
                    @endforeach
                </div>

                <!-- Row 2: 5, 6, 7, 8 -->
                <div class="flex flex-wrap justify-center gap-4">
                    @foreach([5, 6, 7, 8] as $hour)
                        <label class="inline-flex items-center bg-white px-6 py-3 rounded-lg border hover:border-indigo-500 cursor-pointer min-w-[80px] justify-center">
                            <input type="checkbox" 
                                   name="{{ $side }}_eye_clock_hours[]" 
                                   value="{{ $hour }}"
                                   {{ in_array($hour, $clockHours) ? 'checked' : '' }}
                                   class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-lg font-medium">{{ $hour }}</span>
                        </label>
                    @endforeach
                </div>

                <!-- Row 3: 9, 10, 11 -->
                <div class="flex flex-wrap justify-center gap-4">
                    @foreach([9, 10, 11] as $hour)
                        <label class="inline-flex items-center bg-white px-6 py-3 rounded-lg border hover:border-indigo-500 cursor-pointer min-w-[80px] justify-center">
                            <input type="checkbox" 
                                   name="{{ $side }}_eye_clock_hours[]" 
                                   value="{{ $hour }}"
                                   {{ in_array($hour, $clockHours) ? 'checked' : '' }}
                                   class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <span class="ml-2 text-lg font-medium">{{ $hour }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Vascular Characteristics Section -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <x-tooltip text="Vascular characteristics help assess the severity and progression of ROP">
            <h4 class="text-lg font-medium mb-4 text-gray-700">Vascular Characteristics</h4>
        </x-tooltip>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach([
                'arteriolar_tortuosity' => ['label' => 'Arteriolar Tortuosity', 'tooltip' => 'Increased winding of arteriolar vessels, a key indicator of disease severity'],
                'venular_dilation' => ['label' => 'Venular Dilation', 'tooltip' => 'Enlargement of venular vessels, often associated with disease progression'],
                'iris_vessel_dilation' => ['label' => 'Iris Vessel Dilation', 'tooltip' => 'Dilation of iris vessels, can indicate advanced disease'],
                'vitreous_haze' => ['label' => 'Vitreous Haze', 'tooltip' => 'Cloudiness in the vitreous, may indicate inflammation or hemorrhage']
            ] as $key => $details)
                <div class="flex items-center bg-white p-3 rounded shadow-sm">
                    <x-tooltip :text="$details['tooltip']">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="{{ $side }}_eye_{{ $key }}" 
                                   id="{{ $side }}_eye_{{ $key }}" 
                                   class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                   {{ old($side.'_eye_'.$key, $examination ? $examination->{$side.'_eye_'.$key} : '') ? 'checked' : '' }}>
                            <label for="{{ $side }}_eye_{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">{{ $details['label'] }}</label>
                        </div>
                    </x-tooltip>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Detachment Section (Conditional) -->
    <div id="{{ $side }}_eye_detachment_section" class="mb-6 p-4 bg-gray-50 rounded-lg" style="display: none;">
        <x-tooltip text="Retinal detachment details are crucial for stages 4 and 5:
        - Affects visual prognosis
        - Guides treatment decisions
        - Helps monitor disease progression">
            <h4 class="text-lg font-medium mb-4 text-gray-700">Retinal Detachment Details</h4>
        </x-tooltip>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Funnel Configuration -->
            <div>
                <x-tooltip text="Funnel configuration describes the shape of retinal detachment:
                Open: Wider configuration with better prognosis
                Closed: Narrow configuration indicating more severe detachment">
                    <x-input-label for="{{ $side }}_eye_funnel_config" :value="__('Funnel Configuration')" class="font-medium" />
                </x-tooltip>
                <select name="{{ $side }}_eye_funnel_config" id="{{ $side }}_eye_funnel_config" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Select Configuration</option>
                    <option value="open" {{ old($side.'_eye_funnel_config', $examination ? $examination->{$side.'_eye_funnel_config'} : '') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ old($side.'_eye_funnel_config', $examination ? $examination->{$side.'_eye_funnel_config'} : '') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <!-- Macular Status -->
            <div>
                <x-tooltip text="Macular status is critical for visual prognosis:
                Attached: Better potential visual outcome
                Detached: More severe condition with poorer visual prognosis">
                    <x-input-label for="{{ $side }}_eye_macular_status" :value="__('Macular Status')" class="font-medium" />
                </x-tooltip>
                <select name="{{ $side }}_eye_macular_status" id="{{ $side }}_eye_macular_status" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Select Status</option>
                    <option value="attached" {{ old($side.'_eye_macular_status', $examination ? $examination->{$side.'_eye_macular_status'} : '') === 'attached' ? 'selected' : '' }}>Attached</option>
                    <option value="detached" {{ old($side.'_eye_macular_status', $examination ? $examination->{$side.'_eye_macular_status'} : '') === 'detached' ? 'selected' : '' }}>Detached</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Regression Status Section -->
    <div class="p-4 bg-gray-50 rounded-lg">
        <x-tooltip text="Treatment and regression status helps track disease progression and response to treatment">
            <h4 class="text-lg font-medium mb-4 text-gray-700">Treatment & Regression</h4>
        </x-tooltip>
        <div class="space-y-4">
            <div>
                <x-tooltip text="Regression status indicates the response to treatment:
                None: No prior treatment
                Complete: Complete regression of ROP
                Incomplete: Partial regression of ROP
                Reactivation: Reappearance of ROP after treatment">
                    <x-input-label for="{{ $side }}_eye_regression_status" :value="__('Regression Status')" class="font-medium" />
                </x-tooltip>
                <select name="{{ $side }}_eye_regression_status" id="{{ $side }}_eye_regression_status" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Select Status</option>
                    <option value="none" {{ old($side.'_eye_regression_status', $examination ? $examination->{$side.'_eye_regression_status'} : '') === 'none' ? 'selected' : '' }}>No Prior Treatment</option>
                    <option value="complete" {{ old($side.'_eye_regression_status', $examination ? $examination->{$side.'_eye_regression_status'} : '') === 'complete' ? 'selected' : '' }}>Complete Regression</option>
                    <option value="incomplete" {{ old($side.'_eye_regression_status', $examination ? $examination->{$side.'_eye_regression_status'} : '') === 'incomplete' ? 'selected' : '' }}>Incomplete Regression</option>
                    <option value="reactivation" {{ old($side.'_eye_regression_status', $examination ? $examination->{$side.'_eye_regression_status'} : '') === 'reactivation' ? 'selected' : '' }}>Reactivation</option>
                </select>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const side = '{{ $side }}';
        const detachmentSection = document.getElementById(`${side}_eye_detachment_section`);
        const stageSelect = document.getElementById(`${side}_eye_stage`);
        
        function updateDetachmentVisibility() {
            const stage = stageSelect.value;
            if (stage.startsWith('4') || stage.startsWith('5')) {
                detachmentSection.style.display = 'block';
            } else {
                detachmentSection.style.display = 'none';
            }
        }

        stageSelect.addEventListener('change', updateDetachmentVisibility);
        updateDetachmentVisibility();
    });
</script>
@endpush
