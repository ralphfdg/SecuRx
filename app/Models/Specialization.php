<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    // Notice NO HasUuids trait here!
    protected $guarded = [];

    public function doctors()
    {
        return $this->belongsToMany(User::class, 'doctor_specialization', 'specialization_id', 'doctor_id');
    }
}
