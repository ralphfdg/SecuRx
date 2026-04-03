<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PatientAllergy extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // If it is a known drug allergy, this links to the medication
    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_id');
    }
}
