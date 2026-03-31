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
        Schema::create('medications', function (Blueprint $table) {
            $table->id(); // Standard auto-increment is fine for public medication data
            $table->string('rxcui', 50)->nullable()->index(); // NIH API ID
            $table->string('generic_name')->index();
            $table->string('brand_name')->nullable();
            $table->string('form');
            $table->string('dosage_strength');
            $table->decimal('estimated_price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
