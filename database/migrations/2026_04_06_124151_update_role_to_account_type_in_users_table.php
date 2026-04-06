<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Create the new strict ENUM column
            $table->enum('account_type', ['patient', 'doctor', 'pharmacist', 'secretary', 'admin'])
                  ->default('patient')
                  ->after('mobile_num');
        });

        // 2. Transfer existing data from 'role' to 'account_type' to prevent data loss
        DB::statement('UPDATE users SET account_type = role');

        Schema::table('users', function (Blueprint $table) {
            // 3. Drop the old varchar column
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('patient')->after('mobile_num');
        });

        DB::statement('UPDATE users SET role = account_type');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('account_type');
        });
    }
};