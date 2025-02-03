<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Doctor extends Model
{
    use HasFactory, SoftDeletes, HasRoles;

    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialty',
        'license_number'
    ];

    /**
     * Get the treatments performed by the doctor.
     */
    public function treatments()
    {
        return $this->hasMany(Treatment::class, 'treating_doctor_id');
    }

    /**
     * Get the examinations performed by the doctor.
     */
    public function examinations()
    {
        return $this->hasMany(Examination::class, 'examining_doctor_id');
    }
}
