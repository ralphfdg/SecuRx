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
        Schema::create('patient_profiles', function (Blueprint $table) {
            $table->id();
            
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

            // Demographics & Biometrics
            $table->date('date_of_birth');
            $table->enum('biological_sex', ['Male', 'Female']);
            $table->string('blood_type')->nullable();

            // Pediatric & Emergency Support
            $table->string('guardian_name')->nullable(); // Required if age < 18
            $table->string('guardian_contact_number')->nullable();

            $table->text('address')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_profiles');
    }
};
