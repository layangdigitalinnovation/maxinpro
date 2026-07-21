<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\SavedListing;
use Illuminate\Http\Request;

class SavedListingController extends Controller
{
    /**
     * Query Listings directly (joined through saved_listings) instead of mapping
     * SavedListing -> listing. Listings are soft-deletable, and a soft delete does
     * NOT fire the saved_listings foreign-key cascade (that only runs on a hard
     * delete), so the naive approach yields null listings and crashes the view.
     * Hidden listings are excluded too — they are not meant to be publicly visible.
     */
    public function index(Request $request)
    {
        $listings = Listing::query()
            ->with(['area', 'propertyType'])
            ->join('saved_listings', 'saved_listings.listing_id', '=', 'listings.id')
            ->where('saved_listings.user_id', $request->user()->id)
            ->whereIn('listings.status', ['active', 'sold'])
            ->orderByDesc('saved_listings.created_at')
            ->select('listings.*')
            ->paginate(12);

        return view('account.saved-listings', compact('listings'));
    }

    /**
     * Toggle save/unsave for the given listing, scoped to the current user only.
     */
    public function toggle(Request $request, Listing $listing)
    {
        $user = $request->user();

        $existing = SavedListing::where('user_id', $user->id)->where('listing_id', $listing->id)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Dihapus dari daftar favorit.';
        } else {
            SavedListing::create(['user_id' => $user->id, 'listing_id' => $listing->id]);
            $message = 'Ditambahkan ke daftar favorit.';
        }

        return back()->with('success', $message);
    }
}
