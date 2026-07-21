<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertyTypeController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $propertyTypes = PropertyType::withCount('listings')->orderBy('name')->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%' . $request->string('q') . '%'))
            ->paginate(20)->withQueryString();

        return view('admin.property-types.index', compact('propertyTypes'));
    }

    public function create()
    {
        return view('admin.property-types.form', ['propertyType' => new PropertyType()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);

        PropertyType::create($data);

        return redirect()->route('admin.property-types.index')->with('success', 'Tipe properti berhasil ditambahkan.');
    }

    public function edit(PropertyType $propertyType)
    {
        return view('admin.property-types.form', compact('propertyType'));
    }

    public function update(Request $request, PropertyType $propertyType)
    {
        $propertyType->update($this->validated($request));

        return redirect()->route('admin.property-types.index')->with('success', 'Tipe properti berhasil diperbarui.');
    }

    public function destroy(PropertyType $propertyType)
    {
        if ($propertyType->listings()->exists() || $propertyType->projects()->exists()) {
            return back()->withErrors(['name' => 'Tipe properti tidak bisa dihapus karena masih dipakai oleh listing atau project.']);
        }

        $propertyType->delete();

        return redirect()->route('admin.property-types.index')->with('success', 'Tipe properti berhasil dihapus.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);
    }
}
