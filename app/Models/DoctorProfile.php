<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DoctorProfile extends Model
{
    use HasUuids;
    
    protected $guarded = [];

    /**
     * Inverse Relationship: Links back to the main User account
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Links to the prescriptions this doctor has written
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'doctor_id', 'user_id');
    }
}
