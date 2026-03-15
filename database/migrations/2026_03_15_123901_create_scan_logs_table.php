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
        Schema::create('scan_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('prescription_id')->constrained()->onDelete('cascade');
            $table->foreignUuId('pharmacist_id')->constrained('users');

            $table->timestamp('scanned_at')->useCurrent();
            $table->boolean('was_dispensed')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_logs');
    }
};
