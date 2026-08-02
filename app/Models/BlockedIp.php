<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedIp extends Model
{
    protected $fillable = ['ip_address', 'reason'];

    /**
     * Check if an IP is blocked
     */
    public static function isBlocked(string $ip): bool
    {
        return static::where('ip_address', $ip)->exists();
    }
}
