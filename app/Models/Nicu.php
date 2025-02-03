<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Nicu extends Model
{
    protected $fillable = [
        'name',
        'location',
        'capacity',
        'description',
        'status'
    ];

    /**
     * Get the doctors assigned to this NICU
     */
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'nicu_doctor')
                    ->whereHas('roles', function($query) {
                        $query->whereIn('name', ['ophthalmologist', 'resident']);
                    })
                    ->withTimestamps();
    }

    /**
     * Get the patients in this NICU
     */
    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }
}
