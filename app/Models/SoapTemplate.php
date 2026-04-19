<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoapTemplate extends Model
{
    use HasUuids, SoftDeletes;
    protected $guarded = [];

    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
}