<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * Public self-registration is only for the "customer" role (buyers who want
 * to save/favorite listings). Admin and Agent accounts are always created
 * by an admin via /admin/agents — see AgentController.
 */
class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);
        $user->assignRole('customer');

        event(new Registered($user));
        $user->sendEmailVerificationNotification();
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Selamat datang di MaxinPro, ' . $user->name . '! Cek email Anda untuk verifikasi akun.');
    }
}
