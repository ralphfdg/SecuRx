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
        Schema::create('override_justifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); 
        
            $table->foreignUuid('dispensing_log_id')->constrained('dispensing_logs')->cascadeOnDelete(); 
        
            $table->enum('warning_type', ['allergy', 'interaction', 'max_refill', 'time_gate']); 
            $table->text('justification_note'); // Mandatory legal justification 
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('override_justifications');
    }
};
