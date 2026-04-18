<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class MassiveEntitySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('en_PH');
        $now = Carbon::now();

        $this->command->info('Seeding Clinics...');
        for ($i = 0; $i < 10; $i++) {
            DB::table('clinics')->insert([
                'id' => Str::uuid()->toString(),
                'clinic_name' => $faker->company . ' Medical Center',
                'clinic_address' => $faker->address,
                'contact_number' => $faker->phoneNumber,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info('Seeding Specializations...');
        $specializations = ['Internal Medicine', 'Pediatrics', 'Cardiology', 'Dermatology', 'Neurology', 'Psychiatry', 'Family Medicine', 'Endocrinology', 'Gastroenterology', 'Oncology', 'Pulmonology', 'Rheumatology', 'Nephrology', 'Urology', 'Ophthalmology'];
        foreach ($specializations as $spec) {
            DB::table('specializations')->insert([
                'name' => $spec,
                'description' => $faker->sentence,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->command->info('Seeding 100 Curated Real-World Medications & DPRI Records...');
        
        $realMedications = [
            // Analgesics / Antipyretics / NSAIDs
            ['rxcui' => '161', 'generic' => 'Paracetamol', 'brand' => 'Biogesic', 'form' => 'Tablet', 'dose' => '500 mg', 'price' => 4.50],
            ['rxcui' => '5640', 'generic' => 'Ibuprofen', 'brand' => 'Advil', 'form' => 'Tablet', 'dose' => '400 mg', 'price' => 8.75],
            ['rxcui' => '7258', 'generic' => 'Naproxen', 'brand' => 'Flanax', 'form' => 'Tablet', 'dose' => '500 mg', 'price' => 15.25],
            ['rxcui' => '3322', 'generic' => 'Diclofenac', 'brand' => 'Voltaren', 'form' => 'Tablet', 'dose' => '50 mg', 'price' => 22.00],
            ['rxcui' => '140587', 'generic' => 'Celecoxib', 'brand' => 'Celebrex', 'form' => 'Capsule', 'dose' => '200 mg', 'price' => 45.00],
            ['rxcui' => '6718', 'generic' => 'Mefenamic Acid', 'brand' => 'Ponstan', 'form' => 'Capsule', 'dose' => '500 mg', 'price' => 10.00],
            ['rxcui' => '1191', 'generic' => 'Aspirin', 'brand' => 'Aspilet', 'form' => 'Tablet', 'dose' => '81 mg', 'price' => 3.50],
            ['rxcui' => '134747', 'generic' => 'Meloxicam', 'brand' => 'Mobic', 'form' => 'Tablet', 'dose' => '15 mg', 'price' => 30.00],
            ['rxcui' => '10689', 'generic' => 'Tramadol', 'brand' => 'Ultram', 'form' => 'Capsule', 'dose' => '50 mg', 'price' => 18.50],
            ['rxcui' => '6130', 'generic' => 'Ketorolac', 'brand' => 'Toradol', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 25.00],

            // Antibiotics / Antivirals / Antifungals
            ['rxcui' => '733', 'generic' => 'Amoxicillin', 'brand' => 'Amoxil', 'form' => 'Capsule', 'dose' => '500 mg', 'price' => 8.50],
            ['rxcui' => '18631', 'generic' => 'Azithromycin', 'brand' => 'Zithromax', 'form' => 'Tablet', 'dose' => '500 mg', 'price' => 85.00],
            ['rxcui' => '2551', 'generic' => 'Ciprofloxacin', 'brand' => 'Cipro', 'form' => 'Tablet', 'dose' => '500 mg', 'price' => 25.00],
            ['rxcui' => '2202', 'generic' => 'Cefuroxime', 'brand' => 'Zinnat', 'form' => 'Tablet', 'dose' => '500 mg', 'price' => 55.00],
            ['rxcui' => '2231', 'generic' => 'Cephalexin', 'brand' => 'Keflex', 'form' => 'Capsule', 'dose' => '500 mg', 'price' => 12.00],
            ['rxcui' => '3640', 'generic' => 'Doxycycline', 'brand' => 'Vibramycin', 'form' => 'Capsule', 'dose' => '100 mg', 'price' => 14.50],
            ['rxcui' => '2582', 'generic' => 'Clindamycin', 'brand' => 'Dalacin C', 'form' => 'Capsule', 'dose' => '300 mg', 'price' => 35.00],
            ['rxcui' => '6922', 'generic' => 'Metronidazole', 'brand' => 'Flagyl', 'form' => 'Tablet', 'dose' => '500 mg', 'price' => 16.00],
            ['rxcui' => '82122', 'generic' => 'Levofloxacin', 'brand' => 'Levaquin', 'form' => 'Tablet', 'dose' => '500 mg', 'price' => 45.00],
            ['rxcui' => '10180', 'generic' => 'Sulfamethoxazole', 'brand' => 'Bactrim', 'form' => 'Tablet', 'dose' => '800/160 mg', 'price' => 18.00],
            ['rxcui' => '2898', 'generic' => 'Fluconazole', 'brand' => 'Diflucan', 'form' => 'Capsule', 'dose' => '150 mg', 'price' => 150.00],
            ['rxcui' => '296', 'generic' => 'Acyclovir', 'brand' => 'Zovirax', 'form' => 'Tablet', 'dose' => '400 mg', 'price' => 22.00],
            ['rxcui' => '2002', 'generic' => 'Cefixime', 'brand' => 'Terramycin', 'form' => 'Capsule', 'dose' => '400 mg', 'price' => 40.00],
            ['rxcui' => '20536', 'generic' => 'Clarithromycin', 'brand' => 'Biaxin', 'form' => 'Tablet', 'dose' => '500 mg', 'price' => 60.00],
            ['rxcui' => '711', 'generic' => 'Amoxicillin/Clavulanate', 'brand' => 'Augmentin', 'form' => 'Tablet', 'dose' => '625 mg', 'price' => 45.00],

            // Antihypertensives / Cardiac
            ['rxcui' => '197361', 'generic' => 'Losartan Potassium', 'brand' => 'Lifezar', 'form' => 'Tablet', 'dose' => '50 mg', 'price' => 12.00],
            ['rxcui' => '17767', 'generic' => 'Amlodipine', 'brand' => 'Norvasc', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 15.00],
            ['rxcui' => '29046', 'generic' => 'Lisinopril', 'brand' => 'Prinivil', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 14.00],
            ['rxcui' => '69749', 'generic' => 'Valsartan', 'brand' => 'Diovan', 'form' => 'Tablet', 'dose' => '80 mg', 'price' => 28.00],
            ['rxcui' => '1202', 'generic' => 'Atenolol', 'brand' => 'Tenormin', 'form' => 'Tablet', 'dose' => '50 mg', 'price' => 8.00],
            ['rxcui' => '6918', 'generic' => 'Metoprolol', 'brand' => 'Lopressor', 'form' => 'Tablet', 'dose' => '50 mg', 'price' => 9.50],
            ['rxcui' => '5487', 'generic' => 'Hydrochlorothiazide', 'brand' => 'Microzide', 'form' => 'Tablet', 'dose' => '25 mg', 'price' => 6.00],
            ['rxcui' => '4603', 'generic' => 'Furosemide', 'brand' => 'Lasix', 'form' => 'Tablet', 'dose' => '40 mg', 'price' => 11.00],
            ['rxcui' => '10095', 'generic' => 'Spironolactone', 'brand' => 'Aldactone', 'form' => 'Tablet', 'dose' => '25 mg', 'price' => 16.50],
            ['rxcui' => '20015', 'generic' => 'Carvedilol', 'brand' => 'Coreg', 'form' => 'Tablet', 'dose' => '6.25 mg', 'price' => 18.00],
            ['rxcui' => '36567', 'generic' => 'Simvastatin', 'brand' => 'Zocor', 'form' => 'Tablet', 'dose' => '20 mg', 'price' => 14.50],
            ['rxcui' => '83367', 'generic' => 'Atorvastatin', 'brand' => 'Lipitor', 'form' => 'Tablet', 'dose' => '40 mg', 'price' => 26.00],
            ['rxcui' => '274783', 'generic' => 'Rosuvastatin', 'brand' => 'Crestor', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 32.00],
            ['rxcui' => '2598', 'generic' => 'Clonidine', 'brand' => 'Catapres', 'form' => 'Tablet', 'dose' => '75 mcg', 'price' => 15.00],
            ['rxcui' => '11289', 'generic' => 'Warfarin', 'brand' => 'Coumadin', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 30.00],
            ['rxcui' => '26225', 'generic' => 'Clopidogrel', 'brand' => 'Plavix', 'form' => 'Tablet', 'dose' => '75 mg', 'price' => 40.00],
            ['rxcui' => '3310', 'generic' => 'Digoxin', 'brand' => 'Lanoxin', 'form' => 'Tablet', 'dose' => '0.25 mg', 'price' => 12.00],
            ['rxcui' => '40114', 'generic' => 'Telmisartan', 'brand' => 'Micardis', 'form' => 'Tablet', 'dose' => '40 mg', 'price' => 28.00],
            ['rxcui' => '20004', 'generic' => 'Enalapril', 'brand' => 'Vasotec', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 10.00],
            ['rxcui' => '7242', 'generic' => 'Nifedipine', 'brand' => 'Calcibloc', 'form' => 'Tablet', 'dose' => '30 mg', 'price' => 20.00],

            // Antidiabetics
            ['rxcui' => '6809', 'generic' => 'Metformin', 'brand' => 'Glucophage', 'form' => 'Tablet', 'dose' => '500 mg', 'price' => 6.25],
            ['rxcui' => '4815', 'generic' => 'Glipizide', 'brand' => 'Glucotrol', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 8.00],
            ['rxcui' => '32968', 'generic' => 'Pioglitazone', 'brand' => 'Actos', 'form' => 'Tablet', 'dose' => '15 mg', 'price' => 22.00],
            ['rxcui' => '312171', 'generic' => 'Sitagliptin', 'brand' => 'Januvia', 'form' => 'Tablet', 'dose' => '50 mg', 'price' => 45.00],
            ['rxcui' => '274783', 'generic' => 'Insulin Glargine', 'brand' => 'Lantus', 'form' => 'Injection', 'dose' => '100 IU/mL', 'price' => 850.00],
            ['rxcui' => '54552', 'generic' => 'Gliclazide', 'brand' => 'Diamicron', 'form' => 'Tablet', 'dose' => '60 mg', 'price' => 16.00],
            ['rxcui' => '4816', 'generic' => 'Glyburide', 'brand' => 'Diabeta', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 7.50],
            ['rxcui' => '86009', 'generic' => 'Empagliflozin', 'brand' => 'Jardiance', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 55.00],
            ['rxcui' => '253182', 'generic' => 'Linagliptin', 'brand' => 'Trajenta', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 50.00],
            ['rxcui' => '6064', 'generic' => 'Insulin Human', 'brand' => 'Humulin R', 'form' => 'Injection', 'dose' => '100 IU/mL', 'price' => 450.00],

            // Gastrointestinal / PPIs / Antacids
            ['rxcui' => '7646', 'generic' => 'Omeprazole', 'brand' => 'Losec', 'form' => 'Capsule', 'dose' => '20 mg', 'price' => 22.50],
            ['rxcui' => '40790', 'generic' => 'Pantoprazole', 'brand' => 'Protonix', 'form' => 'Tablet', 'dose' => '40 mg', 'price' => 28.00],
            ['rxcui' => '25946', 'generic' => 'Lansoprazole', 'brand' => 'Prevacid', 'form' => 'Capsule', 'dose' => '30 mg', 'price' => 25.00],
            ['rxcui' => '9143', 'generic' => 'Ranitidine', 'brand' => 'Zantac', 'form' => 'Tablet', 'dose' => '150 mg', 'price' => 12.00],
            ['rxcui' => '4278', 'generic' => 'Famotidine', 'brand' => 'Pepcid', 'form' => 'Tablet', 'dose' => '20 mg', 'price' => 15.00],
            ['rxcui' => '7407', 'generic' => 'Ondansetron', 'brand' => 'Zofran', 'form' => 'Tablet', 'dose' => '8 mg', 'price' => 40.00],
            ['rxcui' => '6902', 'generic' => 'Metoclopramide', 'brand' => 'Plasil', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 8.00],
            ['rxcui' => '3554', 'generic' => 'Domperidone', 'brand' => 'Motilium', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 14.00],
            ['rxcui' => '6579', 'generic' => 'Loperamide', 'brand' => 'Imodium', 'form' => 'Capsule', 'dose' => '2 mg', 'price' => 10.00],
            ['rxcui' => '164', 'generic' => 'Hyoscine Butylbromide', 'brand' => 'Buscopan', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 12.50],

            // Respiratory / Allergy / Asthma
            ['rxcui' => '20610', 'generic' => 'Cetirizine', 'brand' => 'Virlix', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 18.00],
            ['rxcui' => '6470', 'generic' => 'Loratadine', 'brand' => 'Claritin', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 20.00],
            ['rxcui' => '3498', 'generic' => 'Diphenhydramine', 'brand' => 'Benadryl', 'form' => 'Capsule', 'dose' => '50 mg', 'price' => 8.00],
            ['rxcui' => '435', 'generic' => 'Salbutamol', 'brand' => 'Ventolin', 'form' => 'Syrup', 'dose' => '2mg/5mL', 'price' => 120.00],
            ['rxcui' => '105223', 'generic' => 'Montelukast', 'brand' => 'Singulair', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 35.00],
            ['rxcui' => '41126', 'generic' => 'Fluticasone', 'brand' => 'Flixonase', 'form' => 'Nasal Spray', 'dose' => '50 mcg', 'price' => 350.00],
            ['rxcui' => '1808', 'generic' => 'Budesonide', 'brand' => 'Pulmicort', 'form' => 'Nebule', 'dose' => '0.25 mg/mL', 'price' => 180.00],
            ['rxcui' => '6646', 'generic' => 'Levocetirizine', 'brand' => 'Xyzal', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 25.00],
            ['rxcui' => '4337', 'generic' => 'Guaifenesin', 'brand' => 'Robitussin', 'form' => 'Syrup', 'dose' => '100mg/5mL', 'price' => 150.00],
            ['rxcui' => '126', 'generic' => 'Acetylcysteine', 'brand' => 'Fluimucil', 'form' => 'Sachet', 'dose' => '600 mg', 'price' => 45.00],

            // Neuro / Psych / Sleep
            ['rxcui' => '36676', 'generic' => 'Sertraline', 'brand' => 'Zoloft', 'form' => 'Tablet', 'dose' => '50 mg', 'price' => 50.00],
            ['rxcui' => '4493', 'generic' => 'Fluoxetine', 'brand' => 'Prozac', 'form' => 'Capsule', 'dose' => '20 mg', 'price' => 45.00],
            ['rxcui' => '2556', 'generic' => 'Citalopram', 'brand' => 'Celexa', 'form' => 'Tablet', 'dose' => '20 mg', 'price' => 35.00],
            ['rxcui' => '32968', 'generic' => 'Escitalopram', 'brand' => 'Lexapro', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 40.00],
            ['rxcui' => '704', 'generic' => 'Alprazolam', 'brand' => 'Xanax', 'form' => 'Tablet', 'dose' => '0.5 mg', 'price' => 30.00],
            ['rxcui' => '6470', 'generic' => 'Lorazepam', 'brand' => 'Ativan', 'form' => 'Tablet', 'dose' => '1 mg', 'price' => 25.00],
            ['rxcui' => '3322', 'generic' => 'Diazepam', 'brand' => 'Valium', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 15.00],
            ['rxcui' => '2598', 'generic' => 'Clonazepam', 'brand' => 'Klonopin', 'form' => 'Tablet', 'dose' => '2 mg', 'price' => 20.00],
            ['rxcui' => '11413', 'generic' => 'Zolpidem', 'brand' => 'Ambien', 'form' => 'Tablet', 'dose' => '10 mg', 'price' => 55.00],
            ['rxcui' => '4603', 'generic' => 'Gabapentin', 'brand' => 'Neurontin', 'form' => 'Capsule', 'dose' => '300 mg', 'price' => 35.00],

            // Vitamins / Supplements / Electrolytes
            ['rxcui' => '1116', 'generic' => 'Ascorbic Acid (Vitamin C)', 'brand' => 'Poten-Cee', 'form' => 'Tablet', 'dose' => '500 mg', 'price' => 6.00],
            ['rxcui' => '3872', 'generic' => 'Calcium Carbonate', 'brand' => 'Caltrate', 'form' => 'Tablet', 'dose' => '600 mg', 'price' => 12.00],
            ['rxcui' => '26156', 'generic' => 'Cholecalciferol (Vitamin D3)', 'brand' => 'Forti-D', 'form' => 'Capsule', 'dose' => '800 IU', 'price' => 15.00],
            ['rxcui' => '5531', 'generic' => 'Ferrous Sulfate', 'brand' => 'Iberet', 'form' => 'Tablet', 'dose' => '325 mg', 'price' => 8.50],
            ['rxcui' => '4491', 'generic' => 'Folic Acid', 'brand' => 'Folart', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 5.00],
            ['rxcui' => '8787', 'generic' => 'Potassium Chloride', 'brand' => 'Kalium Durules', 'form' => 'Tablet', 'dose' => '750 mg', 'price' => 20.00],
            ['rxcui' => '11253', 'generic' => 'Vitamin B Complex', 'brand' => 'Neurobion', 'form' => 'Tablet', 'dose' => '100 mg', 'price' => 18.00],
            ['rxcui' => '11416', 'generic' => 'Zinc Sulfate', 'brand' => 'E-Zinc', 'form' => 'Syrup', 'dose' => '20mg/5mL', 'price' => 110.00],
            ['rxcui' => '6703', 'generic' => 'Magnesium Oxide', 'brand' => 'Mag-Ox', 'form' => 'Tablet', 'dose' => '400 mg', 'price' => 10.00],
            ['rxcui' => '3060', 'generic' => 'Cyanocobalamin (Vitamin B12)', 'brand' => 'Vaneurin', 'form' => 'Tablet', 'dose' => '500 mcg', 'price' => 9.00],

            // Dermatological / Topical / Ophthalmic
            ['rxcui' => '5401', 'generic' => 'Hydrocortisone', 'brand' => 'Cortizone', 'form' => 'Cream', 'dose' => '1%', 'price' => 150.00],
            ['rxcui' => '7460', 'generic' => 'Mupirocin', 'brand' => 'Bactroban', 'form' => 'Ointment', 'dose' => '2%', 'price' => 220.00],
            ['rxcui' => '6147', 'generic' => 'Ketoconazole', 'brand' => 'Nizoral', 'form' => 'Cream', 'dose' => '2%', 'price' => 350.00],
            ['rxcui' => '3322', 'generic' => 'Diclofenac', 'brand' => 'Voltaren Emulgel', 'form' => 'Gel', 'dose' => '1%', 'price' => 280.00],
            ['rxcui' => '2332', 'generic' => 'Chloramphenicol', 'brand' => 'Spersadex', 'form' => 'Eye Drops', 'dose' => '0.5%', 'price' => 180.00],
            ['rxcui' => '41126', 'generic' => 'Fluticasone', 'brand' => 'Cutivate', 'form' => 'Cream', 'dose' => '0.05%', 'price' => 450.00],
            ['rxcui' => '105436', 'generic' => 'Betamethasone', 'brand' => 'Betnovate', 'form' => 'Cream', 'dose' => '0.1%', 'price' => 200.00],
            ['rxcui' => '2618', 'generic' => 'Clotrimazole', 'brand' => 'Canesten', 'form' => 'Cream', 'dose' => '1%', 'price' => 190.00],
            ['rxcui' => '10582', 'generic' => 'Terbinafine', 'brand' => 'Lamisil', 'form' => 'Cream', 'dose' => '1%', 'price' => 380.00],
            ['rxcui' => '2381', 'generic' => 'Timolol', 'brand' => 'Nyolol', 'form' => 'Eye Drops', 'dose' => '0.5%', 'price' => 320.00],

            // Thyroid / Hormones / Endocrine
            ['rxcui' => '6373', 'generic' => 'Levothyroxine', 'brand' => 'Euthyrox', 'form' => 'Tablet', 'dose' => '50 mcg', 'price' => 12.00],
            ['rxcui' => '6883', 'generic' => 'Methimazole', 'brand' => 'Tapazole', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 18.00],
            ['rxcui' => '8640', 'generic' => 'Propylthiouracil', 'brand' => 'PTU', 'form' => 'Tablet', 'dose' => '50 mg', 'price' => 15.00],
            ['rxcui' => '8371', 'generic' => 'Prednisone', 'brand' => 'Meticorten', 'form' => 'Tablet', 'dose' => '5 mg', 'price' => 5.50],
            ['rxcui' => '6904', 'generic' => 'Methylprednisolone', 'brand' => 'Medrol', 'form' => 'Tablet', 'dose' => '4 mg', 'price' => 14.00],
        ];

        foreach ($realMedications as $med) {
            // Insert into medications table
            $medId = DB::table('medications')->insertGetId([
                'rxcui' => $med['rxcui'],
                'generic_name' => $med['generic'],
                'brand_name' => $med['brand'],
                'form' => $med['form'],
                'dosage_strength' => $med['dose'],
                'estimated_price' => $med['price'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Create minor variance for DOH DPRI simulated data
            $lowest = $med['price'] * 0.7;
            $highest = $med['price'] * 1.5;

            // Insert into dpri_records table
            DB::table('dpri_records')->insert([
                'medication_id' => $medId,
                'doh_raw_drug_name' => strtoupper($med['generic'] . ' ' . $med['dose'] . ' ' . $med['form']),
                'lowest_price' => number_format($lowest, 2, '.', ''),
                'median_price' => number_format($med['price'], 2, '.', ''),
                'highest_price' => number_format($highest, 2, '.', ''),
                'effective_year' => '2026',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}