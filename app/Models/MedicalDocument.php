<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MedicalDocument extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
