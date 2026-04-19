<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthorizedRepresentative extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'patient_id',
        'full_name',
        'relationship',
        'is_active',
    ];

    // Add this to convert tinyint to true/false automatically!
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
