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
        Schema::create('dispensing_logs', function (Blueprint $table) {
           $table->uuid('id')->primary();
        
            $table->foreignUuid('prescription_item_id')->constrained('prescription_items')->cascadeOnDelete();
            $table->foreignUuid('pharmacist_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('guest_prc_license')->nullable();
            $table->integer('quantity_dispensed');
        
            // --- THE UPGRADED REPRESENTATIVE LOGIC ---
            // 1. Link to the authorized person (Nullable because the patient might pick it up themselves)
            $table->foreignUuid('representative_id')->nullable()->constrained('authorized_representatives')->nullOnDelete();
        
            // 2. The Immutable Snapshots (Saves the text forever, even if the representative is deleted later)
            $table->string('receiver_name_snapshot')->nullable(); 
            $table->string('receiver_relationship_snapshot')->nullable(); 
            $table->string('receiver_id_presented'); // The physical ID the pharmacist checked (e.g., "Driver's License")
            // -----------------------------------------

            $table->timestamp('dispensed_at')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispensing_logs');
    }
};
