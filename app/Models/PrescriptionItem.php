<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PrescriptionItem extends Model
{
    use HasUuids;

    protected $guarded = [];

    // Links back to the parent QR code
    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }

    // Links to the public DOH/NIH drug database
    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_id');
    }

    // Links to the logs of every time a pharmacist gave out this specific drug
    public function dispensingLogs()
    {
        return $this->hasMany(DispensingLog::class, 'prescription_item_id');
    }
}
