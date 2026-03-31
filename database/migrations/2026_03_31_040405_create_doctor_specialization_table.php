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
        Schema::create('doctor_specialization', function (Blueprint $table) {
            $table->id();
            // Links to the doctor
            $table->foreignUuid('doctor_id')->constrained('users')->cascadeOnDelete();
            // Links to the specialization
            $table->foreignId('specialization_id')->constrained('specializations')->cascadeOnDelete();
        
            // Prevents duplicate entries (a doctor can't be a Cardiologist twice)
            $table->unique(['doctor_id', 'specialization_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_specialization');
    }
};
