<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'access';

    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id', 'device_id', 'access_level', 'granted_at', 'expires_at'
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'granted_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the access.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the device that the user has access to.
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
