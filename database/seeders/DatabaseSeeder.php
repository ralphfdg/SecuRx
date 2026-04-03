<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PatientProfile;
use App\Models\DoctorProfile;
use App\Models\PharmacistProfile;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a Test Patient
        $patient = User::create([
            'first_name' => 'Maria',
            'last_name'  => 'Dela Cruz',
            'name'       => 'Maria Dela Cruz',
            'username'   => 'mariapatient',
            'email'      => 'patient@securx.com',
            'dob'        => '1990-05-15',
            'gender'     => 'Female',
            'mobile_num' => '09171234567',
            'role'       => 'patient',
            'status'     => 'active',
            'password'   => Hash::make('password123'),
        ]);

        PatientProfile::create([
            'user_id' => $patient->id,
            'height'  => 165.5,
            'weight'  => 60.2,
            'address' => '123 Sampaguita St, Angeles City',
        ]);

        // 2. Create a Test Doctor (Approved Status)
        $doctor = User::create([
            'first_name' => 'Juan',
            'last_name'  => 'Santos',
            'name'       => 'Juan Santos',
            'username'   => 'drjuan',
            'email'      => 'doctor@securx.com',
            'dob'        => '1980-08-20',
            'gender'     => 'Male',
            'mobile_num' => '09189876543',
            'role'       => 'doctor',
            'status'     => 'active', // Set to active so you can test the portal
            'password'   => Hash::make('password123'),
        ]);

        DoctorProfile::create([
            'user_id'            => $doctor->id,
            'prc_number'         => '0123456',
            'prc_expiration'     => '2028-08-20',
            'ptr_number'         => 'PTR-987654',
            's2_number'          => 'S2-112233',
            's2_expiration'      => '2027-01-01',
        ]);

        // 3. Create a Test Pharmacist (Approved Status)
        $pharmacist = User::create([
            'first_name' => 'Ana',
            'last_name'  => 'Reyes',
            'name'       => 'Ana Reyes',
            'username'   => 'rxana',
            'email'      => 'pharmacy@securx.com',
            'dob'        => '1995-02-10',
            'gender'     => 'Female',
            'mobile_num' => '09191122334',
            'role'       => 'pharmacist',
            'status'     => 'active',
            'password'   => Hash::make('password123'),
        ]);

        PharmacistProfile::create([
            'user_id'          => $pharmacist->id,
            'pharmacy_name'    => 'Mercury Drug - Balibago',
            'lto_number'       => 'LTO-RX-556677',
            'lto_expiration'   => '2029-12-31',
            'business_address' => 'MacArthur Highway, Balibago, Angeles City',
        ]);

        // Give Dr. Santos a standard Monday-Friday, 9 AM to 5 PM schedule
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        
        foreach ($days as $day) {
            \App\Models\DoctorSchedule::create([
                'doctor_id'    => $doctor->id,
                'day_of_week'  => $day,
                'start_time'   => '09:00:00',
                'end_time'     => '17:00:00',
                'is_available' => true,
            ]);
        }
    }
}
