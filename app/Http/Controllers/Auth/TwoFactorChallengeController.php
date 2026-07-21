<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Second step of login for accounts with 2FA enabled. The user's identity is
 * already confirmed by this point (password checked in AuthenticatedSessionController),
 * but the session is NOT authenticated yet — only session('login.id') is set,
 * which this controller alone can turn into a real logged-in session.
 */
class TwoFactorChallengeController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['code' => ['required', 'string']]);

        $userId = $request->session()->get('login.id');
        abort_unless($userId, 419);

        $throttleKey = 'two-factor:' . $userId;
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages(['code' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."]);
        }

        $user = User::findOrFail($userId);
        $code = trim($request->string('code'));

        $valid = $user->verifyTwoFactorCode($code) || $user->useRecoveryCode($code);

        if (! $valid) {
            RateLimiter::hit($throttleKey);
            throw ValidationException::withMessages(['code' => 'Kode verifikasi tidak valid.']);
        }

        RateLimiter::clear($throttleKey);
        $request->session()->forget('login.id');
        Auth::login($user, $request->session()->get('login.remember', false));
        $request->session()->regenerate();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'agent' => redirect()->route('agent.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
