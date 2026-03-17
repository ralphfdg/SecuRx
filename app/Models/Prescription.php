<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    //
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'medication_id',
        'qr_token',
        'dosage_instructions',
        'days_supply_per_refill',
        'max_refills',
        'refills_used',
    ];
    
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
}
