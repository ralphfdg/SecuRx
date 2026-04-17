<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialization extends Model
{

    use SoftDeletes;
    // Notice NO HasUuids trait here!
    protected $guarded = [];

    public function doctors()
    {
        return $this->belongsToMany(User::class, 'doctor_specialization', 'specialization_id', 'doctor_id');
    }
}
