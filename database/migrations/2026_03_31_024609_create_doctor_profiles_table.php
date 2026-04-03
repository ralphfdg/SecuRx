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
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
        
            // Links the doctor to a specific clinic from Batch 1
            $table->foreignUuid('clinic_id')->nullable()->constrained('clinics')->nullOnDelete();
        
            $table->string('prc_number')->unique();
            $table->date('prc_expiration');
            $table->string('ptr_number');
            $table->string('s2_number')->nullable();
            $table->date('s2_expiration')->nullable();
        
            // Admin must verify them before they can prescribe
            $table->boolean('is_verified')->default(false);
        
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};
