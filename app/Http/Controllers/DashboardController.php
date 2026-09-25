<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $categories = [
            'Penelitian',
            'Tugas Kuliah',
            'Magang',
            'Organisasi',
            'Tips Belajar',
            'Kehidupan Kampus',
        ];

        $feed = (string) $request->query('feed', 'untukmu');

        $validFeeds = [
            'untukmu',
            'mengikuti',
            'utas',
            'artikel',
            'podcast',
        ];

        if (! in_array($feed, $validFeeds, true)) {
            $feed = 'untukmu';
        }

        $followingIds = $user->following()->pluck('users.id');

        $recommendedWriters = User::query()
            ->withCount([
                'articles' => fn ($query) => $query->where('is_published', true),
            ])
            ->where('id', '!=', $user->id)
            ->when(
                $followingIds->isNotEmpty(),
                fn ($query) => $query->whereNotIn('id', $followingIds)
            )
            ->orderByDesc('articles_count')
            ->take(4)
            ->get();

        $trendingArticles = Article::query()
            ->with('user')
            ->where('is_published', true)
            ->where('published_at', '>=', now()->subDays(7))
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        $feedItems = $this->buildFeed(
            feed: $feed,
            userId: $user->id,
            followingIds: $followingIds
        );

        return view('dashboard', compact(
            'feed',
            'feedItems',
            'recommendedWriters',
            'trendingArticles',
            'categories'
        ));
    }

    private function visibleThreads(
        int $userId,
        Collection $followingIds
    ) {
        return Thread::query()
            ->with([
                'user',
                'attachments',
                'poll.options.votes',
                'poll.votes',
            ])
            ->withCount([
                'likes',
                'replies',
            ])
            ->where(function ($query) use ($userId, $followingIds) {
                $query
                    ->where('visibility', 'public')
                    ->orWhere('user_id', $userId);

                if ($followingIds->isNotEmpty()) {
                    $query->orWhere(function ($followersQuery) use ($followingIds) {
                        $followersQuery
                            ->where('visibility', 'followers')
                            ->whereIn('user_id', $followingIds);
                    });
                }
            });
    }

    private function buildFeed(
        string $feed,
        int $userId,
        Collection $followingIds
    ): Collection {
        if ($feed === 'podcast') {
            return collect();
        }

        $threads = $this->visibleThreads(
            $userId,
            $followingIds
        );

        $articles = Article::query()
            ->with('user')
            ->withCount(['likes', 'comments'])
            ->where('is_published', true);

        if ($feed === 'mengikuti') {
            if ($followingIds->isEmpty()) {
                return collect();
            }

            $threadItems = (clone $threads)
                ->whereIn('user_id', $followingIds)
                ->latest()
                ->take(20)
                ->get()
                ->map(fn ($thread) => $this->wrapFeedItem('thread', $thread));

            $articleItems = (clone $articles)
                ->whereIn('user_id', $followingIds)
                ->latest('published_at')
                ->take(20)
                ->get()
                ->map(fn ($article) => $this->wrapFeedItem('article', $article));

            return $this->sortChronologically(
                $threadItems->concat($articleItems)
            )->take(20)->values();
        }

        if ($feed === 'utas') {
            return (clone $threads)
                ->latest()
                ->take(20)
                ->get()
                ->map(fn ($thread) => $this->wrapFeedItem('thread', $thread))
                ->values();
        }

        if ($feed === 'artikel') {
            return (clone $articles)
                ->latest('published_at')
                ->take(20)
                ->get()
                ->map(fn ($article) => $this->wrapFeedItem('article', $article))
                ->values();
        }

        $categoryWeights = collect();

        if (
            class_exists(ArticleView::class)
            && Schema::hasTable('article_views')
        ) {
            $categoryWeights = ArticleView::query()
                ->where('article_views.user_id', $userId)
                ->join(
                    'articles',
                    'articles.id',
                    '=',
                    'article_views.article_id'
                )
                ->selectRaw(
                    'articles.category, SUM(article_views.view_count) as total_reads'
                )
                ->groupBy('articles.category')
                ->orderByDesc('total_reads')
                ->limit(4)
                ->get()
                ->values();
        }

        $categoryScores = [];

        foreach ($categoryWeights as $index => $row) {
            $categoryScores[$row->category] = max(
                2,
                8 - ($index * 2)
            );
        }

        $threadItems = (clone $threads)
            ->latest()
            ->take(30)
            ->get()
            ->map(function ($thread) use (
                $followingIds,
                $categoryScores
            ) {
                $score = 0;

                if ($followingIds->contains($thread->user_id)) {
                    $score += 4;
                }

                if (
                    $thread->topic
                    && isset($categoryScores[$thread->topic])
                ) {
                    $score += $categoryScores[$thread->topic];
                }

                return $this->wrapFeedItem(
                    'thread',
                    $thread,
                    $score
                );
            });

        $articleItems = (clone $articles)
            ->latest('published_at')
            ->take(30)
            ->get()
            ->map(function ($article) use (
                $followingIds,
                $categoryScores
            ) {
                $score = 0;

                if ($followingIds->contains($article->user_id)) {
                    $score += 4;
                }

                if (isset($categoryScores[$article->category])) {
                    $score += $categoryScores[$article->category];
                }

                return $this->wrapFeedItem(
                    'article',
                    $article,
                    $score
                );
            });

        return $threadItems
            ->concat($articleItems)
            ->sort(function ($a, $b) {
                if ($a['score'] !== $b['score']) {
                    return $b['score'] <=> $a['score'];
                }

                return $b['timestamp'] <=> $a['timestamp'];
            })
            ->take(20)
            ->values();
    }

    private function wrapFeedItem(
        string $type,
        $item,
        int $score = 0
    ): array {
        $timestamp = $type === 'article'
            ? ($item->published_at ?? $item->created_at)
            : $item->created_at;

        return [
            'type' => $type,
            'item' => $item,
            'score' => $score,
            'timestamp' => $timestamp?->timestamp ?? 0,
        ];
    }

    private function sortChronologically(Collection $items): Collection
    {
        return $items->sortByDesc('timestamp')->values();
    }
}
