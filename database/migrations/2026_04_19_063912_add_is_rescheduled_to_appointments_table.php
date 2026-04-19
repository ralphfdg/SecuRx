<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_is_rescheduled_to_appointments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Adds a flag to track if the appointment date/time was altered
            $table->boolean('is_rescheduled')->default(false)->after('appointment_type');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('is_rescheduled');
        });
    }
};