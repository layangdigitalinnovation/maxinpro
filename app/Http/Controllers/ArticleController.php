<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()->published()->latest('published_at')->paginate(9);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        abort_if(is_null($article->published_at), 404);

        return view('articles.show', compact('article'));
    }
}
