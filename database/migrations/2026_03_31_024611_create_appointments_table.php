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
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
        
            $table->foreignUuid('patient_id')->constrained('users')->cascadeOnDelete(); 
            $table->foreignUuid('doctor_id')->constrained('users')->cascadeOnDelete(); 
        
            // Nullable because a patient can book online without a secretary's help 
            $table->foreignUuid('secretary_id')->nullable()->constrained('users')->nullOnDelete(); 
        
            $table->dateTime('appointment_date')->index(); 
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending'); 
        
            // Stores BP, weight, etc., inputted by the secretary during triage 
            $table->json('triage_vitals')->nullable(); 
        
            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
