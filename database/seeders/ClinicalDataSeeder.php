<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class ClinicalDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding Clinical Intelligence Data (RxNorm & DPRI)...');

        // ==========================================
        // 1. POPULATE MEDICATIONS (with RxCUI)
        // ==========================================
        $meds = [
            [
                'rxcui' => '723', 
                'generic_name' => 'Amoxicillin', 
                'brand_name' => 'Amoxil', 
                'form' => 'Capsule', 
                'dosage_strength' => '500mg', 
                'estimated_price' => 12.50
            ],
            [
                'rxcui' => '42355', 
                'generic_name' => 'Losartan Potassium', 
                'brand_name' => 'Cozaar', 
                'form' => 'Tablet', 
                'dosage_strength' => '50mg', 
                'estimated_price' => 22.00
            ],
            [
                'rxcui' => '161', 
                'generic_name' => 'Paracetamol', 
                'brand_name' => 'Biogesic', 
                'form' => 'Tablet', 
                'dosage_strength' => '500mg', 
                'estimated_price' => 5.00
            ],
            [
                'rxcui' => '6809', 
                'generic_name' => 'Metformin Hydrochloride', 
                'brand_name' => 'Glucophage', 
                'form' => 'Tablet', 
                'dosage_strength' => '500mg', 
                'estimated_price' => 15.75
            ],
            [
                'rxcui' => '7980', 
                'generic_name' => 'Penicillin G', 
                'brand_name' => 'Pentids', 
                'form' => 'Tablet', 
                'dosage_strength' => '250mg', 
                'estimated_price' => 18.00
            ],
        ];

        foreach ($meds as $med) {
            $medId = DB::table('medications')->insertGetId(array_merge($med, [
                'created_at' => now(),
                'updated_at' => now()
            ]));

            // ==========================================
            // 2. POPULATE DOH DPRI PRICING RECORDS
            // ==========================================
            // Links medication to pricing index
            DB::table('dpri_records')->insert([
                'medication_id' => $medId,
                'doh_raw_drug_name' => strtoupper($med['generic_name'] . ' ' . $med['dosage_strength']),
                'lowest_price' => $med['estimated_price'] * 0.8,
                'median_price' => $med['estimated_price'],
                'highest_price' => $med['estimated_price'] * 1.2,
                'effective_year' => 2025,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // ==========================================
        // 3. POPULATE PATIENT ALLERGIES (DUR Testing)
        // ==========================================
        // Fetch Maria Dela Cruz from your DatabaseSeeder
        $maria = User::where('email', 'maria@securx.com')->first();
        $penicillin = DB::table('medications')->where('generic_name', 'Penicillin G')->first();

        if ($maria && $penicillin) {
            DB::table('patient_allergies')->updateOrInsert(
                ['patient_id' => $maria->id, 'medication_id' => $penicillin->id],
                [
                    'id' => (string) Str::uuid(),
                    'allergen_name' => 'Penicillin G',
                    'reaction' => 'Severe Anaphylaxis / Skin Rashes',
                    'severity' => 'High Severity', // Matches enum in db_securx
                    'is_verified' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
            $this->command->info('Assigned Penicillin Allergy to Maria Dela Cruz for DUR testing.');
        }

        $this->command->info('Clinical Data Seeding Successful.');
    }
}