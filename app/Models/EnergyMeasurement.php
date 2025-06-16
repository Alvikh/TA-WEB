<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnergyMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'voltage',
        'current',
        'power',
        'energy',
        'frequency',
        'power_factor',
        'temperature',
        'humidity',
        'measured_at'
    ];

    protected $casts = [
        'measured_at' => 'datetime',
    ];

    // Relasi dengan device
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}