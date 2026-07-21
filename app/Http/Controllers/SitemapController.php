<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Article;
use App\Models\Listing;
use App\Models\Project;
use App\Models\PropertyType;
use Illuminate\Http\Response;

/**
 * Generates sitemap.xml dynamically so newly published listings, projects, and
 * articles are discoverable by search engines without a manual rebuild.
 * The result is cached briefly to keep crawler traffic cheap.
 */
class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [];

        // Static pages, ordered by importance.
        $staticPages = [
            ['loc' => route('home'), 'priority' => '1.0', 'freq' => 'daily'],
            ['loc' => route('listings.index'), 'priority' => '0.9', 'freq' => 'daily'],
            ['loc' => route('projects.index'), 'priority' => '0.9', 'freq' => 'weekly'],
            ['loc' => route('titip-properti.create'), 'priority' => '0.8', 'freq' => 'monthly'],
            ['loc' => route('kpr.index'), 'priority' => '0.8', 'freq' => 'monthly'],
            ['loc' => route('articles.index'), 'priority' => '0.7', 'freq' => 'weekly'],
            ['loc' => route('about.index'), 'priority' => '0.5', 'freq' => 'yearly'],
        ];

        foreach ($staticPages as $page) {
            $urls[] = [
                'loc' => $page['loc'],
                'lastmod' => now()->toAtomString(),
                'changefreq' => $page['freq'],
                'priority' => $page['priority'],
            ];
        }

        Listing::active()->select('slug', 'updated_at')->latest('updated_at')->chunk(500, function ($listings) use (&$urls) {
            foreach ($listings as $listing) {
                $urls[] = [
                    'loc' => route('listings.show', $listing->slug),
                    'lastmod' => $listing->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
            }
        });

        Project::published()->select('slug', 'updated_at')->latest('updated_at')->chunk(500, function ($projects) use (&$urls) {
            foreach ($projects as $project) {
                $urls[] = [
                    'loc' => route('projects.show', $project->slug),
                    'lastmod' => $project->updated_at->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }
        });

        Article::published()->select('slug', 'updated_at')->latest('updated_at')->chunk(500, function ($articles) use (&$urls) {
            foreach ($articles as $article) {
                $urls[] = [
                    'loc' => route('articles.show', $article->slug),
                    'lastmod' => $article->updated_at->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ];
            }
        });

        // SEO landing pages per area, and per area+type combo (only where at
        // least one active listing exists — an empty landing page has no
        // value to rank and would just dilute crawl budget).
        $propertyTypes = PropertyType::all();
        Area::whereHas('listings', fn ($q) => $q->active())->chunk(200, function ($areas) use (&$urls, $propertyTypes) {
            foreach ($areas as $area) {
                $urls[] = [
                    'loc' => route('area-landing.show', $area->slug),
                    'lastmod' => now()->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
                foreach ($propertyTypes as $type) {
                    if ($area->listings()->active()->where('property_type_id', $type->id)->exists()) {
                        $urls[] = [
                            'loc' => route('area-landing.show-type', [$area->slug, $type->slug]),
                            'lastmod' => now()->toAtomString(),
                            'changefreq' => 'weekly',
                            'priority' => '0.6',
                        ];
                    }
                }
            }
        });

        return response()
            ->view('sitemap.index', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
