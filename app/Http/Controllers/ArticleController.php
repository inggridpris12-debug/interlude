<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleDownload;
use App\Models\ArticleView;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    private array $categories = [
        'Penelitian',
        'Tugas Kuliah',
        'Magang',
        'Organisasi',
        'Tips Belajar',
        'Kehidupan Kampus',
    ];

    public function create()
    {
        $categories = $this->categories;

        return view('articles.create', compact('categories'));
    }

    public function explore(Request $request)
    {
        $categories = $this->categories;

        $search = trim((string) $request->query('q', ''));
        $selectedCategory = $request->query('category');
        $section = (string) $request->query('section', 'untukmu');

        $validSections = [
            'untukmu',
            'terbaru',
            'tersimpan',
            'riwayat',
            'unduhan',
            'langganan',
        ];

        if (! in_array($section, $validSections, true)) {
            $section = 'untukmu';
        }

        $user = Auth::user();

        $query = Article::query()
            ->with('user')
            ->withCount(['likes', 'comments'])
            ->where('articles.is_published', true);

        // Search dan kategori tetap bekerja pada semua tab.
        $query
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($articleQuery) use ($search) {
                    $articleQuery
                        ->where('articles.title', 'like', "%{$search}%")
                        ->orWhere('articles.excerpt', 'like', "%{$search}%")
                        ->orWhere('articles.category', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when(
                in_array($selectedCategory, $this->categories, true),
                fn ($query) => $query->where('articles.category', $selectedCategory)
            );

        switch ($section) {
            case 'terbaru':
                // Artikel yang paling baru dipublikasikan.
                $query->orderByDesc('articles.published_at');
                break;

            case 'tersimpan':
                // Hanya bookmark milik user yang sedang login.
                $query
                    ->whereHas('bookmarks', function ($bookmarkQuery) use ($user) {
                        $bookmarkQuery->where('user_id', $user->id);
                    })
                    ->orderByDesc(
                        Bookmark::query()
                            ->select('created_at')
                            ->whereColumn('article_id', 'articles.id')
                            ->where('user_id', $user->id)
                            ->latest()
                            ->limit(1)
                    );
                break;

            case 'riwayat':
                // Hanya artikel yang benar-benar pernah dibuka user.
                $query
                    ->join('article_views as user_views', function ($join) use ($user) {
                        $join->on('user_views.article_id', '=', 'articles.id')
                            ->where('user_views.user_id', '=', $user->id);
                    })
                    ->select('articles.*')
                    ->orderByDesc('user_views.last_viewed_at');
                break;

            case 'unduhan':
                // Hanya artikel yang pernah diunduh user.
                $query
                    ->join('article_downloads as user_downloads', function ($join) use ($user) {
                        $join->on('user_downloads.article_id', '=', 'articles.id')
                            ->where('user_downloads.user_id', '=', $user->id);
                    })
                    ->select('articles.*')
                    ->orderByDesc('user_downloads.last_downloaded_at');
                break;

            case 'langganan':
                // Hanya artikel dari akun yang di-follow user.
                $followingIds = $user->following()
                    ->pluck('users.id');

                if ($followingIds->isEmpty()) {
                    $query->whereRaw('1 = 0');
                } else {
                    $query
                        ->whereIn('articles.user_id', $followingIds)
                        ->orderByDesc('articles.published_at');
                }
                break;

            case 'untukmu':
            default:
                /*
                |--------------------------------------------------------------------------
                | Algoritma "Untukmu" v1
                |--------------------------------------------------------------------------
                | 1. Cari kategori yang paling sering dibaca user.
                | 2. Semakin sering kategori dibaca, semakin besar skornya.
                | 3. Artikel dari penulis yang di-follow mendapat bonus.
                | 4. Setelah skor, prioritaskan artikel yang lebih baru.
                | 5. Kalau user belum punya history/following, fallback ke terbaru +
                |    artikel dengan views_count lebih tinggi.
                */

                $categoryWeights = ArticleView::query()
                    ->where('article_views.user_id', $user->id)
                    ->join('articles', 'articles.id', '=', 'article_views.article_id')
                    ->select(
                        'articles.category',
                        DB::raw('SUM(article_views.view_count) as total_reads')
                    )
                    ->groupBy('articles.category')
                    ->orderByDesc('total_reads')
                    ->limit(4)
                    ->get();

                $followingIds = $user->following()
                    ->pluck('users.id');

                $hasReadingSignal = $categoryWeights->isNotEmpty();
                $hasFollowingSignal = $followingIds->isNotEmpty();

                if (! $hasReadingSignal && ! $hasFollowingSignal) {
                    // User baru: fallback yang netral.
                    $query
                        ->orderByDesc('articles.published_at')
                        ->orderByDesc('articles.views_count');
                    break;
                }

                $scoreParts = [];
                $scoreBindings = [];

                foreach ($categoryWeights as $index => $categoryWeight) {
                    // Ranking kategori teratas: 10, 8, 6, 4.
                    $score = max(4, 10 - ($index * 2));

                    $scoreParts[] = 'CASE WHEN articles.category = ? THEN ? ELSE 0 END';
                    $scoreBindings[] = $categoryWeight->category;
                    $scoreBindings[] = $score;
                }

                if ($hasFollowingSignal) {
                    $placeholders = implode(',', array_fill(0, $followingIds->count(), '?'));

                    $scoreParts[] = "CASE WHEN articles.user_id IN ({$placeholders}) THEN 4 ELSE 0 END";

                    foreach ($followingIds as $followingId) {
                        $scoreBindings[] = $followingId;
                    }
                }

                if (empty($scoreParts)) {
                    $scoreParts[] = '0';
                }

                $recommendationScore = implode(' + ', $scoreParts);

                $query
                    ->selectRaw(
                        "({$recommendationScore}) as recommendation_score",
                        $scoreBindings
                    )
                    ->orderByDesc('recommendation_score')
                    ->orderByDesc('articles.published_at');

                break;
        }

        $articles = $query
            ->paginate(10)
            ->withQueryString();

        return view('articles.explore', compact(
            'articles',
            'categories',
            'search',
            'selectedCategory',
            'section'
        ));
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
            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('covers', 'public');
        }

        $wordCount = str_word_count(strip_tags($validated['content']));
        $validated['reading_time'] = max(1, (int) ceil($wordCount / 200));

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']).'-'.Str::random(6);

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

        // Global views.
        $article->increment('views_count');

        // History per user.
        if (Auth::check()) {
            $view = ArticleView::firstOrNew([
                'user_id' => Auth::id(),
                'article_id' => $article->id,
            ]);

            $view->view_count = ($view->view_count ?? 0) + 1;
            $view->last_viewed_at = now();
            $view->save();
        }

        $relatedArticles = Article::with('user')
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->where('is_published', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        $isLiked = $article->isLikedBy(Auth::user());
        $isBookmarked = $article->isBookmarkedBy(Auth::user());

        $hasCoverImage = $article->cover_image
            && Storage::disk('public')->exists($article->cover_image);

        return view('articles.show', compact(
            'article',
            'relatedArticles',
            'isLiked',
            'isBookmarked',
            'hasCoverImage'
        ));
    }

    public function download(Article $article)
    {
        abort_unless($article->is_published, 404);

        $download = ArticleDownload::firstOrNew([
            'user_id' => Auth::id(),
            'article_id' => $article->id,
        ]);

        $download->download_count = ($download->download_count ?? 0) + 1;
        $download->last_downloaded_at = now();
        $download->save();

        /*
        |--------------------------------------------------------------------------
        | Download sederhana tanpa package tambahan
        |--------------------------------------------------------------------------
        | Untuk sekarang artikel diunduh sebagai HTML yang tetap bisa dibuka
        | offline di browser. Nanti kalau ingin PDF, route ini bisa diganti
        | menggunakan DomPDF.
        */

        $title = e($article->title);
        $author = e($article->user->name);
        $category = e($article->category);

        $html = <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    <style>
        body{
            max-width:780px;
            margin:48px auto;
            padding:0 24px;
            font-family:Arial,sans-serif;
            color:#30120A;
            line-height:1.75;
        }
        .meta{color:#705D55;margin-bottom:32px}
        h1{line-height:1.15}
        img{max-width:100%;height:auto}
    </style>
</head>
<body>
    <h1>{$title}</h1>
    <div class="meta">{$author} · {$category}</div>
    {$article->content}
</body>
</html>
HTML;

        $filename = Str::slug($article->title).'.html';

        return response()->streamDownload(
            function () use ($html) {
                echo $html;
            },
            $filename,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }

    public function edit(Article $article)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = $this->categories;

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
            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('covers', 'public');
        }

        $wordCount = str_word_count(strip_tags($validated['content']));
        $validated['reading_time'] = max(1, (int) ceil($wordCount / 200));

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
