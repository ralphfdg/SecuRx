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
        Schema::create('immunizations', function (Blueprint $table) {
            $table->uuid('id')->primary();
        
            $table->foreignUuid('patient_id')->constrained('users')->cascadeOnDelete();
            $table->string('vaccine_name');
            $table->string('facility')->nullable();
        
            $table->date('administered_date');
            $table->date('valid_until')->nullable(); // Important for boosters
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('immunizations');
    }
};
