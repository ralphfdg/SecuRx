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
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('doctor_id')->constrained('users');
            $table->foreignUuid('patient_id')->constrained('users');

            // Clinical Data
            $table->string('primary_condition');
            $table->string('icd_10_code')->nullable(); 
            $table->text('clinical_notes')->nullable(); 

            $table->timestamp('diagnosed_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};
