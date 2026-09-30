<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Models\PodcastComment;
use App\Models\PodcastSeries;
use App\Models\PodcastView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');
        $duration = $request->get('duration', 'all');
        $category = $request->get('category', 'all');
        $search = trim((string) $request->get('q', ''));

        if (! in_array($type, ['all', 'audio', 'video'], true)) {
            $type = 'all';
        }

        if (! in_array($duration, ['all', 'short', 'medium', 'long'], true)) {
            $duration = 'all';
        }

        $query = Podcast::with(['user', 'series'])
            ->withCount(['likes', 'comments'])
            ->published();

        if ($type !== 'all') {
            $query->where('media_type', $type);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        if ($duration === 'short') {
            $query->where('duration_seconds', '<', 900);
        } elseif ($duration === 'medium') {
            $query->whereBetween('duration_seconds', [900, 1800]);
        } elseif ($duration === 'long') {
            $query->where('duration_seconds', '>', 1800);
        }

        $featuredEpisode = (clone $query)
            ->orderByDesc('views_count')
            ->orderByDesc('published_at')
            ->first();

        $episodes = $query
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Podcast::published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $series = PodcastSeries::withCount([
            'episodes as published_episodes_count' => fn ($q) => $q->published(),
        ])
            ->having('published_episodes_count', '>', 0)
            ->orderByDesc('published_episodes_count')
            ->take(6)
            ->get();

        $audioCount = Podcast::published()->where('media_type', 'audio')->count();
        $videoCount = Podcast::published()->where('media_type', 'video')->count();

        return view('podcasts.index', compact(
            'episodes',
            'featuredEpisode',
            'series',
            'type',
            'duration',
            'category',
            'search',
            'categories',
            'audioCount',
            'videoCount'
        ));
    }

    public function create()
    {
        $series = PodcastSeries::where('user_id', auth()->id())
            ->orderBy('title')
            ->get();

        $categories = [
            'Kehidupan Kampus',
            'Tugas Kuliah',
            'Penelitian',
            'Magang',
            'Organisasi',
            'Karier',
            'Tips Belajar',
        ];

        return view('podcasts.create', compact('series', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:5000'],
            'category' => ['nullable', 'string', 'max:80'],
            'media_type' => ['required', 'in:audio,video'],
            'podcast_series_id' => ['nullable', 'exists:podcast_series,id'],
            'episode_number' => ['nullable', 'integer', 'min:1'],
            'duration_seconds' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'thumbnail_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'media_file' => ['required', 'file', 'max:204800'],
        ]);

        $media = $request->file('media_file');
        $extension = strtolower($media->getClientOriginalExtension());
        $audioExtensions = ['mp3', 'wav', 'm4a', 'aac', 'ogg'];
        $videoExtensions = ['mp4', 'webm', 'mov', 'm4v'];

        if ($request->media_type === 'audio' && ! in_array($extension, $audioExtensions, true)) {
            return back()
                ->withErrors(['media_file' => 'Untuk podcast audio gunakan MP3, WAV, M4A, AAC, atau OGG.'])
                ->withInput();
        }

        if ($request->media_type === 'video' && ! in_array($extension, $videoExtensions, true)) {
            return back()
                ->withErrors(['media_file' => 'Untuk podcast video gunakan MP4, WEBM, MOV, atau M4V.'])
                ->withInput();
        }

        $seriesId = $request->podcast_series_id;

        if (
            $seriesId
            && ! PodcastSeries::where('id', $seriesId)
                ->where('user_id', auth()->id())
                ->exists()
        ) {
            abort(403);
        }

        $mediaPath = $media->store(
            $request->media_type === 'audio' ? 'podcasts/audio' : 'podcasts/video',
            'public'
        );

        $coverPath = $request->hasFile('cover_image')
            ? $request->file('cover_image')->store('podcasts/covers', 'public')
            : null;

        $thumbnailPath = $request->hasFile('thumbnail_image')
            ? $request->file('thumbnail_image')->store('podcasts/thumbnails', 'public')
            : null;

        try {
            $podcast = Podcast::create([
                'user_id' => auth()->id(),
                'podcast_series_id' => $seriesId,
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'media_type' => $request->media_type,
                'cover_image' => $coverPath,
                'thumbnail_image' => $thumbnailPath,
                'media_path' => $mediaPath,
                'external_url' => null,
                'duration_seconds' => $request->integer('duration_seconds', 0),
                'episode_number' => $request->episode_number,
                'transcript' => null,
                'is_published' => true,
                'published_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Storage::disk('public')->delete(array_filter([
                $mediaPath,
                $coverPath,
                $thumbnailPath,
            ]));

            throw $e;
        }

        return redirect()
            ->route('podcasts.show', $podcast)
            ->with('success', 'Podcast berhasil dipublikasikan.');
    }

    public function show(Podcast $podcast)
    {
        abort_unless(
            $podcast->is_published || $podcast->user_id === auth()->id(),
            404
        );

        // Statistik global podcast.
        $podcast->increment('views_count');

        // Riwayat podcast per user. Dibuat aman: kalau migration belum dijalankan,
        // halaman podcast tetap tidak crash.
        if (auth()->check() && Schema::hasTable('podcast_views')) {
            $view = PodcastView::firstOrNew([
                'user_id' => auth()->id(),
                'podcast_id' => $podcast->id,
            ]);

            $view->view_count = ((int) $view->view_count) + 1;
            $view->last_viewed_at = now();
            $view->save();
        }

        $podcast->load(['user', 'series'])
            ->loadCount(['likes', 'comments']);

        $comments = $podcast->rootComments()
            ->with(['user', 'repliesRecursive'])
            ->get();

        $relatedEpisodes = Podcast::with(['user', 'series'])
            ->withCount(['likes', 'comments'])
            ->published()
            ->whereKeyNot($podcast->id)
            ->where('media_type', $podcast->media_type)
            ->when(
                $podcast->category,
                fn ($q) => $q->orderByRaw('category = ? desc', [$podcast->category])
            )
            ->latest('published_at')
            ->take(5)
            ->get();

        $liked = $podcast->isLikedBy(auth()->user());
        $bookmarked = $podcast->isBookmarkedBy(auth()->user());

        return view('podcasts.show', compact(
            'podcast',
            'relatedEpisodes',
            'comments',
            'liked',
            'bookmarked'
        ));
    }

    public function like(Request $request, Podcast $podcast)
    {
        $existing = $podcast->likes()
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            $podcast->likes()->create(['user_id' => auth()->id()]);
            $liked = true;
        }

        $count = $podcast->likes()->count();

        return $request->expectsJson()
            ? response()->json(['liked' => $liked, 'count' => $count])
            : back();
    }

    public function bookmark(Request $request, Podcast $podcast)
    {
        $existing = $podcast->bookmarks()
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
        } else {
            $podcast->bookmarks()->create(['user_id' => auth()->id()]);
            $bookmarked = true;
        }

        return $request->expectsJson()
            ? response()->json(['bookmarked' => $bookmarked])
            : back();
    }

    public function comment(Request $request, Podcast $podcast)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'integer', 'exists:podcast_comments,id'],
        ]);

        $parentId = $validated['parent_id'] ?? null;

        if ($parentId) {
            abort_unless(
                PodcastComment::where('id', $parentId)
                    ->where('podcast_id', $podcast->id)
                    ->exists(),
                422
            );
        }

        $podcast->comments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $parentId,
            'body' => trim($validated['body']),
        ]);

        return back()->with('comment_success', 'Komentar berhasil dikirim.');
    }
}
