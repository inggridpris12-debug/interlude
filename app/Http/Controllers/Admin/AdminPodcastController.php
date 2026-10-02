<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPodcastController extends Controller
{
    /**
     * Daftar seluruh episode podcast untuk keperluan moderasi.
     */
    public function index(Request $request)
    {
        $status = (string) $request->query('status', 'all');
        $type = (string) $request->query('type', 'all');
        $search = trim((string) $request->query('q', ''));

        if (! in_array($status, ['all', 'published', 'draft'], true)) {
            $status = 'all';
        }

        if (! in_array($type, ['all', 'audio', 'video'], true)) {
            $type = 'all';
        }

        $query = Podcast::query()
            ->with(['user', 'series'])
            ->withCount(['likes', 'comments']);

        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        }

        if ($type !== 'all') {
            $query->where('media_type', $type);
        }

        if ($search !== '') {
            $query->where(function ($podcastQuery) use ($search) {
                $podcastQuery
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($userQuery) => $userQuery->where('name', 'like', "%{$search}%"));
            });
        }

        $podcasts = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => Podcast::count(),
            'published' => Podcast::where('is_published', true)->count(),
            'draft' => Podcast::where('is_published', false)->count(),
            'audio' => Podcast::where('media_type', 'audio')->count(),
            'video' => Podcast::where('media_type', 'video')->count(),
        ];

        return view('admin.podcasts', compact(
            'podcasts',
            'status',
            'type',
            'search',
            'stats'
        ));
    }

    /**
     * Publikasikan / sembunyikan episode podcast.
     */
    public function togglePublish(Podcast $podcast)
    {
        $podcast->is_published = ! $podcast->is_published;
        $podcast->published_at = $podcast->is_published
            ? ($podcast->published_at ?? now())
            : null;
        $podcast->save();

        return back()->with(
            'success',
            $podcast->is_published
                ? 'Episode podcast berhasil dipublikasikan.'
                : 'Episode podcast berhasil disembunyikan dari publik.'
        );
    }

    /**
     * Hapus episode podcast beserta seluruh berkas medianya.
     */
    public function destroy(Podcast $podcast)
    {
        Storage::disk('public')->delete(array_filter([
            $podcast->media_path,
            $podcast->cover_image,
            $podcast->thumbnail_image,
        ]));

        $podcast->delete();

        return back()->with('success', 'Episode podcast berhasil dihapus.');
    }
}
