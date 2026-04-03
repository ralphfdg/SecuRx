<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PharmacistProfile extends Model
{
    use HasUuids;
    
    // This allows the controller to save all the LTO and Pharmacy data at once
    protected $guarded = [];

    /**
     * Inverse Relationship: Links back to the main User account (Email/Password)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
