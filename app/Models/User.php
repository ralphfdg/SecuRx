<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'username',       
        'email',
        'contact_number', 
        'password',
        'role',           
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // -----------------------------------------------------
    // PHASE 1 RELATIONSHIPS
    // -----------------------------------------------------

    // A User might have a Patient Profile
    public function patientProfile()
    {
        return $this->hasOne(PatientProfile::class);
    }

    // A User might have a Doctor Profile
    public function doctorProfile()
    {
        return $this->hasOne(DoctorProfile::class);
    }

    // If the User is a Doctor, they have many Prescriptions they've written
    public function prescriptionsWritten()
    {
        return $this->hasMany(Prescription::class, 'doctor_id');
    }

    // If the User is a Patient, they have many Prescriptions given to them
    public function prescriptionsReceived()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }
}
