<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SingleSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionToken = session('login_token');

            \Log::info("SingleSession Check", [
                'user_id' => $user->id,
                'user_login_token' => $user->login_token,
                'session_login_token' => $sessionToken,
                'match' => $user->login_token === $sessionToken,
            ]);

            if ($user->login_token !== $sessionToken) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')
                    ->with('error', 'You have been logged out because your account was logged in from another device.');
            }
        }

        return $next($request);
    }
}
