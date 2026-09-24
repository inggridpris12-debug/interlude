<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function explore(Request $request)
    {
        $categories = [
            'Penelitian',
            'Tugas Kuliah',
            'Magang',
            'Organisasi',
            'Tips Belajar',
            'Kehidupan Kampus',
        ];

        $search = trim((string) $request->query('q', ''));
        $selectedCategory = $request->query('category');

        $articles = Article::query()
            ->with('user')
            ->withCount(['likes', 'comments'])
            ->where('is_published', true)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($articleQuery) use ($search) {
                    $articleQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when(in_array($selectedCategory, $categories, true), function ($query) use ($selectedCategory) {
                $query->where('category', $selectedCategory);
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('articles.explore', compact('articles', 'categories', 'search', 'selectedCategory'));
    }

    public function manage()
    {
        $articles = Article::query()
            ->where('user_id', Auth::id())
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(8);

        return view('articles.edit', compact('articles'));
    }

    public function saved()
    {
        $bookmarks = Bookmark::query()
            ->where('user_id', Auth::id())
            ->with(['article.user'])
            ->latest()
            ->paginate(8);

        return view('articles.saved', compact('bookmarks'));
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
        $validated['slug'] = Str::slug($validated['title']).'-'.Str::random(6);

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
            ->withCount(['likes', 'comments'])
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

        $isLiked = $article->isLikedBy(Auth::user());
        $isBookmarked = $article->isBookmarkedBy(Auth::user());
        $hasCoverImage = $article->cover_image && Storage::disk('public')->exists($article->cover_image);

        return view('articles.show', compact('article', 'relatedArticles', 'isLiked', 'isBookmarked', 'hasCoverImage'));
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

        return view('articles.create', compact('article', 'categories'));
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

        $validated['is_published'] = $request->input('publish') === '1';
        $validated['published_at'] = $validated['is_published']
            ? ($article->published_at ?? now())
            : null;

        $article->update($validated);

        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }

        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }

        $article->delete();

        return redirect()
            ->route('articles.manage')
            ->with('success', 'Karya berhasil dihapus.');
    }
}
