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
        Schema::table('prescription_items', function (Blueprint $table) {
            
            $table->integer('quantity_remaining')
                  ->after('quantity')
                  ->nullable()
                  ->comment('For Tingi: Tracks the balance. If null, assumes full quantity is remaining.');
                  
            $table->enum('status', ['active', 'partially_dispensed', 'completed', 'cancelled'])
                  ->after('quantity_remaining')
                  ->default('active')
                  ->comment('Item-level tracking for partial dispensing workflow');
                  
        });
        
        // Optional but recommended: Backfill existing data so old records don't break
        DB::statement('UPDATE prescription_items SET quantity_remaining = quantity WHERE quantity_remaining IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription_items', function (Blueprint $table) {
            $table->dropColumn(['quantity_remaining', 'status']);
        });
    }
};