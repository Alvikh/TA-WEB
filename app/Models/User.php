<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'status',
        'last_login_at',
        'profile_photo_path',
        'current_team_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
    'email_verified_at' => 'datetime',
    'last_login_at' => 'datetime',
];

    // Relasi many-to-many dengan buildings
    // public function buildings()
    // {
    //     return $this->belongsToMany(Building::class);
    // }

    // Helper methods untuk check role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
    public function devices(): HasMany
{
    return $this->hasMany(Device::class, 'owner_id');
}
public function refreshTokens()
    {
        return $this->hasMany(RefreshToken::class);
    }

}