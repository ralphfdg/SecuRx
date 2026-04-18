<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalDocument extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
