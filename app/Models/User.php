<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUuids, Notifiable, SoftDeletes;

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
        'name',
        'username',
        'email',
        'dob',
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

    // ==========================================
    // ROLE PROFILES
    // ==========================================
    public function patientProfile()
    {
        return $this->hasOne(PatientProfile::class, 'user_id');
    }

    public function doctorProfile()
    {
        return $this->hasOne(DoctorProfile::class, 'user_id');
    }

    public function pharmacistProfile()
    {
        return $this->hasOne(PharmacistProfile::class, 'user_id');
    }

    public function secretaryProfile()
    {
        return $this->hasOne(SecretaryProfile::class, 'user_id');
    }

    // ==========================================
    // DOCTOR SPECIFIC RELATIONSHIPS
    // ==========================================
    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class, 'doctor_id');
    }

    public function specializations()
    {
        return $this->belongsToMany(
            Specialization::class,
            'doctor_specialization',
            'doctor_id',
            'specialization_id'
        );
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function doctorEncounters()
    {
        return $this->hasMany(Encounter::class, 'doctor_id');
    }

    public function authoredPrescriptions()
    {
        return $this->hasMany(Prescription::class, 'doctor_id');
    }

    // ==========================================
    // PATIENT SPECIFIC RELATIONSHIPS
    // ==========================================
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function patientEncounters()
    {
        return $this->hasMany(Encounter::class, 'patient_id');
    }

    public function patientPrescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    // For the Authorized Representatives dropdown on the dispense page
    public function authorizedRepresentatives()
    {
        return $this->hasMany(AuthorizedRepresentative::class, 'patient_id')->where('is_active', true);
    }

    // Patient Medical Records
    public function allergies()
    {
        return $this->hasMany(PatientAllergy::class, 'patient_id');
    }

    public function immunizations()
    {
        return $this->hasMany(Immunization::class, 'patient_id');
    }

    public function labResults()
    {
        return $this->hasMany(LabResult::class, 'patient_id');
    }

    public function medicalDocuments()
    {
        return $this->hasMany(MedicalDocument::class, 'patient_id');
    }

    // ==========================================
    // SECRETARY SPECIFIC RELATIONSHIPS
    // ==========================================
    public function secretaryAppointments()
    {
        return $this->hasMany(Appointment::class, 'secretary_id');
    }

    // ==========================================
    // PHARMACIST SPECIFIC RELATIONSHIPS
    // ==========================================
    public function dispensedLogs()
    {
        return $this->hasMany(DispensingLog::class, 'pharmacist_id');
    }
}
