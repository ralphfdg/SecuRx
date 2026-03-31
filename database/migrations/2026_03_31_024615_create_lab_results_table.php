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
        Schema::create('lab_results', function (Blueprint $table) {
            $table->uuid('id')->primary();
        
            $table->foreignUuid('patient_id')->constrained('users')->cascadeOnDelete();
        
            $table->string('test_name');
            $table->date('test_date');
            $table->string('file_path'); // The secure server path to the uploaded PDF file
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_results');
    }
};
