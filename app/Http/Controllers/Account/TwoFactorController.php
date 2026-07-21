<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TwoFactorController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();

        if (! $user->hasTwoFactorEnabled() && ! $user->two_factor_secret) {
            $user->generateTwoFactorSecret();
            $user->refresh();
        }

        return view('account.two-factor', ['user' => $user]);
    }

    public function enable(Request $request): RedirectResponse
    {
        $request->validate(['code' => ['required', 'string']]);

        $user = $request->user();

        if (! $user->confirmTwoFactor($request->string('code'))) {
            return back()->withErrors(['code' => 'Kode tidak valid. Pastikan waktu di HP Anda sudah sinkron dan coba lagi.']);
        }

        return redirect()->route('account.two-factor.show')
            ->with('success', 'Verifikasi dua langkah berhasil diaktifkan.')
            ->with('recovery_codes', $user->fresh()->two_factor_recovery_codes);
    }

    public function disable(Request $request): RedirectResponse
    {
        $request->validate(['current_password' => ['required', 'current_password']]);

        $request->user()->disableTwoFactor();

        return redirect()->route('account.two-factor.show')->with('success', 'Verifikasi dua langkah dinonaktifkan.');
    }

    public function regenerateSecret(Request $request): RedirectResponse
    {
        $request->validate(['current_password' => ['required', 'current_password']]);

        $request->user()->generateTwoFactorSecret();

        return redirect()->route('account.two-factor.show')->with('success', 'Kode QR baru berhasil dibuat — scan ulang dan konfirmasi lagi untuk mengaktifkan.');
    }
}
