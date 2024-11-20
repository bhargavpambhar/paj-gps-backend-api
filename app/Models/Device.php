<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'devices';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'model', 'device_unique_id', 'type', 'status', 
        'battery_percentage', 'latitude', 'longitude', 'location_history'
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'location_history' => 'array', // Casting JSON to array
        'battery_percentage' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * Get the access records associated with the device.
     */
    public function access()
    {
        return $this->hasMany(Access::class);
    }
}
