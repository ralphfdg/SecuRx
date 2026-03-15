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
            $table->id();
            
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');

            // Professional Credentials
            $table->string('specialization');
            $table->string('prc_license_number')->unique(); // Standard medical license
            $table->string('ptr_number')->nullable(); // Professional Tax Receipt
            $table->string('s2_license_number')->nullable(); // Required for prescribing dangerous drugs

            $table->string('clinic_name')->nullable();
            $table->text('clinic_address')->nullable();

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
