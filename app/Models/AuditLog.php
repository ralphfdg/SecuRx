<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AuditLog extends Model
{
    use HasUuids;
    
    protected $guarded = [];

    // Tell Laravel not to expect or update an 'updated_at' column
    const UPDATED_AT = null;

    public function user() 
    { 
        return $this->belongsTo(User::class, 'user_id'); 
    } 
}