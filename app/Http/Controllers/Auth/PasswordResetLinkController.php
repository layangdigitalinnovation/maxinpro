<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        // Always respond the same way whether the email exists or not,
        // so this endpoint can't be used to enumerate registered accounts.
        Password::sendResetLink($request->only('email'));

        return back()->with('status', 'Jika email terdaftar, kami sudah mengirimkan tautan reset kata sandi.');
    }
}
