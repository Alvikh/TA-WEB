<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'type',
        'message',
        'severity',
        'is_resolved',
        'resolved_at'
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    // Relasi dengan device
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    // Scope untuk alert yang belum terselesaikan
    public function scopeUnresolved($query)
    {
        return $query->where('is_resolved', false);
    }
}