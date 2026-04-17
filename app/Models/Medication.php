<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- 1. We import the trait here

class Medication extends Model
{
    use SoftDeletes; // <-- 2. We tell the model to use it here

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

    public function latestDpriRecord()
    {
        return $this->hasOne(DpriRecord::class)->orderBy('effective_year', 'desc');
    }
}