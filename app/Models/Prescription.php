<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function encounter()
    {
        return $this->belongsTo(Encounter::class, 'encounter_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class, 'prescription_id');
    }
}
