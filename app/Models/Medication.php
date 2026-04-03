<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    // NO HasUuids trait here because your SQL dump shows this table uses bigint(20)
    protected $guarded = [];

    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public function patientAllergies()
    {
        return $this->hasMany(PatientAllergy::class);
    }
}
