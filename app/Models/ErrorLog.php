<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'exception',
        'code',
        'file',
        'line',
        'trace',
        'url',
        'method',
        'input',
        'ip_address',
        'user_id'
    ];

    protected $casts = [
        'input' => 'array',
        'trace' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}