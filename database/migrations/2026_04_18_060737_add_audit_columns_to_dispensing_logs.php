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
        Schema::table('dispensing_logs', function (Blueprint $table) {
            $table->string('actual_drug_dispensed')
                  ->after('quantity_dispensed')
                  ->nullable()
                  ->comment('Exact brand or generic name physically handed to the patient');
                  
            $table->string('lot_number')
                  ->after('actual_drug_dispensed')
                  ->nullable()
                  ->comment('Manufacturer batch/lot number for recall tracing');
                  
            $table->date('expiry_date')
                  ->after('lot_number')
                  ->nullable()
                  ->comment('Expiration date of the dispensed medication');
                  
            $table->string('guest_pharmacy_name')
                  ->after('guest_prc_license')
                  ->nullable()
                  ->comment('Name of the pharmacy where the guest pharmacist is dispensing');
                  
            $table->text('guest_pharmacy_address')
                  ->after('guest_pharmacy_name')
                  ->nullable()
                  ->comment('Address of the pharmacy where the guest pharmacist is dispensing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dispensing_logs', function (Blueprint $table) {
            $table->dropColumn([
                'actual_drug_dispensed', 
                'lot_number', 
                'expiry_date',
                'guest_pharmacy_name',
                'guest_pharmacy_address'
            ]);
        });
    }
};