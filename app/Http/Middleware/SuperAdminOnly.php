<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminOnly
{
    const SUPER_EMAIL = 'info@htdc.edu.bd';

    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || $request->user()->email !== self::SUPER_EMAIL) {
            abort(403, 'Only Super Admin can access this page.');
        }

        return $next($request);
    }
}
