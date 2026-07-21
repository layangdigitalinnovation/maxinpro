<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Listing;
use App\Models\PropertyType;

/**
 * Dedicated, content-rich landing pages per area (and optionally per area+type)
 * so search queries like "rumah dijual bsd city" have a real page to rank,
 * instead of relying on filtered/query-string listing URLs (which robots.txt
 * intentionally excludes — see Fase 3 SEO notes).
 */
class AreaLandingController extends Controller
{
    public function show(Area $area)
    {
        $propertyTypes = PropertyType::orderBy('name')->get();

        $listings = Listing::query()
            ->with(['propertyType'])
            ->active()
            ->where('area_id', $area->id)
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('area.show', [
            'area' => $area,
            'propertyType' => null,
            'propertyTypes' => $propertyTypes,
            'listings' => $listings,
            'savedIds' => auth()->check() ? auth()->user()->savedListings()->pluck('listing_id')->all() : [],
        ]);
    }

    public function showType(Area $area, PropertyType $propertyType)
    {
        $propertyTypes = PropertyType::orderBy('name')->get();

        $listings = Listing::query()
            ->where('area_id', $area->id)
            ->where('property_type_id', $propertyType->id)
            ->active()
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('area.show', [
            'area' => $area,
            'propertyType' => $propertyType,
            'propertyTypes' => $propertyTypes,
            'listings' => $listings,
            'savedIds' => auth()->check() ? auth()->user()->savedListings()->pluck('listing_id')->all() : [],
        ]);
    }
}
