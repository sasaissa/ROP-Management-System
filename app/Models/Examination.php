<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examination extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'examiner_id',
        'examination_date',
        'right_eye_zone',
        'right_eye_stage',
        'right_eye_clock_hours',
        'right_eye_plus_disease',
        'right_eye_pre_plus',
        'right_eye_ap_rop',
        'left_eye_zone',
        'left_eye_stage',
        'left_eye_clock_hours',
        'left_eye_plus_disease',
        'left_eye_pre_plus',
        'left_eye_ap_rop',
        'notes',
        'follow_up_date',
        'status',
        'next_examination_date',
        'reviewed_at',
        'reviewed_by',
        'followup_of_examination_id'
    ];

    protected $casts = [
        'examination_date' => 'datetime',
        'next_examination_date' => 'datetime',
        'right_eye_plus_disease' => 'boolean',
        'right_eye_pre_plus' => 'boolean',
        'left_eye_plus_disease' => 'boolean',
        'left_eye_pre_plus' => 'boolean',
        'right_eye_clock_hours' => 'array',
        'left_eye_clock_hours' => 'array',
        'right_eye_ap_rop' => 'boolean',
        'left_eye_ap_rop' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function examiner()
    {
        return $this->belongsTo(User::class, 'examiner_id');
    }

    public function examiningDoctor()
    {
        return $this->belongsTo(User::class, 'examiner_id');
    }

    public function treatmentPlan()
    {
        return $this->hasOne(TreatmentPlan::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

    public function followupExamination()
    {
        return $this->hasOne(Examination::class, 'followup_of_examination_id');
    }

    public function originalExamination()
    {
        return $this->belongsTo(Examination::class, 'followup_of_examination_id');
    }
}
