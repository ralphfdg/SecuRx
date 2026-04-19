<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class PatientAllergy extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    } // Can be null if it's a non-drug allergy
}
