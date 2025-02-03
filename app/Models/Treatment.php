<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treatment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'treating_doctor_id',
        'examination_id',
        'treatment_date',
        'treatment_type',
        'location',
        'pre_treatment_instructions',
        'scheduling_notes',
        'right_eye_treated',
        'left_eye_treated',
        'status',
        'notes'
    ];

    protected $casts = [
        'treatment_date' => 'datetime',
        'right_eye_treated' => 'boolean',
        'left_eye_treated' => 'boolean'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function treatingDoctor()
    {
        return $this->belongsTo(User::class, 'treating_doctor_id');
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }
}
