<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $articles = Article::query()->when($request->filled('q'), fn($q) => $q->where('title', 'like', '%' . $request->string('q') . '%'))->latest()->paginate(20)->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.form', ['article' => new Article()]);
    }

    public function store(Request $request, ImageUploadService $images)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['published_at'] = $request->boolean('publish_now') ? now() : null;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $images->store($request->file('cover_image'), 'articles');
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, Article $article, ImageUploadService $images)
    {
        $data = $this->validated($request);

        if ($data['title'] !== $article->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $article->id);
        }

        $data['published_at'] = $request->boolean('publish_now') ? ($article->published_at ?? now()) : null;

        if ($request->hasFile('cover_image')) {
            $images->delete($article->cover_image);
            $data['cover_image'] = $images->store($request->file('cover_image'), 'articles');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article, ImageUploadService $images)
    {
        $images->delete($article->cover_image);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category' => ['nullable', 'string', 'max:50'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:20000'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (Article::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
