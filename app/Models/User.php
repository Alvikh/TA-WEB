<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
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
        'current_team_id',
        'verification_code',
        'verification_code_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
    'email_verified_at' => 'datetime',
    'last_login_at' => 'datetime',
    'verification_code_expires_at' => 'datetime',
];

public function hasVerifiedEmail()
{
    return !is_null($this->email_verified_at);
}

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