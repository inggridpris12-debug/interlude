<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use App\Models\PodcastSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');

        if (!in_array($type, ['all', 'audio', 'video'], true)) {
            $type = 'all';
        }

        $query = Podcast::with(['user', 'series'])
            ->published()
            ->orderByDesc('published_at');

        if ($type !== 'all') {
            $query->where('media_type', $type);
        }

        $episodes = $query->paginate(12)->withQueryString();

        $featuredEpisode = Podcast::with(['user', 'series'])
            ->published()
            ->orderByDesc('views_count')
            ->orderByDesc('published_at')
            ->first();

        $series = PodcastSeries::withCount([
            'episodes as published_episodes_count' => fn ($q) => $q->published()
        ])
            ->having('published_episodes_count', '>', 0)
            ->orderByDesc('published_episodes_count')
            ->take(6)
            ->get();

        return view('podcasts.index', compact(
            'episodes',
            'featuredEpisode',
            'series',
            'type'
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
            'transcript' => ['nullable', 'string'],

            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'thumbnail_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'media_file' => [
                'required',
                'file',
                'max:204800',
            ],
        ]);

        $media = $request->file('media_file');
        $extension = strtolower($media->getClientOriginalExtension());

        $audioExtensions = ['mp3', 'wav', 'm4a', 'aac', 'ogg'];
        $videoExtensions = ['mp4', 'webm', 'mov', 'm4v'];

        if (
            $request->media_type === 'audio'
            && !in_array($extension, $audioExtensions, true)
        ) {
            return back()
                ->withErrors([
                    'media_file' => 'Untuk podcast audio gunakan MP3, WAV, M4A, AAC, atau OGG.',
                ])
                ->withInput();
        }

        if (
            $request->media_type === 'video'
            && !in_array($extension, $videoExtensions, true)
        ) {
            return back()
                ->withErrors([
                    'media_file' => 'Untuk podcast video gunakan MP4, WEBM, MOV, atau M4V.',
                ])
                ->withInput();
        }

        $seriesId = $request->podcast_series_id;

        if ($seriesId) {
            $owned = PodcastSeries::where('id', $seriesId)
                ->where('user_id', auth()->id())
                ->exists();

            if (!$owned) {
                abort(403);
            }
        }

        $mediaFolder = $request->media_type === 'audio'
            ? 'podcasts/audio'
            : 'podcasts/video';

        $mediaPath = $media->store($mediaFolder, 'public');

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
                'transcript' => $request->transcript,
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

        $podcast->increment('views_count');

        $podcast->load(['user', 'series']);

        $relatedEpisodes = Podcast::with('user')
            ->published()
            ->whereKeyNot($podcast->id)
            ->when(
                $podcast->category,
                fn ($q) => $q->where('category', $podcast->category)
            )
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('podcasts.show', compact(
            'podcast',
            'relatedEpisodes'
        ));
    }
}
