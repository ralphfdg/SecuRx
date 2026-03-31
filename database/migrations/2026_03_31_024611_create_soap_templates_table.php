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
        Schema::create('soap_templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
        
            // Links to users.id to ensure templates are private to the doctor who created them
            $table->foreignUuid('doctor_id')->constrained('users')->cascadeOnDelete();
        
            $table->string('template_name');
            $table->text('subjective_text')->nullable();
            $table->text('objective_text')->nullable();
            $table->text('assessment_text')->nullable();
            $table->text('plan_text')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soap_templates');
    }
};
