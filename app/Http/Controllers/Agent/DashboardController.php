<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $agent = $request->user()->agentProfile;

        abort_unless($agent, 403, 'Akun Anda belum terhubung ke profil agen. Hubungi admin.');

        $stats = [
            'listings_active' => $agent->listings()->where('status', 'active')->count(),
            'listings_total' => $agent->listings()->count(),
            'listings_sold' => $agent->listings()->where('status', 'sold')->count(),
        ];

        return view('agent.dashboard', compact('stats', 'agent'));
    }
}
