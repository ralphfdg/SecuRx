<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasUuids, SoftDeletes; // Ensures Laravel handles the UUID primary key and soft deletes

    protected $guarded = [];

    // The Patient who owns this prescription
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // The Doctor who wrote it
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // The specific medications (items) on this prescription
    public function items()
    {
        return $this->hasMany(PrescriptionItem::class, 'prescription_id');
    }

    // The encounter/checkup this is linked to
    public function encounter()
    {
        return $this->belongsTo(Encounter::class, 'encounter_id');
    }
}