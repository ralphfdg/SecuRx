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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();

            // Updated to foreignUuid
            $table->foreignUuid('doctor_id')->constrained('users');
            $table->foreignUuid('patient_id')->constrained('users');

            // Link to the Diagnosis (Why was this prescribed?)
            $table->foreignId('diagnosis_id')->nullable()->constrained('diagnoses');
            $table->foreignId('medication_id')->constrained('medications');

            $table->uuid('qr_token')->unique()->nullable();
            $table->text('dosage_instructions');

            // Telemetry
            $table->integer('days_supply_per_refill')->default(30);
            $table->integer('max_refills')->default(1);
            $table->integer('refills_used')->default(0);
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
