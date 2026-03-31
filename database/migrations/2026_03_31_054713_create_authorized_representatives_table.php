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
        Schema::create('authorized_representatives', function (Blueprint $table) {
            $table->uuid('id')->primary();
        
            // The patient who owns this list
            $table->foreignUuid('patient_id')->constrained('users')->cascadeOnDelete();
        
            $table->string('full_name');
            $table->string('relationship'); // e.g., 'Son', 'Caregiver', 'Spouse'
        
            // Allows the patient to temporarily revoke access without deleting the record
            $table->boolean('is_active')->default(true); 
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authorized_representatives');
    }
};
