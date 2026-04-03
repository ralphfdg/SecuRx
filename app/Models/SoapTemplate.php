<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SoapTemplate extends Model
{
    use HasUuids;
    protected $guarded = [];

    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
}