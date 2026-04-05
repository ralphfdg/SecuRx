<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PharmacistProfile; // Ensure you have this model created
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PharmacistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create the User Record
        $user = User::create([
            'username'    => 'juan_pharm', // Added username
            'first_name'  => 'Juan',
            'middle_name' => 'Protacio',
            'last_name'   => 'Rizal',
            'qualifier'   => null,
            'name'        => 'Juan Rizal, RPh',
            'email'       => 'pharmacist@securx.ph',
            'dob'         => Carbon::parse('1992-06-19'),
            'mobile_num'  => '09171234567',
            'gender'      => 'Male',
            'role'        => 'pharmacist',
            'password'    => Hash::make('password123'),
        ]);

        // 2. Create the Pharmacist Profile linked to the User ID
        PharmacistProfile::create([
            'user_id'          => $user->id,
            'pharmacy_name'    => 'Mercury Drug - Angeles City Main',
            'lto_number'       => 'LTO-PH-9928374',
            'lto_expiration'   => Carbon::parse('2028-12-31'),
            'business_address' => 'Sto. Rosario St, Angeles, 2009 Pampanga',
            'is_verified'      => true, // Verified so they can dispense immediately
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }
}