<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    use HasUuids;

    protected $fillable = [
        'prescription_id',
        'medication_id',
        'is_maintenance', // Added here
        'dose',
        'frequency',
        'duration',
        'pharmacist_instructions',
        'patient_instructions',
        'sig',
        'quantity',
        'max_refills',
    ];

    protected $casts = [
        'is_maintenance' => 'boolean', // Ensures it stays true/false
        'quantity' => 'integer',
        'max_refills' => 'integer',
    ];

    protected $guarded = [];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_id');
    }

    public function dispensingLogs()
    {
        return $this->hasMany(DispensingLog::class, 'prescription_item_id');
    }
}
