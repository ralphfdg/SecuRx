<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class DispensingLog extends Model
{
    use HasUuids;

    protected $guarded = [];

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
