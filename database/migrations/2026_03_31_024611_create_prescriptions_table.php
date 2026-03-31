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
            $table->uuid('id')->primary(); // This is the cryptographic string embedded in the QR code 
        
            $table->foreignUuid('encounter_id')->constrained('encounters')->cascadeOnDelete(); 
            $table->foreignUuid('patient_id')->constrained('users')->cascadeOnDelete(); 
            $table->foreignUuid('doctor_id')->constrained('users')->cascadeOnDelete(); 
        
            $table->enum('status', ['active', 'dispensed', 'revoked', 'expired'])->index(); 
            $table->dateTime('expires_at')->nullable(); 
        
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
