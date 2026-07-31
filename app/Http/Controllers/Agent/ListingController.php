<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
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
        $agent = $request->user()->agentProfile;
        abort_unless($agent, 403, 'Profil agen tidak ditemukan.');

        $listings = Listing::query()
            ->with(['area', 'propertyType'])
            ->where('agent_id', $agent->id)
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%' . $request->string('q') . '%'))
            ->orderByPriority()
            ->paginate(15)
            ->withQueryString();

        return view('agent.listings.index', compact('listings'));
    }

    public function create()
    {
        return view('agent.listings.form', [
            'listing' => new Listing(),
            'areas' => Area::orderBy('name')->get(),
            'propertyTypes' => PropertyType::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, ImageUploadService $images)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['agent_id'] = $request->user()->agentProfile->id;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $images->store($request->file('cover_image'), 'listings');
        }

        $listing = Listing::create($data);

        $this->storeGalleryImages($request, $listing, $images);

        return redirect()->route('agent.listings.index')->with('success', 'Listing berhasil ditambahkan.');
    }

    public function edit(Request $request, Listing $listing)
    {
        $agent = $request->user()->agentProfile;
        abort_unless($listing->agent_id === $agent->id, 403, 'Anda tidak memiliki akses ke listing ini.');

        return view('agent.listings.form', [
            'listing' => $listing,
            'areas' => Area::orderBy('name')->get(),
            'propertyTypes' => PropertyType::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Listing $listing, ImageUploadService $images)
    {
        $agent = $request->user()->agentProfile;
        abort_unless($listing->agent_id === $agent->id, 403, 'Anda tidak memiliki akses ke listing ini.');

        $data = $this->validated($request, $listing);

        if ($data['title'] !== $listing->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $listing->id);
        }

        if ($request->hasFile('cover_image')) {
            $images->delete($listing->cover_image);
            $data['cover_image'] = $images->store($request->file('cover_image'), 'listings');
        }

        // Agent listings should not be updated status unless specifically logic says otherwise.
        if ($listing->status === 'hidden' && !isset($data['status'])) {
            $data['status'] = 'hidden';
        }

        $listing->update($data);

        $this->deleteGalleryImages($request, $listing, $images);
        $this->storeGalleryImages($request, $listing, $images);

        return redirect()->route('agent.listings.index')->with('success', 'Listing berhasil diperbarui.');
    }

    public function destroy(Request $request, Listing $listing)
    {
        $agent = $request->user()->agentProfile;
        abort_unless($listing->agent_id === $agent->id, 403, 'Anda tidak memiliki akses ke listing ini.');

        $listing->delete();

        return redirect()->route('agent.listings.index')->with('success', 'Listing berhasil dihapus.');
    }

    protected function validated(Request $request, ?Listing $listing = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:5000'],
            'property_type_id' => ['required', 'exists:property_types,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'land_area' => ['nullable', 'integer', 'min:0'],
            'building_area' => ['nullable', 'integer', 'min:0'],
            'bedrooms' => ['required', 'integer', 'min:0', 'max:20'],
            'bathrooms' => ['required', 'integer', 'min:0', 'max:20'],
            'car_ports' => ['required', 'integer', 'min:0', 'max:20'],
            'status' => ['nullable', 'in:active,sold,hidden'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'badge' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        return array_merge($validated, [
            'published_at' => $listing?->published_at ?? now(),
            'is_published' => $request->boolean('is_published'),
            'is_featured' => $request->boolean('is_featured'),
        ]);
    }

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

    public function updatePublishAjax(Request $request, Listing $listing)
    {
        $agent = $request->user()->agentProfile;
        if ($listing->agent_id !== $agent->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $listing->update(['is_published' => $request->boolean('is_published')]);
        return response()->json(['status' => 'success']);
    }

    public function updateOrderAjax(Request $request, Listing $listing)
    {
        $agent = $request->user()->agentProfile;
        if ($listing->agent_id !== $agent->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $listing->update(['sort_order' => $request->integer('sort_order')]);
        return response()->json(['status' => 'success']);
    }
}
