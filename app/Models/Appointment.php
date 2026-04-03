<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Appointment extends Model
{
    use HasUuids;
    protected $guarded = [];

    protected $casts = [
        'appointment_date' => 'datetime',
        'triage_vitals' => 'array', // Automatically casts the JSON column to a PHP array!
    ];

    public function patient() { return $this->belongsTo(User::class, 'patient_id'); }
    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
    public function secretary() { return $this->belongsTo(User::class, 'secretary_id'); }
    public function encounter() { return $this->hasOne(Encounter::class); }
}