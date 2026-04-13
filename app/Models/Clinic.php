<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clinic extends Model
{
    use HasUuids;
    use HasFactory;

    protected $guarded = [];

    // Use the UUID primary key format seen in your SQL dump
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'clinic_name',
        'clinic_address',
        'contact_number',
        'clinic_logo', // Add this line
    ];

    // Relationships
    public function doctors()
    {
        return $this->hasMany(DoctorProfile::class, 'clinic_id');
    }

    public function secretaries()
    {
        return $this->hasMany(SecretaryProfile::class, 'clinic_id');
    }
}
