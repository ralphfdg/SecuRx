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
        Schema::create('pharmacist_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
        
            $table->string('pharmacy_name');
            $table->string('lto_number')->unique();
            $table->date('lto_expiration');
            $table->text('business_address');
        
            // Admin must verify them before they can access the partnered portal
            $table->boolean('is_verified')->default(false);
        
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacist_profiles');
    }
};
