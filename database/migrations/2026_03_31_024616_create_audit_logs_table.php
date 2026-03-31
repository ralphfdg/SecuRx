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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
        
            // Nullable because a guest scanning a QR code might not be logged in
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
        
            $table->string('action_type')->index(); // e.g., 'QR_GENERATED', 'SCAN_ATTEMPT'
            $table->text('description');
            $table->string('ip_address', 45)->nullable();
        
            $table->timestamp('created_at'); // Immutable timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
