<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Listing;
use App\Models\Project;

class AboutController extends Controller
{
    public function index()
    {
        $stats = [
            'properti_aktif' => Listing::active()->count(),
            'agen_profesional' => Agent::where('is_active', true)->count(),
            'project_baru' => Project::published()->count(),
        ];

        return view('about.index', compact('stats'));
    }
}
