<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Lead;
use App\Models\Listing;
use App\Models\Project;
use App\Models\PropertyType;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'listings_active' => Listing::active()->count(),
            'listings_total' => Listing::count(),
            'projects_published' => Project::published()->count(),
            'agents_active' => Agent::where('is_active', true)->count(),
            'leads_new' => Lead::where('status', 'new')->count(),
            'leads_total' => Lead::count(),
        ];

        $recentLeads = Lead::latest()->take(5)->get();

        // Leads per month, last 6 months — filled with zero for months with no leads
        // (rather than skipping them) so the chart doesn't look misleadingly sparse.
        // NOTE: DATE_FORMAT() is MySQL-specific — fine here since this project is
        // MySQL-only by design, but would need adjusting if the DB engine ever changes.
        $leadsRaw = Lead::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, COUNT(*) as total")
            ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $leadsPerMonth = collect(range(5, 0))->map(function ($i) use ($leadsRaw) {
            $month = now()->subMonths($i);
            return [
                'label' => $month->translatedFormat('M Y'),
                'total' => $leadsRaw->get($month->format('Y-m'), 0),
            ];
        });

        // Top areas by active listing count.
        $listingsByArea = Area::withCount(['listings' => fn ($q) => $q->active()])
            ->orderByDesc('listings_count')
            ->take(6)
            ->get()
            ->filter(fn ($area) => $area->listings_count > 0)
            ->values();

        // Listing distribution by property type.
        $listingsByType = PropertyType::withCount(['listings' => fn ($q) => $q->active()])
            ->orderByDesc('listings_count')
            ->get()
            ->filter(fn ($type) => $type->listings_count > 0)
            ->values();

        $leadsByStatus = [
            'Baru' => Lead::where('status', 'new')->count(),
            'Dihubungi' => Lead::where('status', 'contacted')->count(),
            'Selesai' => Lead::where('status', 'closed')->count(),
        ];

        return view('admin.dashboard', compact(
            'stats', 'recentLeads', 'leadsPerMonth', 'listingsByArea', 'listingsByType', 'leadsByStatus'
        ));
    }
}
