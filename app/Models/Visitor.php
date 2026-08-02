<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['ip_address', 'user_agent', 'visited_at'];

    protected $casts = [
        'visited_at' => 'date',
    ];

    /**
     * Total all-time visitor count
     */
    public static function totalCount(): int
    {
        return static::count();
    }

    /**
     * Today's visitor count
     */
    public static function todayCount(): int
    {
        return static::whereDate('visited_at', today())->count();
    }

    /**
     * Scope for today's visitors
     */
    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', today());
    }

    /**
     * Get daily stats grouped by date (last N days)
     */
    public static function dailyStats(int $days = 30)
    {
        return static::selectRaw('visited_at, COUNT(*) as count')
            ->where('visited_at', '>=', now()->subDays($days)->toDateString())
            ->groupBy('visited_at')
            ->orderBy('visited_at', 'desc')
            ->get();
    }
}
