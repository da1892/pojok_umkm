<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VisitorLog extends Model
{
    use HasFactory;

    protected $table = 'visitor_logs';

    protected $fillable = [
        'ip_address',
        'session_id',
        'url',
        'route_name',
        'page_name',
        'device',
        'platform',
        'browser',
        'user_agent',
        'referer',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', Carbon::today());
    }

    public function scopeYesterday($query)
    {
        return $query->whereDate('visited_at', Carbon::yesterday());
    }

    public function scopeLastDays($query, int $days = 7)
    {
        return $query->where('visited_at', '>=', Carbon::now()->subDays($days)->startOfDay());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('visited_at', Carbon::now()->month)
                     ->whereYear('visited_at', Carbon::now()->year);
    }
}
