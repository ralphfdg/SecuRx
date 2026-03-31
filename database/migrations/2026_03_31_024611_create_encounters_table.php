<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('encounters', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
        
            // Nullable because a patient might log a manual historical encounter without an official system appointment 
            $table->foreignUuid('appointment_id')->nullable()->constrained('appointments')->nullOnDelete(); 
        
            $table->foreignUuid('patient_id')->constrained('users')->cascadeOnDelete(); 
        
            // Nullable if the patient logs a past encounter from an outside clinic 
            $table->foreignUuid('doctor_id')->nullable()->constrained('users')->nullOnDelete(); 
        
            $table->string('encounter_title')->nullable(); 
            $table->text('subjective_note')->nullable(); 
            $table->text('objective_note')->nullable(); 
            $table->text('assessment_note')->nullable(); 
            $table->text('plan_note')->nullable(); 
        
            // Flags if the doctor enabled "Sensitive Encounter Mode" to hide data from standard views 
            $table->boolean('is_sensitive')->default(false); 
            $table->date('encounter_date'); 
        
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encounters');
    }
};
