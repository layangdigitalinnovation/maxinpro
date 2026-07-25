<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Area;
use App\Models\Listing;
use App\Models\PropertyType;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $listings = Listing::query()
            ->with(['area', 'propertyType', 'agent'])
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%' . $request->string('q') . '%'))
            ->orderByPriority()
            ->paginate(15)
            ->withQueryString();

        return view('admin.listings.index', compact('listings'));
    }

    public function updateOrderAjax(Request $request, Listing $listing)
    {
        $validated = $request->validate([
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $listing->update(['sort_order' => $validated['sort_order']]);

        return response()->json(['status' => 'success', 'message' => 'Urutan berhasil diperbarui']);
    }

    public function updatePublishAjax(Request $request, Listing $listing)
    {
        $validated = $request->validate([
            'is_published' => ['required', 'boolean'],
        ]);

        $listing->update(['is_published' => $validated['is_published']]);

        return response()->json(['status' => 'success', 'message' => 'Status tayang berhasil diperbarui']);
    }

    public function create()
    {
        return view('admin.listings.form', [
            'listing' => new Listing(),
            'areas' => Area::orderBy('name')->get(),
            'propertyTypes' => PropertyType::orderBy('name')->get(),
            'agents' => Agent::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, ImageUploadService $images)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $images->store($request->file('cover_image'), 'listings');
        }

        $listing = Listing::create($data);

        $this->storeGalleryImages($request, $listing, $images);

        return redirect()->route('admin.listings.index')->with('success', 'Listing berhasil ditambahkan.');
    }

    public function edit(Listing $listing)
    {
        return view('admin.listings.form', [
            'listing' => $listing,
            'areas' => Area::orderBy('name')->get(),
            'propertyTypes' => PropertyType::orderBy('name')->get(),
            'agents' => Agent::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Listing $listing, ImageUploadService $images)
    {
        $data = $this->validated($request, $listing);

        if ($data['title'] !== $listing->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $listing->id);
        }

        if ($request->hasFile('cover_image')) {
            $images->delete($listing->cover_image);
            $data['cover_image'] = $images->store($request->file('cover_image'), 'listings');
        }

        $listing->update($data);

        $this->deleteGalleryImages($request, $listing, $images);
        $this->storeGalleryImages($request, $listing, $images);

        return redirect()->route('admin.listings.index')->with('success', 'Listing berhasil diperbarui.');
    }

    /**
     * Listing uses SoftDeletes, so the record stays recoverable. We deliberately
     * keep the cover image file on disk — deleting it here would make a restored
     * listing permanently image-less. Purging files belongs in a separate
     * "permanently delete" flow, not here.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect()->route('admin.listings.index')->with('success', 'Listing berhasil dihapus.');
    }

    public function trashed(Request $request)
    {
        $listings = Listing::onlyTrashed()
            ->with(['area', 'propertyType'])
            ->latest('deleted_at')
            ->paginate(15);

        return view('admin.listings.trashed', compact('listings'));
    }

    public function restore(int $id)
    {
        $listing = Listing::onlyTrashed()->findOrFail($id);
        $listing->restore();

        return redirect()->route('admin.listings.trashed')->with('success', 'Listing berhasil dipulihkan.');
    }

    /**
     * Permanent, unrecoverable delete — the cover image file is purged here,
     * never in the regular (soft) destroy() above.
     */
    public function forceDelete(int $id, ImageUploadService $images)
    {
        $listing = Listing::onlyTrashed()->findOrFail($id);

        $images->delete($listing->cover_image);
        foreach ($listing->images as $image) {
            $images->delete($image->path);
        }

        $listing->forceDelete();

        return redirect()->route('admin.listings.trashed')->with('success', 'Listing dihapus permanen.');
    }

    protected function validated(Request $request, ?Listing $listing = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:5000'],
            'property_type_id' => ['required', 'exists:property_types,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'agent_id' => ['nullable', 'exists:agents,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'land_area' => ['nullable', 'integer', 'min:0'],
            'building_area' => ['nullable', 'integer', 'min:0'],
            'bedrooms' => ['required', 'integer', 'min:0', 'max:20'],
            'bathrooms' => ['required', 'integer', 'min:0', 'max:20'],
            'car_ports' => ['required', 'integer', 'min:0', 'max:20'],
            'badge' => ['nullable', 'in:Terpopuler,Baru,Premium'],
            'status' => ['required', 'in:active,sold,hidden'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        // Merge computed values last so they always win over raw validated input.
        return array_merge($validated, [
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $listing?->published_at ?? now(),
        ]);
    }

    /**
     * Stores newly uploaded gallery images (input name: images[]), each
     * validated individually, appended after the current max sort_order.
     */
    protected function storeGalleryImages(Request $request, Listing $listing, ImageUploadService $images): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $request->validate([
            'images.*' => ['image', 'max:2048'],
        ]);

        $nextOrder = (int) $listing->images()->max('sort_order') + 1;

        foreach ($request->file('images') as $file) {
            $path = $images->store($file, 'listings', maxWidth: 1400);
            $listing->images()->create(['path' => $path, 'sort_order' => $nextOrder++]);
        }
    }

    /**
     * Deletes gallery images the admin ticked for removal (input name:
     * delete_images[], values are listing_images.id). Scoped to THIS listing
     * only, so a crafted ID for another listing's image can never be deleted.
     */
    protected function deleteGalleryImages(Request $request, Listing $listing, ImageUploadService $imageService): void
    {
        $ids = collect($request->input('delete_images', []))->map(fn ($id) => (int) $id);

        if ($ids->isEmpty()) {
            return;
        }

        $toDelete = $listing->images()->whereIn('id', $ids)->get();

        foreach ($toDelete as $image) {
            $imageService->delete($image->path);
            $image->delete();
        }
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (Listing::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
