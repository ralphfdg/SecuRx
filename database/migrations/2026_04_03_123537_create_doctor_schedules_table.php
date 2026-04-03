<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Your standard UUID protection
            $table->foreignUuid('doctor_id')->constrained('users')->cascadeOnDelete();
            
            $table->string('day_of_week'); // e.g., 'Monday', 'Tuesday'
            $table->time('start_time');    // e.g., '09:00:00'
            $table->time('end_time');      // e.g., '17:00:00'
            
            // Optional but highly recommended: Allows a doctor to temporarily block a day without deleting the row
            $table->boolean('is_available')->default(true); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};