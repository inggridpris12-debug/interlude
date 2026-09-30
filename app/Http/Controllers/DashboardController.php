<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Podcast;
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

        /*
        |------------------------------------------------------------------
        | PENULIS UNTUKMU
        |------------------------------------------------------------------
        | Akun yang aktif membuat artikel / podcast dan belum diikuti.
        */
        $recommendedWriters = User::query()
            ->withCount([
                'articles as published_articles_count' => fn ($query) => $query
                    ->where('is_published', true),
                'podcasts as published_podcasts_count' => fn ($query) => $query
                    ->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now()),
            ])
            ->where('id', '!=', $user->id)
            ->when(
                $followingIds->isNotEmpty(),
                fn ($query) => $query->whereNotIn('id', $followingIds)
            )
            ->orderByRaw('(published_articles_count + published_podcasts_count) DESC')
            ->take(2)
            ->get()
            ->filter(fn ($writer) => (
                $writer->published_articles_count
                + $writer->published_podcasts_count
            ) > 0)
            ->values();

        /*
        |------------------------------------------------------------------
        | TEMAN UNTUKMU
        |------------------------------------------------------------------
        | Kandidat user lain yang belum diikuti. Prioritas sederhana:
        | makin banyak akun yang sama-sama diikuti, makin tinggi posisinya.
        | Tidak butuh migration baru.
        */
        $excludeFriendIds = $followingIds
            ->concat([$user->id])
            ->concat($recommendedWriters->pluck('id'))
            ->unique()
            ->values();

        $friendCandidates = User::query()
            ->with(['following:id'])
            ->withCount('followers')
            ->whereNotIn('id', $excludeFriendIds->all())
            ->take(20)
            ->get()
            ->map(function ($candidate) use ($followingIds) {
                $candidate->mutual_count = $candidate->following
                    ->pluck('id')
                    ->intersect($followingIds)
                    ->count();

                return $candidate;
            })
            ->sort(function ($a, $b) {
                if ($a->mutual_count !== $b->mutual_count) {
                    return $b->mutual_count <=> $a->mutual_count;
                }

                return $b->followers_count <=> $a->followers_count;
            })
            ->take(3)
            ->values();

        /*
        |------------------------------------------------------------------
        | SERING DIKUNJUNGI
        |------------------------------------------------------------------
        | Gabungkan artikel + podcast lalu urutkan berdasarkan views_count.
        */
        $popularArticles = Article::query()
            ->with('user')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('views_count')
            ->take(5)
            ->get()
            ->map(fn ($article) => [
                'type' => 'article',
                'item' => $article,
                'views' => (int) ($article->views_count ?? 0),
            ]);

        $popularPodcasts = Podcast::query()
            ->with('user')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('views_count')
            ->take(5)
            ->get()
            ->map(fn ($podcast) => [
                'type' => 'podcast',
                'item' => $podcast,
                'views' => (int) ($podcast->views_count ?? 0),
            ]);

        $trendingContent = $popularArticles
            ->concat($popularPodcasts)
            ->sortByDesc('views')
            ->take(5)
            ->values();

        $feedItems = $this->buildFeed(
            feed: $feed,
            userId: $user->id,
            followingIds: $followingIds
        );

        return view('dashboard', compact(
            'feed',
            'feedItems',
            'recommendedWriters',
            'friendCandidates',
            'trendingContent',
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

    private function visiblePodcasts()
    {
        return Podcast::query()
            ->with('user')
            ->withCount(['likes', 'comments'])
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    private function buildFeed(
        string $feed,
        int $userId,
        Collection $followingIds
    ): Collection {
        $threads = $this->visibleThreads(
            $userId,
            $followingIds
        );

        $articles = Article::query()
            ->with('user')
            ->withCount(['likes', 'comments'])
            ->where('is_published', true);

        $podcasts = $this->visiblePodcasts();

        if ($feed === 'podcast') {
            return (clone $podcasts)
                ->latest('published_at')
                ->take(20)
                ->get()
                ->map(fn ($podcast) => $this->wrapFeedItem('podcast', $podcast))
                ->values();
        }

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

            $podcastItems = (clone $podcasts)
                ->whereIn('user_id', $followingIds)
                ->latest('published_at')
                ->take(20)
                ->get()
                ->map(fn ($podcast) => $this->wrapFeedItem('podcast', $podcast));

            return $this->sortChronologically(
                $threadItems
                    ->concat($articleItems)
                    ->concat($podcastItems)
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

        $podcastItems = (clone $podcasts)
            ->latest('published_at')
            ->take(30)
            ->get()
            ->map(function ($podcast) use (
                $followingIds,
                $categoryScores
            ) {
                $score = 0;

                if ($followingIds->contains($podcast->user_id)) {
                    $score += 4;
                }

                if (
                    $podcast->category
                    && isset($categoryScores[$podcast->category])
                ) {
                    $score += $categoryScores[$podcast->category];
                }

                return $this->wrapFeedItem(
                    'podcast',
                    $podcast,
                    $score
                );
            });

        return $threadItems
            ->concat($articleItems)
            ->concat($podcastItems)
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
        $timestamp = match ($type) {
            'article', 'podcast' => $item->published_at ?? $item->created_at,
            default => $item->created_at,
        };

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
