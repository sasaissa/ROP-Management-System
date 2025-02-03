<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExaminationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'examiner_id' => ['required', 'exists:users,id'],
            'examination_date' => ['required', 'date'],
            'right_eye_zone' => ['nullable', 'string', 'in:I,II,III,posterior II'],
            'right_eye_stage' => ['nullable', 'string', 'in:1,2,3,4A,4B,5A,5B,5C'],
            'right_eye_clock_hours' => ['nullable', 'array'],
            'right_eye_clock_hours.*' => ['integer', 'min:1', 'max:12'],
            'right_eye_plus_disease' => ['nullable', 'boolean'],
            'right_eye_pre_plus' => ['nullable', 'boolean'],
            'right_eye_ap_rop' => ['nullable', 'boolean'],
            'left_eye_zone' => ['nullable', 'string', 'in:I,II,III,posterior II'],
            'left_eye_stage' => ['nullable', 'string', 'in:1,2,3,4A,4B,5A,5B,5C'],
            'left_eye_clock_hours' => ['nullable', 'array'],
            'left_eye_clock_hours.*' => ['integer', 'min:1', 'max:12'],
            'left_eye_plus_disease' => ['nullable', 'boolean'],
            'left_eye_pre_plus' => ['nullable', 'boolean'],
            'left_eye_ap_rop' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date', 'after:examination_date'],
            'status' => ['required', 'string', 'in:scheduled,completed,cancelled'],
        ];
    }

    public function messages(): array
    {
        return [
            'right_eye_zone.in' => 'The right eye zone must be one of: I, II, III, or posterior II',
            'left_eye_zone.in' => 'The left eye zone must be one of: I, II, III, or posterior II',
            'right_eye_stage.in' => 'The right eye stage must be one of: 1, 2, 3, 4A, 4B, 5A, 5B, or 5C',
            'left_eye_stage.in' => 'The left eye stage must be one of: 1, 2, 3, 4A, 4B, 5A, 5B, or 5C',
            'follow_up_date.after' => 'The follow-up date must be after the examination date',
        ];
    }

    protected function prepareForValidation()
    {
        // Set default values for boolean fields if not present
        $this->merge([
            'right_eye_plus_disease' => $this->boolean('right_eye_plus_disease'),
            'right_eye_pre_plus' => $this->boolean('right_eye_pre_plus'),
            'right_eye_ap_rop' => $this->boolean('right_eye_ap_rop'),
            'left_eye_plus_disease' => $this->boolean('left_eye_plus_disease'),
            'left_eye_pre_plus' => $this->boolean('left_eye_pre_plus'),
            'left_eye_ap_rop' => $this->boolean('left_eye_ap_rop'),
        ]);
    }
}
