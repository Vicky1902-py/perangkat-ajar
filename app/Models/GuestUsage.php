<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'session_id',
        'device_count',
        'last_generated_at',
    ];

    protected function casts(): array
    {
        return [
            'device_count' => 'integer',
            'last_generated_at' => 'datetime',
        ];
    }
}
