<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('account.password');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'current_password.current_password' => 'Kata sandi saat ini tidak cocok.',
        ]);

        $request->user()->update(['password' => $validated['password']]);

        return back()->with('success', 'Kata sandi berhasil diganti.');
    }
}
