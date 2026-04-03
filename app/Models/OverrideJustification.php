<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OverrideJustification extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function dispensingLog()
    {
        return $this->belongsTo(DispensingLog::class);
    }
}
