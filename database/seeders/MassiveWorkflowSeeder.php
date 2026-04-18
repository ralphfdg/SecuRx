<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class MassiveWorkflowSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('en_PH');
        $now = Carbon::now();

        $patients = DB::table('users')->where('role', 'patient')->pluck('id')->toArray();
        $doctors = DB::table('users')->where('role', 'doctor')->pluck('id')->toArray();
        $secretaries = DB::table('users')->where('role', 'secretary')->pluck('id')->toArray();
        $pharmacists = DB::table('users')->where('role', 'pharmacist')->pluck('id')->toArray();
        $medications = DB::table('medications')->pluck('id')->toArray();

        $this->command->info('Seeding Medical Records (Allergies & Immunizations)...');
        foreach ($patients as $patId) {
            for ($i = 0; $i < rand(0, 3); $i++) {
                DB::table('patient_allergies')->insert([
                    'id' => Str::uuid()->toString(),
                    'patient_id' => $patId,
                    'medication_id' => $faker->randomElement($medications),
                    'allergen_name' => $faker->randomElement(['Penicillin', 'Ibuprofen', 'Sulfa Drugs', 'Aspirin', 'Amoxicillin']),
                    'severity' => $faker->randomElement(['Low', 'Medium', 'High Severity']),
                    'is_verified' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            for ($i = 0; $i < rand(1, 2); $i++) {
                DB::table('immunizations')->insert([
                    'id' => Str::uuid()->toString(),
                    'patient_id' => $patId,
                    'vaccine_name' => $faker->randomElement(['COVID-19 (Pfizer)', 'Flu Vaccine', 'Hepatitis B', 'Tetanus Toxoid']),
                    'administered_date' => $faker->date('Y-m-d', 'now'),
                    'is_verified' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $this->command->info('Seeding 200 Appointments, Encounters, and Strict-Refill Prescriptions...');
        $statuses = ['pending', 'confirmed', 'in-progress', 'completed', 'cancelled'];
        
        for ($i = 0; $i < 200; $i++) {
            $appointmentId = Str::uuid()->toString();
            $status = $faker->randomElement($statuses);
            
            DB::table('appointments')->insert([
                'id' => $appointmentId,
                'patient_id' => $faker->randomElement($patients),
                'doctor_id' => $faker->randomElement($doctors),
                'secretary_id' => $faker->randomElement($secretaries),
                'appointment_date' => $now->copy()->subDays(rand(1, 30))->toDateString(),
                'appointment_time' => $faker->time('H:i:s'),
                'reason_for_visit' => $faker->randomElement(['Follow up checkup', 'Mild fever and coughing', 'Hypertension monitoring', 'Routine physical']),
                'status' => $status,
                'appointment_type' => $faker->randomElement(['online', 'walk-in', 'follow-up']),
                'triage_vitals' => json_encode(['bp' => rand(110,140).'/'.rand(70,90), 'temp' => rand(36, 39).'.'.$faker->randomDigit, 'weight' => rand(50, 100)]),
                'created_at' => $now->copy()->subDays(31),
                'updated_at' => $now,
            ]);

            // Only create encounters/prescriptions if appointment is completed
            if ($status === 'completed') {
                $encounterId = Str::uuid()->toString();
                
                DB::table('encounters')->insert([
                    'id' => $encounterId,
                    'appointment_id' => $appointmentId,
                    'patient_id' => $faker->randomElement($patients),
                    'doctor_id' => $faker->randomElement($doctors),
                    'encounter_title' => 'Outpatient Clinic Visit',
                    'subjective_note' => $faker->randomElement([
                        'Patient complains of intermittent headaches and slight dizziness for 3 days. No vomiting.', 
                        'Patient reports a persistent dry cough and mild fever starting yesterday.', 
                        'Routine follow-up for hypertension. Patient states they have been compliant with meds.'
                    ]),
                    'objective_note' => $faker->randomElement([
                        'BP: 130/85, HR: 88, Temp: 37.2°C. Patient is alert, oriented x3. Lungs clear to auscultation.', 
                        'Throat is slightly erythematous. No cervical lymphadenopathy. Heart rate regular.', 
                        'Abdomen soft, non-tender. Neuro exam grossly intact.'
                    ]),
                    'assessment_note' => $faker->randomElement([
                        'Acute upper respiratory infection.', 
                        'Essential hypertension, currently well-controlled.', 
                        'Tension headache, likely stress-related.'
                    ]),
                    'plan_note' => $faker->randomElement([
                        'Prescribed maintenance meds. Advised low sodium diet. Follow up in 1 month.', 
                        'Start antibiotics and supportive care. Increase oral fluid intake.', 
                        'Rest, hydration, and OTC analgesics as needed for pain.'
                    ]),
                    'encounter_date' => $now->toDateString(),
                    'created_at' => $now->copy()->subDays(rand(1, 30)),
                    'updated_at' => $now,
                ]);

                $prescriptionId = Str::uuid()->toString();
                DB::table('prescriptions')->insert([
                    'id' => $prescriptionId,
                    'encounter_id' => $encounterId,
                    'patient_id' => $faker->randomElement($patients),
                    'doctor_id' => $faker->randomElement($doctors),
                    'print_patient_name' => 1,
                    'general_instructions' => $faker->randomElement([
                        'Please complete the entire course of medication.', 
                        'Monitor blood pressure daily and record in a logbook.', 
                        'Return to the clinic if symptoms worsen after 3 days.'
                    ]),
                    'status' => $faker->randomElement(['active', 'dispensed', 'expired']),
                    'expires_at' => $now->copy()->addDays(30),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                // 1 to 3 items per prescription with strictly enforced Refill constraints
                for ($j = 0; $j < rand(1, 3); $j++) {
                    $itemId = Str::uuid()->toString();
                    $dose = rand(1, 2) . ' tablet(s)';
                    $frequency = 'every ' . rand(4, 12) . ' hours';
                    $duration = rand(5, 14) . ' days';
                    
                    // --- THE FIX IS HERE ---
                    $isMaintenance = rand(0, 1); 
                    // If it is maintenance, allow 1 to 5 refills. If acute (0), lock strictly to 0.
                    $maxRefills = $isMaintenance ? rand(1, 5) : 0; 
                    // -----------------------

                    DB::table('prescription_items')->insert([
                        'id' => $itemId,
                        'prescription_id' => $prescriptionId,
                        'medication_id' => $faker->randomElement($medications),
                        'dose' => $dose,
                        'frequency' => $frequency,
                        'duration' => $duration,
                        'pharmacist_instructions' => $faker->randomElement([
                            'Dispense generic equivalent if patient requests.', 
                            'Verify patient allergies against current profile before dispensing.', 
                            'Provide detailed counseling on potential gastric side effects.'
                        ]),
                        'patient_instructions' => $faker->randomElement([
                            'Take strictly after meals to avoid stomach upset.', 
                            'Do not crush or chew the tablet. Swallow whole.', 
                            'Avoid alcohol consumption while taking this medication.'
                        ]),
                        'is_maintenance' => $isMaintenance,
                        'sig' => "Take $dose $frequency for $duration",
                        'quantity' => rand(10, 30),
                        'max_refills' => $maxRefills,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    // Simulate some being dispensed
                    if (rand(1, 100) > 50) {
                        $logId = Str::uuid()->toString();
                        DB::table('dispensing_logs')->insert([
                            'id' => $logId,
                            'prescription_item_id' => $itemId,
                            'pharmacist_id' => $faker->randomElement($pharmacists),
                            'quantity_dispensed' => rand(5, 30),
                            'receiver_id_presented' => 'UMID-' . rand(100000, 999999),
                            'dispensed_at' => $now,
                        ]);

                        // 10% chance it required an override justification
                        if (rand(1, 100) > 90) {
                            DB::table('override_justifications')->insert([
                                'id' => Str::uuid()->toString(),
                                'dispensing_log_id' => $logId,
                                'warning_type' => $faker->randomElement(['allergy', 'interaction', 'max_refill', 'time_gate']),
                                'justification_note' => 'Consulted with prescribing physician. Benefit outweighs risk. Proceeded with dispense.',
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]);
                        }
                    }
                }
            }
        }
    }
}