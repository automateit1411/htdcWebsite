<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SuperAdminAuthController extends Controller
{
    const SUPER_EMAIL = 'info@htdc.edu.bd';
    const SUPER_PASSWORD = 'htdc@237';

    public function showLogin()
    {
        return view('admin.auth.super-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($request->email !== self::SUPER_EMAIL || $request->password !== self::SUPER_PASSWORD) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->onlyInput('email');
        }

        $otp = rand(100000, 999999);

        Otp::updateOrCreate(
            ['email' => self::SUPER_EMAIL, 'is_used' => false],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(5),
                'is_used' => false,
            ]
        );

        Mail::raw("Your OTP for HTDC Admin Login is: {$otp}\nThis OTP will expire in 5 minutes.", function ($message) {
            $message->to(self::SUPER_EMAIL)
                    ->subject('HTDC Admin Login OTP');
        });

        $request->session()->put('super_admin_email', self::SUPER_EMAIL);

        return redirect()->route('super-admin.otp');
    }

    public function showOtp()
    {
        if (!session('super_admin_email')) {
            return redirect()->route('super-admin.login');
        }

        return view('admin.auth.super-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $email = session('super_admin_email');
        $inputOtp = $request->otp;

        \Log::info("OTP Verification Attempt", [
            'email' => $email,
            'input_otp' => $inputOtp,
            'session_email' => session('super_admin_email'),
        ]);

        if (!$email) {
            return redirect()->route('super-admin.login')->with('error', __('admin.session_expired'));
        }

        try {
            $otpRecord = Otp::where('email', $email)
                ->where('otp', $inputOtp)
                ->where('is_used', false)
                ->where('expires_at', '>', now())
                ->first();

            \Log::info("OTP Record Found", [
                'found' => !!$otpRecord,
                'otp_record' => $otpRecord ? $otpRecord->toArray() : null,
            ]);

            if (!$otpRecord) {
                return back()->withErrors([
                    'otp' => 'Invalid or expired OTP. Please try again.',
                ])->onlyInput('otp');
            }

            $otpRecord->update(['is_used' => true]);

            $user = User::where('email', self::SUPER_EMAIL)->first();

            if (!$user) {
                $user = User::create([
                    'name' => 'Super Admin',
                    'email' => self::SUPER_EMAIL,
                    'password' => Hash::make(self::SUPER_PASSWORD),
                    'role' => User::ROLE_ADMIN,
                    'mobile' => 0,
                ]);
            }

            $loginToken = Str::uuid()->toString();
            $user->update(['login_token' => $loginToken]);

            Auth::login($user);
            $request->session()->regenerate();

            $request->session()->put('login_token', $loginToken);
            $request->session()->forget('super_admin_email');

            return redirect()->route('admin.dashboard');
        } catch (\Exception $e) {
            \Log::error('OTP Verification Error: ' . $e->getMessage());
            return back()->withErrors([
                'otp' => 'Something went wrong: ' . $e->getMessage(),
            ])->onlyInput('otp');
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->update(['login_token' => null]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('super-admin.login');
    }
}
