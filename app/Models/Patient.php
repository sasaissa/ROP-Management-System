<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Examination;
use App\Models\User;
use App\Models\Nicu;
use App\Models\Treatment;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_number',
        'first_name',
        'last_name',
        'date_of_birth',
        'medical_history',
        'medical_history_notes',
        'birth_weight',
        'gestational_age',
        'multiple_birth_status',
        'head_circumference',
        'antenatal_steroids_received',
        'mode_of_delivery',
        'maternal_complications',
        'days_on_oxygen',
        'days_on_ventilation',
        'highest_fio2_received',
        'surfactant_therapy',
        'weight_at_examination',
        'post_menstrual_age',
        'study_group',
        'research_notes',
        'admission_date',
        'gender',
        'nicu_location',
        'parent_contact',
        'doctor_id',
        'nicu_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
        'medical_history' => 'array',
        'antenatal_steroids_received' => 'boolean',
        'birth_weight' => 'decimal:2',
        'gestational_age' => 'integer',
        'head_circumference' => 'decimal:2',
        'days_on_oxygen' => 'integer',
        'days_on_ventilation' => 'integer',
        'highest_fio2_received' => 'decimal:2',
        'weight_at_examination' => 'decimal:2',
        'post_menstrual_age' => 'decimal:1'
    ];

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function nicu()
    {
        return $this->belongsTo(Nicu::class);
    }

    /**
     * Get the patient's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
