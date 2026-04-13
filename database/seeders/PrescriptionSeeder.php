<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medication;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patient = User::where('email', 'patient@securx.com')->first();
        $doctor = User::where('role', 'doctor')->first();

        if (!$patient || !$doctor) {
            $this->command->warn('Required data missing. Ensure patient@securx.com and at least one doctor exist.');
            return;
        }

        $medication = Medication::first();
        
        // If the database was just wiped, generate a dummy medication!
        if (!$medication) {
            $medId = DB::table('medications')->insertGetId([
                'generic_name' => 'Paracetamol',
                'brand_name' => 'Biogesic',
                'form' => 'Tablet',
                'dosage_strength' => '500mg',
                'estimated_price' => 5.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $medication = Medication::find($medId);
        }

        // Create a dummy patient encounter to satisfy the database relationship
        $encounterId = (string) Str::uuid();
        DB::table('encounters')->insert([
            'id' => $encounterId,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'encounter_date' => now()->toDateString(), // Required by the encounters table schema
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $prescriptionId = (string) Str::uuid();

        Prescription::create([
            'id' => $prescriptionId,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'encounter_id' => $encounterId,
            'print_patient_name' => true,
            'general_instructions' => 'Drink plenty of water and rest well. Avoid strenuous physical activities.',
            'status' => 'active',
        ]);

        PrescriptionItem::create([
            'id' => (string) Str::uuid(),
            'prescription_id' => $prescriptionId,
            'medication_id' => $medication->id,
            'dose' => '500mg',
            'frequency' => 'BID (Twice a day)',
            'duration' => '7 days',
            'patient_instructions' => 'Take 30 minutes after your morning and evening meals to avoid stomach upset.',
            'pharmacist_instructions' => 'Verify patient allergies before dispensing.',
            'sig' => 'Take 1 tablet twice a day for 7 days',
            'quantity' => 14,
            'max_refills' => 0,
        ]);

        $this->command->info('Successfully created an active prescription for patient@securx.com!');
    }
}