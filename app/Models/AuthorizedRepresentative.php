<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AuthorizedRepresentative extends Model
{
    use HasUuids;

    // Allows mass assignment for quick form submissions in the Patient Portal
    protected $guarded = [];

    /**
     * Inverse Relationship: Links back to the Patient (User) who added this person.
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}   
