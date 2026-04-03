<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adding verification flags safely to the end of the tables
        Schema::table('patient_allergies', function (Blueprint $table) {
            if (! Schema::hasColumn('patient_allergies', 'is_verified')) {
                $table->boolean('is_verified')->default(false);
            }
        });

        Schema::table('immunizations', function (Blueprint $table) {
            if (! Schema::hasColumn('immunizations', 'is_verified')) {
                $table->boolean('is_verified')->default(false);
            }
        });

        Schema::table('lab_results', function (Blueprint $table) {
            if (! Schema::hasColumn('lab_results', 'is_verified')) {
                $table->boolean('is_verified')->default(false);
            }
        });

        Schema::table('medical_documents', function (Blueprint $table) {
            if (! Schema::hasColumn('medical_documents', 'is_verified')) {
                $table->boolean('is_verified')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('patient_allergies', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
        Schema::table('immunizations', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
        Schema::table('lab_results', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
        Schema::table('medical_documents', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }
};
