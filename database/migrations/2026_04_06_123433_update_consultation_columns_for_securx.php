<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update Prescriptions Table
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->boolean('print_patient_name')->default(true)->after('doctor_id');
            $table->text('general_instructions')->nullable()->after('print_patient_name');
        });

        // 2. Update Encounters Table
        Schema::table('encounters', function (Blueprint $table) {
            $table->date('next_appointment_date')->nullable()->after('encounter_date');
        });

        // 3. Update Prescription Items Table
        Schema::table('prescription_items', function (Blueprint $table) {
            // Adding the granular fields from the UI
            $table->string('dose')->nullable()->after('medication_id');
            $table->string('frequency')->nullable()->after('dose');
            $table->string('duration')->nullable()->after('frequency');
            $table->string('pharmacist_instructions')->nullable()->after('duration');
            $table->string('patient_instructions')->nullable()->after('pharmacist_instructions');
            
            // Note: We are keeping your original 'sig' and 'quantity' columns intact.
            // You can use 'sig' to store the compiled string if needed for standard printing.
        });
    }

    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn(['print_patient_name', 'general_instructions']);
        });

        Schema::table('encounters', function (Blueprint $table) {
            $table->dropColumn('next_appointment_date');
        });

        Schema::table('prescription_items', function (Blueprint $table) {
            $table->dropColumn([
                'dose', 
                'frequency', 
                'duration', 
                'pharmacist_instructions', 
                'patient_instructions'
            ]);
        });
    }
};