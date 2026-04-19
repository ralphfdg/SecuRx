<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientProfile extends Model
{
    use HasUuids, SoftDeletes;
    
    protected $guarded = [];

    protected $casts = [
        'data_consent' => 'boolean',
    ];

    public function user() 
    { 
        return $this->belongsTo(User::class, 'user_id'); 
    }

    /**
     * Link the patient profile directly to the facility they registered at.
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }
}