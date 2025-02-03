@csrf

<div class="grid grid-cols-1 gap-6">
    <div>
        <x-input-label for="name" :value="__('NICU Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
            :value="old('name', $nicu->name ?? '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="location" :value="__('Location')" />
        <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" 
            :value="old('location', $nicu->location ?? '')" required />
        <x-input-error class="mt-2" :messages="$errors->get('location')" />
    </div>

    <div>
        <x-input-label for="capacity" :value="__('Capacity')" />
        <x-text-input id="capacity" name="capacity" type="number" class="mt-1 block w-full" 
            :value="old('capacity', $nicu->capacity ?? '')" required min="0" />
        <x-input-error class="mt-2" :messages="$errors->get('capacity')" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" name="description" 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $nicu->description ?? '') }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('description')" />
    </div>

    <div>
        <x-input-label for="status" :value="__('Status')" />
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="active" {{ (old('status', $nicu->status ?? '') === 'active') ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ (old('status', $nicu->status ?? '') === 'inactive') ? 'selected' : '' }}>Inactive</option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('status')" />
    </div>

    <div>
        <x-input-label :value="__('Assign Doctors')" />
        <div class="mt-2 space-y-2 max-h-60 overflow-y-auto border rounded-md p-2">
            @foreach($doctors as $doctor)
                <div class="flex items-center">
                    <input type="checkbox" name="doctor_ids[]" value="{{ $doctor->id }}" 
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        {{ in_array($doctor->id, old('doctor_ids', $assignedDoctors ?? [])) ? 'checked' : '' }}>
                    <label class="ml-2 text-sm text-gray-600">
                        {{ $doctor->name }} ({{ $doctor->email }})
                    </label>
                </div>
            @endforeach
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('doctor_ids')" />
    </div>
</div>
