<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Locale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', config('app.locale'));

        if (!in_array($locale, ['en', 'bn'])) {
            $locale = config('app.locale');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
