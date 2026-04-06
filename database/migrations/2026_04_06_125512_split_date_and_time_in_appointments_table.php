<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add the new nullable time column
        Schema::table('appointments', function (Blueprint $table) {
            $table->time('appointment_time')->nullable()->after('appointment_date');
        });

        // 2. Change the existing datetime column into a strict date column
        Schema::table('appointments', function (Blueprint $table) {
            $table->date('appointment_date')->change();
        });
    }

    public function down(): void
    {
        // Reverse the changes if you ever need to rollback
        Schema::table('appointments', function (Blueprint $table) {
            $table->dateTime('appointment_date')->change();
            $table->dropColumn('appointment_time');
        });
    }
};
