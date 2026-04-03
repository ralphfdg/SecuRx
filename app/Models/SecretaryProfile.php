<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SecretaryProfile extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }
}
