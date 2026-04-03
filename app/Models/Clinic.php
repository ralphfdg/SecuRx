<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasUuids;

    protected $guarded = [];

    // Relationships
    public function doctors()
    {
        return $this->hasMany(DoctorProfile::class, 'clinic_id');
    }

    public function secretaries()
    {
        return $this->hasMany(SecretaryProfile::class, 'clinic_id');
    }
}
