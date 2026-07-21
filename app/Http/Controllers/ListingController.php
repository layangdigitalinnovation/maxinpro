<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:150'],
            'type' => ['nullable', 'array'],
            'type.*' => ['integer', 'exists:property_types,id'],
            'bedrooms' => ['nullable', 'integer', 'min:1', 'max:10'],
            'price_min' => ['nullable', 'integer', 'min:0'],
            'price_max' => ['nullable', 'integer', 'min:0'],
            'price_range' => ['nullable', 'string'],
            'sort' => ['nullable', 'in:terbaru,harga_asc,harga_desc'],
        ]);

        $query = Listing::query()->with(['area', 'propertyType'])->active();

        if (!empty($validated['q'])) {
            $keyword = $validated['q'];
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('address', 'like', "%{$keyword}%")
                    ->orWhereHas('area', fn ($a) => $a->where('name', 'like', "%{$keyword}%"));
            });
        }

        if (!empty($validated['type'])) {
            $query->whereIn('property_type_id', $validated['type']);
        }

        if (!empty($validated['bedrooms'])) {
            $query->where('bedrooms', '>=', $validated['bedrooms']);
        }

        if (!empty($validated['price_min'])) {
            $query->where('price', '>=', $validated['price_min']);
        }

        if (!empty($validated['price_max'])) {
            $query->where('price', '<=', $validated['price_max']);
        }

        if (!empty($validated['price_range'])) {
            $rangeParts = explode('-', $validated['price_range']);
            if (count($rangeParts) === 2) {
                if ($rangeParts[0] !== '') {
                    $query->where('price', '>=', (int) $rangeParts[0]);
                }
                if ($rangeParts[1] !== '') {
                    $query->where('price', '<=', (int) $rangeParts[1]);
                }
            }
        }

        match ($validated['sort'] ?? 'terbaru') {
            'harga_asc' => $query->orderBy('price', 'asc'),
            'harga_desc' => $query->orderBy('price', 'desc'),
            default => $query->latest('published_at'),
        };

        $listings = $query->paginate(9)->withQueryString();
        $propertyTypes = PropertyType::all();
        $savedIds = auth()->check() ? auth()->user()->savedListings()->pluck('listing_id')->all() : [];

        return view('listings.index', compact('listings', 'propertyTypes', 'savedIds'));
    }

    public function show(Listing $listing)
    {
        abort_unless($listing->status === 'active', 404);

        $listing->load(['area', 'propertyType', 'agent', 'images']);

        $related = Listing::query()
            ->with('area')
            ->active()
            ->where('area_id', $listing->area_id)
            ->where('id', '!=', $listing->id)
            ->take(3)
            ->get();

        $isSaved = auth()->check() && auth()->user()->savedListings()->where('listing_id', $listing->id)->exists();
        $savedIds = auth()->check() ? auth()->user()->savedListings()->pluck('listing_id')->all() : [];

        return view('listings.show', compact('listing', 'related', 'isSaved', 'savedIds'));
    }
}
