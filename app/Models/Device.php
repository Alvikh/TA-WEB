<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
protected $primaryKey = 'id'; 
    protected $table = 'devices';

    protected $fillable = [
        'name',
        'device_id',
        'type',
        'building',
        'installation_date',
        'status',
    ];

    protected $casts = [
        'installation_date' => 'date',
    ];

    // Relasi dengan energy measurements
    public function energyMeasurements()
    {
        return $this->hasMany(EnergyMeasurement::class);
    }

    // Relasi dengan alerts
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}