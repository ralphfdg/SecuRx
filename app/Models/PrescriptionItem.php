<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    use HasUuids;

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
