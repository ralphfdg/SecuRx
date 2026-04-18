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
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
        
            $table->foreignUuid('prescription_id')->constrained('prescriptions')->cascadeOnDelete(); 
        
            // This links to your public DOH/NIH database. It is an unsignedBigInteger because the medications table uses standard IDs. 
            $table->foreignId('medication_id')->constrained('medications')->cascadeOnDelete(); 
            $table->boolean('is_maintenance')->default(false);
        
            $table->string('sig'); // Instructions: Dosage, frequency, duration 
            $table->integer('quantity'); 
            $table->integer('max_refills')->default(0); 
        
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};
