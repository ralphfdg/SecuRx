<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class PharmacistProfile extends Model
{
    use HasUuids, SoftDeletes;
    protected $guarded = [];

    protected $casts = [
        'is_verified' => 'boolean',
        'lto_expiration' => 'date',
    ];

    public function user() { return $this->belongsTo(User::class, 'user_id'); }
}
