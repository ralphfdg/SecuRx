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
            $table->uuid('id')->primary();
            // Links directly to the core user account. If the user is deleted, this profile deletes too.
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
        
            $table->date('date_of_birth');
            $table->enum('biological_sex', ['Male', 'Female']);
            $table->string('blood_type', 25)->nullable();
        
            $table->string('guardian_name')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->text('address')->nullable();
        
            // Critical for Data Privacy Act compliance
            $table->boolean('data_consent')->default(false); 
        
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
