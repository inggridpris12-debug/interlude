<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function create()
    {
        $categories = [
            'Penelitian',
            'Tugas Kuliah',
            'Magang',
            'Organisasi',
            'Tips Belajar',
            'Kehidupan Kampus',
        ];

        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        // Hitung waktu baca (rata-rata 200 kata per menit)
        $wordCount = str_word_count(strip_tags($validated['content']));
        $validated['reading_time'] = max(1, ceil($wordCount / 200));

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        
        // Cek apakah tombol "Publikasikan" (1) atau "Simpan Draft" (0)
        $validated['is_published'] = $request->input('publish') == '1';
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        $article = Article::create($validated);

        $message = $validated['is_published'] 
            ? 'Artikel berhasil dipublikasikan!' 
            : 'Artikel berhasil disimpan sebagai draft!';

        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', $message);
    }

    public function show($slug)
    {
        $article = Article::with(['user', 'comments.user'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $article->increment('views_count');

        $relatedArticles = Article::with('user')
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->where('is_published', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }

    public function edit(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = [
            'Penelitian',
            'Tugas Kuliah',
            'Magang',
            'Organisasi',
            'Tips Belajar',
            'Kehidupan Kampus',
        ];

        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $wordCount = str_word_count(strip_tags($validated['content']));
        $validated['reading_time'] = max(1, ceil($wordCount / 200));

        $article->update($validated);

        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', 'Artikel berhasil diperbarui!');
    }
}