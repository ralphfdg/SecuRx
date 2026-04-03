<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DoctorSchedule extends Model
{
    use HasUuids;
    
    protected $guarded = [];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    /**
     * Inverse Relationship: Links back to the Doctor (User)
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
