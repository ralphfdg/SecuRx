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
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'qualifier',
        'name',        // <-- This was missing, causing your error!
        'username',
        'email',
        'dob',         // <-- These were also being silently blocked!
        'gender',
        'mobile_num',
        'role',
        'status',
        'password',
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



    // For Patients
    public function patientProfile()
    {
        return $this->hasOne(PatientProfile::class, 'user_id');
    }

    public function patientAllergies()
    {
        return $this->hasMany(PatientAllergy::class, 'patient_id');
    }

    // For Doctors
    public function doctorProfile()
    {
        return $this->hasOne(DoctorProfile::class, 'user_id');
    }

    // For the Authorized Representatives dropdown on the dispense page
    public function authorizedRepresentatives()
    {
        return $this->hasMany(AuthorizedRepresentative::class, 'patient_id')->where('is_active', true);
    }

    /**
     * Many-to-Many Relationship: For Doctors only. Links to their medical specializations.
     */
    public function specializations()
    {
        return $this->belongsToMany(
            Specialization::class, 
            'doctor_specialization', // The name of your pivot table
            'doctor_id',             // The foreign key for this model
            'specialization_id'      // The foreign key for the related model
        );
    }
}
