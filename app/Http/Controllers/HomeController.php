<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Article;
use App\Models\Listing;
use App\Models\Project;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->with(['area', 'developer', 'propertyType'])
            ->published()
            ->orderByPriority()
            ->take(10)
            ->get();

        $listings = Listing::query()
            ->with(['area'])
            ->active()
            ->orderByPriority()
            ->take(6)
            ->get();

        $popularAreas = Area::query()
            ->where('is_popular', true)
            ->take(5)
            ->get();

        $articles = Article::query()
            ->published()
            ->latest('published_at')
            ->take(4)
            ->get();

        $testimonials = Testimonial::query()
            ->active()
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'properti_aktif' => Listing::active()->count(),
            'agen' => \App\Models\Agent::where('is_active', true)->count(),
            'project_baru' => Project::published()->count(),
        ];

        $savedIds = auth()->check() ? auth()->user()->savedListings()->pluck('listing_id')->all() : [];

        $propertyTypes = \App\Models\PropertyType::all();

        return view('home', compact('projects', 'listings', 'popularAreas', 'articles', 'testimonials', 'stats', 'savedIds', 'propertyTypes'));
    }
}
