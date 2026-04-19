<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DispensingLog extends Model
{
    use HasUuids;

    // 1. Tell Laravel NOT to automatically manage created_at / updated_at
    public $timestamps = false;

    // 2. Ensure your primary key type is set correctly since you are using UUIDs (char(36))
    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $fillable = [
        'id', 'prescription_item_id', 'pharmacist_id', 'guest_prc_license',
        'guest_pharmacy_name', 'guest_pharmacy_address', 'quantity_dispensed',
        'actual_drug_dispensed', 'lot_number', 'expiry_date',

        // Ensure these snapshot columns are fillable!
        'representative_id', 'receiver_name_snapshot',
        'receiver_relationship_snapshot', 'receiver_id_presented', 'dispensed_at',
    ];

    protected $casts = [
        'dispensed_at' => 'datetime',
        'expiry_date' => 'date',
    ];

    public function prescriptionItem()
    {
        return $this->belongsTo(PrescriptionItem::class, 'prescription_item_id');
    }

    public function pharmacist()
    {
        return $this->belongsTo(User::class, 'pharmacist_id');
    }

    public function representative()
    {
        return $this->belongsTo(AuthorizedRepresentative::class, 'representative_id');
    }

    public function overrideJustification()
    {
        return $this->hasOne(OverrideJustification::class, 'dispensing_log_id');
    }
}
