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
        Schema::create('patient_allergies', function (Blueprint $table) {
            $table->uuid('id')->primary();
        
            $table->foreignUuid('patient_id')->constrained('users')->cascadeOnDelete();
        
            // Links to the DOH database if it's a known drug allergy. Nullable for environmental or unlisted allergies.
            $table->foreignId('medication_id')->nullable()->constrained('medications')->nullOnDelete();
        
            $table->string('allergen_name');
            $table->string('reaction')->nullable();
            $table->enum('severity', ['Low', 'Medium', 'High Severity']);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_allergies');
    }
};
