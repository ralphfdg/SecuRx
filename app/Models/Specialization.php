<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    //
    protected $guarded = [];

    public function doctors()
    {
        return $this->belongsToMany(
            User::class, 
            'doctor_specialization', // The name of your pivot table
            'specialization_id',     // The foreign key for this model
            'doctor_id'              // The foreign key for the related model
        );
    }
}
