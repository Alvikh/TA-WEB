<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'devices';

    protected $fillable = [
        'owner_id',
        'name',
        'device_id',
        'type',
        'building',
        'installation_date',
        'status',
    ];

    protected $casts = [
        'installation_date' => 'datetime',
    ];

    // Relasi ke User (pemilik device)
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // Relasi dengan energy measurements
    public function energyMeasurements(): HasMany
    {
        return $this->hasMany(EnergyMeasurement::class);
    }

    // Relasi dengan alerts
    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class);
    }
}