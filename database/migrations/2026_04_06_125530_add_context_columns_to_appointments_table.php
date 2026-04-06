<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Allows patients/secretaries to log the initial complaint
            $table->string('reason_for_visit')->nullable()->after('appointment_time');

            // Tracks where the appointment originated for analytics
            $table->enum('appointment_type', ['online', 'walk-in', 'follow-up'])->default('online')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['reason_for_visit', 'appointment_type']);
        });
    }
};
