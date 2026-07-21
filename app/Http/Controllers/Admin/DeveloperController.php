<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $developers = Developer::query()->when($request->filled('q'), fn($q) => $q->where('name', 'like', '%' . $request->string('q') . '%'))->orderBy('name')->paginate(20)->withQueryString();

        return view('admin.developers.index', compact('developers'));
    }

    public function create()
    {
        return view('admin.developers.form', ['developer' => new Developer()]);
    }

    public function store(Request $request)
    {
        Developer::create($this->validated($request));

        return redirect()->route('admin.developers.index')->with('success', 'Developer berhasil ditambahkan.');
    }

    public function edit(Developer $developer)
    {
        return view('admin.developers.form', compact('developer'));
    }

    public function update(Request $request, Developer $developer)
    {
        $developer->update($this->validated($request));

        return redirect()->route('admin.developers.index')->with('success', 'Developer berhasil diperbarui.');
    }

    public function destroy(Developer $developer)
    {
        if ($developer->projects()->exists()) {
            return back()->withErrors(['developer' => 'Developer tidak bisa dihapus karena masih memiliki project.']);
        }

        $developer->delete();

        return redirect()->route('admin.developers.index')->with('success', 'Developer berhasil dihapus.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
        ]);
    }
}
