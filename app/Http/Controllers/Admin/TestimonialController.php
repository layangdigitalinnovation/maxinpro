<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $testimonials = Testimonial::query()->when($request->filled('q'), fn($q) => $q->where('author_name', 'like', '%' . $request->string('q') . '%'))->latest()->paginate(20)->withQueryString();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.form', ['testimonial' => new Testimonial()]);
    }

    public function store(Request $request, ImageUploadService $images)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $images->store($request->file('photo'), 'testimonials', maxWidth: 400);
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial, ImageUploadService $images)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $images->delete($testimonial->photo_path);
            $data['photo_path'] = $images->store($request->file('photo'), 'testimonials', maxWidth: 400);
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial, ImageUploadService $images)
    {
        $images->delete($testimonial->photo_path);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus.');
    }

    protected function validated(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'city' => ['nullable', 'string', 'max:100'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'quote' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        unset($validated['photo']);

        return array_merge($validated, ['is_active' => $request->boolean('is_active', true)]);
    }
}
