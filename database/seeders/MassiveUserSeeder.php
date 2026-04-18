<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class MassiveUserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('en_PH');
        $now = Carbon::now();
        $password = Hash::make('password123'); // Hashed once for performance

        $clinics = DB::table('clinics')->pluck('id')->toArray();
        $specializations = DB::table('specializations')->pluck('id')->toArray();

        $this->command->info('Seeding 5 Admins...');
        for ($i = 0; $i < 5; $i++) {
            $this->createUser('admin', $faker, $password, $now);
        }

        $this->command->info('Seeding 15 Doctors with Schedules & Templates...');
        for ($i = 0; $i < 15; $i++) {
            $docId = $this->createUser('doctor', $faker, $password, $now);
            
            DB::table('doctor_profiles')->insert([
                'id' => Str::uuid()->toString(),
                'user_id' => $docId,
                'clinic_id' => $faker->randomElement($clinics),
                'prc_number' => $faker->unique()->numerify('#######'),
                'prc_expiration' => Carbon::now()->addYears(rand(1, 3)),
                'ptr_number' => 'PTR-' . $faker->numerify('######'),
                'is_verified' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('doctor_specialization')->insert([
                'doctor_id' => $docId,
                'specialization_id' => $faker->randomElement($specializations),
            ]);

            // Schedules (Mon-Fri)
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            foreach ($days as $day) {
                DB::table('doctor_schedules')->insert([
                    'id' => Str::uuid()->toString(),
                    'doctor_id' => $docId,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'is_available' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // SOAP Templates
            for ($t = 0; $t < 3; $t++) {
                DB::table('soap_templates')->insert([
                    'id' => Str::uuid()->toString(),
                    'doctor_id' => $docId,
                    'template_name' => $faker->word . ' Standard Protocol',
                    'subjective_text' => $faker->sentence,
                    'objective_text' => $faker->sentence,
                    'assessment_text' => $faker->sentence,
                    'plan_text' => $faker->sentence,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $this->command->info('Seeding 30 Secretaries...');
        for ($i = 0; $i < 30; $i++) {
            $secId = $this->createUser('secretary', $faker, $password, $now);
            DB::table('secretary_profiles')->insert([
                'id' => Str::uuid()->toString(),
                'user_id' => $secId,
                'clinic_id' => $faker->randomElement($clinics),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info('Seeding 80 Patients...');
        for ($i = 0; $i < 80; $i++) {
            $patId = $this->createUser('patient', $faker, $password, $now);
            DB::table('patient_profiles')->insert([
                'id' => Str::uuid()->toString(),
                'user_id' => $patId,
                'height' => $faker->randomFloat(2, 140, 190),
                'weight' => $faker->randomFloat(2, 45, 100),
                'address' => $faker->address,
                'data_consent' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info('Seeding 20 Pharmacies...');
        for ($i = 0; $i < 20; $i++) {
            $pharmId = $this->createUser('pharmacist', $faker, $password, $now);
            DB::table('pharmacist_profiles')->insert([
                'id' => Str::uuid()->toString(),
                'user_id' => $pharmId,
                'pharmacy_name' => $faker->company . ' Pharmacy',
                'lto_number' => 'LTO-' . $faker->unique()->numerify('########'),
                'lto_expiration' => Carbon::now()->addYears(2),
                'business_address' => $faker->address,
                'is_verified' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function createUser($role, $faker, $password, $now)
    {
        $userId = Str::uuid()->toString();
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        
        DB::table('users')->insert([
            'id' => $userId,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => "$firstName $lastName",
            'username' => $faker->unique()->userName,
            'email' => $faker->unique()->safeEmail,
            'dob' => $faker->date('Y-m-d', '2005-01-01'),
            'gender' => $faker->randomElement(['Male', 'Female']),
            'mobile_num' => $faker->phoneNumber,
            'role' => $role,
            'status' => 'active',
            'password' => $password,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return $userId;
    }
}