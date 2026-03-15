<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. Create the Test Doctor
        $doctor = User::create([
            'first_name' => 'Dr. Gregory',
            'last_name' => 'House',
            'username' => 'drhouse', // ADDED
            'email' => 'doctor@securx.test',
            'contact_number' => '09171234567',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        // 2. Create the Test Pharmacist
        $pharmacist = User::create([
            'first_name' => 'Sarah',
            'last_name' => 'Mercury',
            'username' => 'smercury', // ADDED
            'email' => 'pharmacy@securx.test',
            'contact_number' => '09181234567',
            'password' => Hash::make('password'),
            'role' => 'pharmacist',
        ]);

        // 3. Create the Test Patient
        $patient = User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'johndoe', // ADDED
            'email' => 'patient@securx.test',
            'contact_number' => '09191234567',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);
    }
}
