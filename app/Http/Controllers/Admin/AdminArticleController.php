<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{
    /**
     * Daftar seluruh artikel untuk keperluan kurasi & moderasi.
     */
    public function index(Request $request)
    {
        $status = (string) $request->query('status', 'all');
        $category = (string) $request->query('category', 'all');
        $search = trim((string) $request->query('q', ''));

        if (! in_array($status, ['all', 'published', 'draft', 'featured'], true)) {
            $status = 'all';
        }

        $query = Article::query()
            ->with('user')
            ->withCount(['likes', 'comments']);

        match ($status) {
            'published' => $query->where('is_published', true),
            'draft' => $query->where('is_published', false),
            'featured' => $query->where('is_featured', true),
            default => null,
        };

        if ($search !== '') {
            $query->where(function ($articleQuery) use ($search) {
                $articleQuery
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', "%{$search}%"));
            });
        }

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $articles = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => Article::count(),
            'published' => Article::where('is_published', true)->count(),
            'draft' => Article::where('is_published', false)->count(),
            'featured' => Article::where('is_featured', true)->count(),
        ];

        $categories = Article::query()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin.articles', compact(
            'articles',
            'status',
            'category',
            'search',
            'stats',
            'categories'
        ));
    }

    /**
     * Publikasikan / sembunyikan artikel.
     */
    public function togglePublish(Article $article)
    {
        $article->is_published = ! $article->is_published;
        $article->published_at = $article->is_published
            ? ($article->published_at ?? now())
            : null;
        $article->save();

        return back()->with(
            'success',
            $article->is_published
                ? 'Artikel berhasil dipublikasikan.'
                : 'Artikel berhasil disembunyikan dari publik.'
        );
    }

    /**
     * Tandai / lepas artikel sebagai pilihan kurasi.
     */
    public function toggleFeature(Article $article)
    {
        if (! $article->is_featured) {
            $limit = max(1, (int) Setting::get('featured_limit', 6));

            if (Article::where('is_featured', true)->count() >= $limit) {
                return back()->withErrors([
                    'featured' => "Batas maksimal {$limit} artikel pilihan sudah tercapai. Lepas salah satu artikel kurasi terlebih dahulu.",
                ]);
            }
        }

        $article->is_featured = ! $article->is_featured;
        $article->save();

        return back()->with(
            'success',
            $article->is_featured
                ? 'Artikel ditandai sebagai pilihan kurasi.'
                : 'Tanda kurasi artikel dihapus.'
        );
    }

    /**
     * Hapus artikel beserta cover-nya.
     */
    public function destroy(Article $article)
    {
        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }

        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus.');
    }
}
