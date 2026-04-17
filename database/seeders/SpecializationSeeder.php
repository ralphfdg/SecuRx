<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            [
                'name' => 'General Practice', 
                'description' => 'Comprehensive health care for patients of all ages.'
            ],
            [
                'name' => 'Cardiology', 
                'description' => 'Diagnosis and treatment of heart and blood vessel disorders.'
            ],
            [
                'name' => 'Dermatology', 
                'description' => 'Treatment of skin, hair, and nail conditions.'
            ],
            [
                'name' => 'Endocrinology', 
                'description' => 'Focuses on hormone imbalances and metabolic disorders (e.g., Diabetes).'
            ],
            [
                'name' => 'Gastroenterology', 
                'description' => 'Management of digestive system and gastrointestinal tract disorders.'
            ],
            [
                'name' => 'Neurology', 
                'description' => 'Diagnosis and treatment of nervous system disorders.'
            ],
            [
                'name' => 'Pediatrics', 
                'description' => 'Medical care of infants, children, and adolescents.'
            ],
            [
                'name' => 'Psychiatry', 
                'description' => 'Treatment of mental health and behavioral disorders.'
            ],
            [
                'name' => 'Oncology', 
                'description' => 'Diagnosis, therapy, and ongoing care for cancer patients.'
            ],
            [
                'name' => 'Orthopedics', 
                'description' => 'Treatment of the musculoskeletal system, including bones and joints.'
            ],
        ];

        foreach ($specializations as $spec) {
            Specialization::firstOrCreate(
                ['name' => $spec['name']], // Search by name
                ['description' => $spec['description']] // Update/Create with this description
            );
        }
    }
}