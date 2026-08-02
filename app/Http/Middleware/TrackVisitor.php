<?php

namespace App\Http\Middleware;

use App\Models\BlockedIp;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // Skip tracking for admin routes
        if ($request->is('admin/*') || $request->is('admin')) {
            return $next($request);
        }

        $ip = $request->ip();

        // Check if this IP is blocked — abort with 403
        if (BlockedIp::isBlocked($ip)) {
            abort(403, 'Your access to this website has been blocked. Please contact the administrator.');
        }

        // Record visit — one per IP per day (unique index prevents duplicates)
        try {
            Visitor::firstOrCreate(
                [
                    'ip_address'  => $ip,
                    'visited_at'  => today()->toDateString(),
                ],
                [
                    'user_agent'  => $request->userAgent(),
                ]
            );
        } catch (\Exception $e) {
            // Silently ignore duplicate key errors or DB issues
        }

        return $next($request);
    }
}
