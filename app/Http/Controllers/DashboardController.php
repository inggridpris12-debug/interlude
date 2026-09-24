<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Get featured article
        $featuredArticle = Article::with('user')
            ->where('is_featured', true)
            ->where('is_published', true)
            ->first();

        // Get latest articles for feed
        $articles = Article::with('user')
            ->withCount(['likes', 'comments'])
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        // Get recommended writers (users with most articles)
        $recommendedWriters = User::withCount('articles')
            ->where('id', '!=', auth()->id())
            ->orderBy('articles_count', 'desc')
            ->take(3)
            ->get();

        // Get trending articles (most viewed in last 7 days)
        $trendingArticles = Article::with('user')
            ->where('is_published', true)
            ->where('published_at', '>=', now()->subDays(7))
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        // Popular categories
        $categories = [
            'Penelitian',
            'Tugas Kuliah',
            'Magang',
            'Organisasi',
            'Tips Belajar',
            'Kehidupan Kampus',
        ];

        return view('dashboard', compact(
            'featuredArticle',
            'articles',
            'recommendedWriters',
            'trendingArticles',
            'categories'
        ));
    }
}
