<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    // Define the table name explicitly
    protected $table = 'refresh_tokens';

    // Define the fillable properties
    protected $fillable = [
        'user_id', 
        'refresh_token'
    ];

    /**
     * Get the user that owns the refresh token.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
