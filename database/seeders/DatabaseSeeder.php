<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting Master Seeder for UI Testing (Congested Schedule)...');

        // ==========================================
        // 1. FOUNDATIONAL DATA (Clinic)
        // ==========================================
        $clinicId = (string) Str::uuid();
        DB::table('clinics')->updateOrInsert(
            ['clinic_name' => 'Angeles Main Clinic'],
            [
                'id' => $clinicId,
                'clinic_address' => 'MacArthur Highway, Angeles City',
                'contact_number' => '09170000000',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        $clinicId = DB::table('clinics')->where('clinic_name', 'Angeles Main Clinic')->value('id');

        // ==========================================
        // 2. CORE STAFF USERS
        // ==========================================
        $defaultPassword = Hash::make('password123');

        $doctor = User::updateOrCreate(
            ['email' => 'doctor@securx.com'],
            ['name' => 'Juan Santos', 'first_name' => 'Juan', 'last_name' => 'Santos', 'username' => 'drjuan', 'password' => $defaultPassword, 'role' => 'doctor', 'status' => 'active']
        );

        $secretary = User::updateOrCreate(
            ['email' => 'secretary@securx.com'],
            ['name' => 'Clara Bautista', 'first_name' => 'Clara', 'last_name' => 'Bautista', 'username' => 'admin_clara', 'password' => $defaultPassword, 'role' => 'secretary', 'status' => 'active']
        );

        DB::table('doctor_profiles')->updateOrInsert(
            ['user_id' => $doctor->id],
            ['id' => (string) Str::uuid(), 'clinic_id' => $clinicId, 'prc_number' => '0123456', 'prc_expiration' => '2028-08-20', 'ptr_number' => 'PTR-987654', 'is_verified' => 1, 'created_at' => now()]
        );

        DB::table('secretary_profiles')->updateOrInsert(
            ['user_id' => $secretary->id],
            ['id' => (string) Str::uuid(), 'clinic_id' => $clinicId, 'created_at' => now()]
        );

        // ==========================================
        // 3. GENERATE MULTIPLE PATIENTS
        // ==========================================
        $patientsData = [
            ['first' => 'Maria', 'last' => 'Dela Cruz', 'email' => 'maria@securx.com'],
            ['first' => 'Carlos', 'last' => 'Mendoza', 'email' => 'carlos@securx.com'],
            ['first' => 'Elena', 'last' => 'Reyes', 'email' => 'elena@securx.com'],
            ['first' => 'Jose', 'last' => 'Gomez', 'email' => 'jose@securx.com'],
            ['first' => 'Isabella', 'last' => 'Torres', 'email' => 'isabella@securx.com'],
            ['first' => 'Miguel', 'last' => 'Navarro', 'email' => 'miguel@securx.com'],
        ];

        $patientIds = [];

        foreach ($patientsData as $p) {
            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['first'] . ' ' . $p['last'],
                    'first_name' => $p['first'],
                    'last_name' => $p['last'],
                    'username' => strtolower($p['first']) . '_patient',
                    'password' => $defaultPassword,
                    'role' => 'patient',
                    'status' => 'active',
                ]
            );

            DB::table('patient_profiles')->updateOrInsert(
                ['user_id' => $user->id],
                ['id' => (string) Str::uuid(), 'height' => 160.00, 'weight' => 65.00, 'data_consent' => 1, 'created_at' => now()]
            );

            $patientIds[] = $user->id;
        }

        // ==========================================
        // 4. MASS APPOINTMENT SCHEDULING (FOR TODAY)
        // ==========================================
        
        // We will schedule all 6 patients today to force the Calendar to overlap
        $scheduleScenarios = [
            ['time' => 9, 'status' => 'completed'], // 9:00 AM - Already done
            ['time' => 10, 'status' => 'confirmed'], // 10:00 AM - Confirmed/Waiting
            ['time' => 11, 'status' => 'confirmed'], // 11:00 AM - Confirmed
            ['time' => 13, 'status' => 'pending'],   // 1:00 PM - Needs Approval
            ['time' => 14, 'status' => 'pending'],   // 2:00 PM - Needs Approval
            ['time' => 15, 'status' => 'cancelled'], // 3:00 PM - Cancelled
        ];

        foreach ($scheduleScenarios as $index => $scenario) {
            DB::table('appointments')->updateOrInsert(
                [
                    'patient_id' => $patientIds[$index], 
                    'doctor_id' => $doctor->id, 
                    'appointment_date' => Carbon::today()->setTime($scenario['time'], 0, 0)
                ],
                [
                    'id' => (string) Str::uuid(),
                    'secretary_id' => $secretary->id,
                    'status' => $scenario['status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Add two random appointments for tomorrow just so the calendar isn't completely empty elsewhere
        DB::table('appointments')->insert([
            [
                'id' => (string) Str::uuid(), 'patient_id' => $patientIds[0], 'doctor_id' => $doctor->id, 'secretary_id' => $secretary->id,
                'appointment_date' => Carbon::tomorrow()->setTime(10, 0, 0), 'status' => 'confirmed', 'created_at' => now(), 'updated_at' => now()
            ],
            [
                'id' => (string) Str::uuid(), 'patient_id' => $patientIds[1], 'doctor_id' => $doctor->id, 'secretary_id' => $secretary->id,
                'appointment_date' => Carbon::tomorrow()->setTime(14, 0, 0), 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        $this->command->info('Success! Schedule is now congested. Check your Secretary Calendar.');
    }
}