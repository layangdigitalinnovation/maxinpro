<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AgentController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $agents = Agent::query()->when($request->filled('q'), fn($q) => $q->where('name', 'like', '%' . $request->string('q') . '%'))->with('user')->withCount('listings')->latest()->paginate(15)->withQueryString();

        return view('admin.agents.index', compact('agents'));
    }

    public function create()
    {
        return view('admin.agents.form', ['agent' => new Agent()]);
    }

    /**
     * Creates both the login account (User, role=agent) and the Agent profile
     * in one transaction, then returns a one-time generated password to the
     * admin so it can be shared with the agent out-of-band.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
        ]);

        $temporaryPassword = Str::password(12);

        DB::transaction(function () use ($data, $temporaryPassword) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $temporaryPassword, // hashed automatically via the User model cast
                'role' => 'agent',
                'email_verified_at' => now(), // admin-created & trusted — never goes through the verification email flow
            ]);

            Agent::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'whatsapp' => $data['whatsapp'] ?? null,
                'is_active' => true,
            ]);
        });

        return redirect()->route('admin.agents.index')
            ->with('success', "Agen berhasil dibuat. Kata sandi sementara: {$temporaryPassword} — segera bagikan secara aman dan minta agen menggantinya.");
    }

    public function edit(Agent $agent)
    {
        return view('admin.agents.form', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $agent->update($data);

        if ($agent->user) {
            $agent->user->update(['name' => $data['name']]);
        }

        return redirect()->route('admin.agents.index')->with('success', 'Data agen berhasil diperbarui.');
    }

    public function destroy(Agent $agent)
    {
        // Deactivate rather than hard-delete so their past listings keep a valid owner reference.
        $agent->update(['is_active' => false]);

        return redirect()->route('admin.agents.index')->with('success', 'Agen berhasil dinonaktifkan.');
    }
}
