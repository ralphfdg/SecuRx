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
        Schema::create('dpri_records', function (Blueprint $table) {
            $table->id();
            
            // Nullable foreign key allows importing raw DOH data first, 
            // then mapping it to your internal medications later.
            $table->foreignId('medication_id')
                  ->nullable()
                  ->constrained('medications')
                  ->nullOnDelete();
                  
            // Captures the exact, unformatted string from the DOH document
            $table->string('doh_raw_drug_name', 500);
            
            // Expanded decimals to handle highly specialized/expensive drugs
            $table->decimal('lowest_price', 10, 2)->nullable();
            $table->decimal('median_price', 10, 2)->nullable();
            $table->decimal('highest_price', 10, 2)->nullable();
            
            // Tracks which DOH release this pricing belongs to
            $table->year('effective_year');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpri_records');
    }
};