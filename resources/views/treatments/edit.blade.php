<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Treatment</h2>
                </div>

                <form id="treatment-form" action="{{ route('treatments.update', $treatment) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Alert Container -->
                    <div id="alert-container" class="mb-4" style="display: none;">
                        <div class="rounded-md p-4"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Treatment Information -->
                        <div class="space-y-6">
                            <div>
                                <label for="treatment_type" class="block text-sm font-medium text-gray-700">Treatment Type</label>
                                <select id="treatment_type" name="treatment_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="laser" {{ $treatment->treatment_type === 'laser' ? 'selected' : '' }}>Laser</option>
                                    <option value="anti_vegf" {{ $treatment->treatment_type === 'anti_vegf' ? 'selected' : '' }}>Anti-VEGF</option>
                                    <option value="combined" {{ $treatment->treatment_type === 'combined' ? 'selected' : '' }}>Combined</option>
                                </select>
                            </div>

                            <div>
                                <label for="treating_doctor_id" class="block text-sm font-medium text-gray-700">Treating Doctor</label>
                                <select id="treating_doctor_id" name="treating_doctor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ $treatment->treating_doctor_id == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="follow_up_date" class="block text-sm font-medium text-gray-700">Follow-up Date</label>
                                <input type="datetime-local" name="follow_up_date" id="follow_up_date" 
                                       value="{{ $treatment->follow_up_date ? $treatment->follow_up_date->format('Y-m-d\TH:i') : '' }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <!-- Eye-specific Treatment -->
                        <div class="space-y-6">
                            <div>
                                <div class="flex items-center">
                                    <input type="hidden" name="right_eye_treated" value="0">
                                    <input type="checkbox" name="right_eye_treated" id="right_eye_treated" value="1"
                                           {{ $treatment->right_eye_treated ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="right_eye_treated" class="ml-2 block text-sm font-medium text-gray-700">
                                        Right Eye Treatment
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <label for="right_eye_treatment_notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea id="right_eye_treatment_notes" name="right_eye_treatment_notes" rows="3"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $treatment->right_eye_treatment_notes }}</textarea>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center">
                                    <input type="hidden" name="left_eye_treated" value="0">
                                    <input type="checkbox" name="left_eye_treated" id="left_eye_treated" value="1"
                                           {{ $treatment->left_eye_treated ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="left_eye_treated" class="ml-2 block text-sm font-medium text-gray-700">
                                        Left Eye Treatment
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <label for="left_eye_treatment_notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea id="left_eye_treatment_notes" name="left_eye_treatment_notes" rows="3"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $treatment->left_eye_treatment_notes }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Post-treatment Instructions -->
                    <div class="mt-6">
                        <label for="post_treatment_instructions" class="block text-sm font-medium text-gray-700">Post-treatment Instructions</label>
                        <textarea id="post_treatment_instructions" name="post_treatment_instructions" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $treatment->post_treatment_instructions }}</textarea>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Treatment
                        </button>
                    </div>
                </form>

                <script>
                    document.getElementById('treatment-form').addEventListener('submit', function(e) {
                        e.preventDefault();
                        
                        const form = e.target;
                        const formData = new FormData(form);
                        const alertContainer = document.getElementById('alert-container');
                        const alertDiv = alertContainer.querySelector('div');

                        fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(errors => {
                                    throw new Error(Object.values(errors.errors).flat().join('\n'));
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                alertDiv.className = 'rounded-md p-4 bg-green-50';
                                alertDiv.innerHTML = `
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-green-800">${data.message}</p>
                                        </div>
                                    </div>
                                `;
                                alertContainer.style.display = 'block';

                                // Redirect to patient page after a short delay
                                setTimeout(() => {
                                    window.location.href = data.redirect;
                                }, 1000);
                            }
                        })
                        .catch(error => {
                            // Show error message
                            alertDiv.className = 'rounded-md p-4 bg-red-50';
                            alertDiv.innerHTML = `
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800">${error.message}</p>
                                    </div>
                                </div>
                            `;
                            alertContainer.style.display = 'block';
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
