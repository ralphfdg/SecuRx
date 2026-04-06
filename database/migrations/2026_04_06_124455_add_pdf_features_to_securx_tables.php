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
        // 1. Add Two-Factor Authentication columns to 'users' table
        Schema::table('users', function (Blueprint $table) {
            $table->text('two_factor_secret')->nullable()->after('password');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');
        });

        // 2. Add revocation tracking to 'prescriptions' table
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->text('revocation_reason')->nullable()->after('status');
        });

        // 3. Create the Global Platform 'settings' table
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // e.g., 'system_maintenance_mode', 'max_daily_appointments'
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Remove 2FA columns
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at'
            ]);
        });

        // 2. Remove revocation tracking
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn('revocation_reason');
        });

        // 3. Drop settings table
        Schema::dropIfExists('settings');
    }
};