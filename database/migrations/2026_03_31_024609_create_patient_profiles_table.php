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
        
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->text('address')->nullable();
            $table->string('school_work')->nullable();
        
            $table->string('mother_name')->nullable();
            $table->string('mother_contact')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_contact')->nullable();
        
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
