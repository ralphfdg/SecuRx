<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class LabResult extends Model 
{
    use HasUuids;
    protected $guarded = [];

    public function patient() { return $this->belongsTo(User::class, 'patient_id'); }
}
