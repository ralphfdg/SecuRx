<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class DoctorScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding Doctor Schedules...');

        // 1. Fetch all users who are doctors
        $doctors = User::where('role', 'doctor')->get();

        if ($doctors->isEmpty()) {
            $this->command->warn('No doctors found in the database. Please seed users first.');
            return;
        }

        // 2. Define standard working days
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // 3. Loop through every doctor and give them a 9 to 5 schedule for those days
        foreach ($doctors as $doctor) {
            foreach ($days as $day) {
                DB::table('doctor_schedules')->updateOrInsert(
                    [
                        'doctor_id' => $doctor->id, 
                        'day_of_week' => $day
                    ],
                    [
                        'id' => (string) Str::uuid(),
                        'start_time' => '09:00:00',
                        'end_time' => '17:00:00',
                        'is_available' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        $this->command->info('Success! All doctors are now scheduled for Mon-Fri, 9:00 AM - 5:00 PM.');
    }
}