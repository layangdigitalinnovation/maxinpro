<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AreaController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $areas = Area::query()->when($request->filled('q'), fn($q) => $q->where('name', 'like', '%' . $request->string('q') . '%'))->orderBy('name')->paginate(20)->withQueryString();

        return view('admin.areas.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.areas.form', ['area' => new Area()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(4);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('areas', 'public');
        }

        Area::create($data);

        return redirect()->route('admin.areas.index')->with('success', 'Area berhasil ditambahkan.');
    }

    public function edit(Area $area)
    {
        return view('admin.areas.form', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image_path')) {
            if ($area->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($area->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('areas', 'public');
        }

        $area->update($data);

        return redirect()->route('admin.areas.index')->with('success', 'Area berhasil diperbarui.');
    }

    public function destroy(Area $area)
    {
        if ($area->listings()->exists() || $area->projects()->exists()) {
            return back()->withErrors(['area' => 'Area tidak bisa dihapus karena masih dipakai oleh listing/project.']);
        }

        if ($area->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($area->image_path);
        }

        $area->delete();

        return redirect()->route('admin.areas.index')->with('success', 'Area berhasil dihapus.');
    }

    protected function validated(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'city' => ['nullable', 'string', 'max:150'],
            'property_count' => ['nullable', 'integer', 'min:0'],
            'is_popular' => ['nullable', 'boolean'],
            'image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        return array_merge($validated, ['is_popular' => $request->boolean('is_popular')]);
    }
}
