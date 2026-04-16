<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DpriRecord extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     * (Optional, but good practice if you want to be explicit)
     */
    protected $table = 'dpri_records';

    /**
     * The attributes that are mass assignable.
     * These must perfectly match the columns in your dpri_records table migration.
     */
    protected $fillable = [
        'medication_id',
        'doh_raw_drug_name',
        'lowest_price',
        'median_price',
        'highest_price',
        'effective_year',
    ];

    /**
     * The attributes that should be cast to native types.
     * This ensures your decimal prices remain formatted accurately as floats.
     */
    protected $casts = [
        'lowest_price' => 'float',
        'median_price' => 'float',
        'highest_price' => 'float',
    ];

    /**
     * Establish the relationship to the internal Medications table.
     * A DPRI record may optionally belong to a specific medication in our masterlist.
     */
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
}