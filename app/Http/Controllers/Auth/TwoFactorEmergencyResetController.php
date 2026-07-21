<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\TwoFactorEmergencyResetNotification;
use App\Notifications\TwoFactorWasDisabledNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TwoFactorEmergencyResetController extends Controller
{
    public function create(): View
    {
        return view('auth.two-factor-emergency-reset');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->string('email'))->first();

        if ($user && $user->hasTwoFactorEnabled()) {
            $user->notify(new TwoFactorEmergencyResetNotification());
        }

        // Same response whether the account exists or not, and whether it even
        // has 2FA enabled — avoids leaking which emails are registered accounts.
        return back()->with('status', 'Jika email tersebut terdaftar dan memiliki 2FA aktif, tautan reset sudah dikirimkan.');
    }

    /**
     * Handles the signed link from the email. Disables 2FA, then immediately
     * notifies the account owner that it happened (see class docblock on the
     * notification for why that confirmation step matters).
     */
    public function confirm(Request $request, int $id): RedirectResponse
    {
        abort_unless($request->hasValidSignature(), 403, 'Tautan reset tidak valid atau sudah kedaluwarsa.');

        $user = User::findOrFail($id);

        abort_unless(hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash')), 403);

        if (! $user->hasTwoFactorEnabled()) {
            return redirect()->route('login')->with('status', '2FA pada akun ini sudah tidak aktif.');
        }

        $user->disableTwoFactor();
        $user->notify(new TwoFactorWasDisabledNotification());

        return redirect()->route('login')
            ->with('status', 'Verifikasi dua langkah berhasil dinonaktifkan. Silakan masuk dengan email dan kata sandi Anda, lalu aktifkan kembali 2FA sesegera mungkin.');
    }
}
