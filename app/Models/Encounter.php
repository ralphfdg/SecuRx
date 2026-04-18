<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Encounter extends Model
{
    use HasUuids, SoftDeletes;
    protected $guarded = [];

    protected $casts = [
        'encounter_date' => 'date',
        'is_sensitive' => 'boolean', // Supports your Sensitive Encounter Mode
    ];

    public function appointment() { return $this->belongsTo(Appointment::class); }
    public function patient() { return $this->belongsTo(User::class, 'patient_id'); }
    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
    public function prescriptions() { return $this->hasMany(Prescription::class); }
}
