<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The list of tables that need the deleted_at column appended.
     * * @var array
     */
    protected array $tables = [
        'encounters',
        'patient_allergies',
        'immunizations',
        'lab_results',
        'medical_documents',
        'clinics',
        'soap_templates',
        'authorized_representatives',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                // Appends the 'deleted_at' timestamp column
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                // Drops the 'deleted_at' column if we rollback
                $table->dropSoftDeletes();
            });
        }
    }
};