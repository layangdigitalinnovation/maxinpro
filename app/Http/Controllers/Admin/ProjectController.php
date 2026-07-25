<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Developer;
use App\Models\Project;
use App\Models\PropertyType;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with(['area', 'developer', 'propertyType'])
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%' . $request->string('q') . '%'))
            ->orderByPriority()
            ->paginate(15)
            ->withQueryString();

        return view('admin.projects.index', compact('projects'));
    }

    public function updateOrderAjax(Request $request, Project $project)
    {
        $validated = $request->validate([
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $project->update(['sort_order' => $validated['sort_order']]);

        return response()->json(['status' => 'success', 'message' => 'Urutan berhasil diperbarui']);
    }

    public function updatePublishAjax(Request $request, Project $project)
    {
        $validated = $request->validate([
            'is_published' => ['required', 'boolean'],
        ]);

        $project->update(['is_published' => $validated['is_published']]);

        return response()->json(['status' => 'success', 'message' => 'Status tayang berhasil diperbarui']);
    }

    public function create()
    {
        return view('admin.projects.form', [
            'project' => new Project(),
            'areas' => Area::orderBy('name')->get(),
            'developers' => Developer::orderBy('name')->get(),
            'propertyTypes' => PropertyType::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, ImageUploadService $images)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['published_at'] = now();
        // New projects land at the back of the priority queue by default —
        // an admin can drag them forward from the "Atur Urutan" screen.
        $data['priority_order'] = (int) Project::max('priority_order') + 1;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $images->store($request->file('cover_image'), 'projects');
        }

        $project = Project::create($data);

        $this->storeGalleryImages($request, $project, $images);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', [
            'project' => $project,
            'areas' => Area::orderBy('name')->get(),
            'developers' => Developer::orderBy('name')->get(),
            'propertyTypes' => PropertyType::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Project $project, ImageUploadService $images)
    {
        $data = $this->validated($request);

        if ($data['name'] !== $project->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $project->id);
        }

        if ($request->hasFile('cover_image')) {
            $images->delete($project->cover_image);
            $data['cover_image'] = $images->store($request->file('cover_image'), 'projects');
        }

        $project->update($data);

        $this->deleteGalleryImages($request, $project, $images);
        $this->storeGalleryImages($request, $project, $images);

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    /**
     * Project uses SoftDeletes — keep the cover image so a restored project
     * still has its photo. See the note in Admin\ListingController::destroy().
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project berhasil dihapus.');
    }

    public function trashed(Request $request)
    {
        $projects = Project::onlyTrashed()
            ->with(['area', 'developer'])
            ->latest('deleted_at')
            ->paginate(15);

        return view('admin.projects.trashed', compact('projects'));
    }

    /**
     * Drag-and-drop reorder screen. Only non-trashed projects are shown —
     * reordering a soft-deleted project has no visible effect anyway.
     */
    public function order()
    {
        $projects = Project::with(['developer'])->orderByPriority()->get();

        return view('admin.projects.order', compact('projects'));
    }

    /**
     * Persists the new order from the drag-and-drop screen. Expects an
     * ordered array of project IDs; position in the array becomes the new
     * priority_order (0-indexed), so index 0 = shown first everywhere.
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'distinct', 'exists:projects,id'],
        ]);

        foreach ($validated['order'] as $position => $projectId) {
            Project::whereKey($projectId)->update(['priority_order' => $position]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function restore(int $id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('admin.projects.trashed')->with('success', 'Project berhasil dipulihkan.');
    }

    public function forceDelete(int $id, ImageUploadService $images)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $images->delete($project->cover_image);
        foreach ($project->images as $image) {
            $images->delete($image->path);
        }

        $project->forceDelete();

        return redirect()->route('admin.projects.trashed')->with('success', 'Project dihapus permanen.');
    }

    protected function validated(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'developer_id' => ['required', 'exists:developers,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'property_type_id' => ['nullable', 'exists:property_types,id'],
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'in:Launching,Premium,New Cluster,Sold Out'],
            'price_from' => ['required', 'integer', 'min:0'],
            'units_available' => ['nullable', 'string', 'max:100'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        return array_merge($validated, [
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
        ]);
    }

    protected function storeGalleryImages(Request $request, Project $project, ImageUploadService $images): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $request->validate([
            'images.*' => ['image', 'max:2048'],
        ]);

        $nextOrder = (int) $project->images()->max('sort_order') + 1;

        foreach ($request->file('images') as $file) {
            $path = $images->store($file, 'projects', maxWidth: 1400);
            $project->images()->create(['path' => $path, 'sort_order' => $nextOrder++]);
        }
    }

    protected function deleteGalleryImages(Request $request, Project $project, ImageUploadService $imageService): void
    {
        $ids = collect($request->input('delete_images', []))->map(fn ($id) => (int) $id);

        if ($ids->isEmpty()) {
            return;
        }

        $toDelete = $project->images()->whereIn('id', $ids)->get();

        foreach ($toDelete as $image) {
            $imageService->delete($image->path);
            $image->delete();
        }
    }

    protected function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Project::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
