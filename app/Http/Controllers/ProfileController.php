<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Article;
use App\Models\Podcast;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private const AVATAR_PRESETS = [
        'botticelli',
        'linen',
        'tangelo',
        'sage',
        'chocolate',
    ];

    private const COVER_PRESETS = [
        'jeda-blue',
        'linen-wave',
        'tangelo-dawn',
        'brown-study',
        'sage-notes',
    ];

    public function show(Request $request, User $user): View
    {
        $tab = (string) $request->query('tab', 'activity');
        $allowedTabs = ['activity', 'articles', 'podcasts', 'threads', 'liked', 'about'];

        if (! in_array($tab, $allowedTabs, true)) {
            $tab = 'activity';
        }

        $user->loadCount([
            'followers',
            'following',
            'articles as published_articles_count' => fn ($query) => $query
                ->where('is_published', true),
            'podcasts as published_podcasts_count' => fn ($query) => $query
                ->where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now()),
            'threads as public_threads_count' => fn ($query) => $query
                ->where('visibility', 'public'),
        ]);

        $articles = $user->articles()
            ->withCount(['likes', 'comments'])
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(12)
            ->get();

        $podcasts = $user->podcasts()
            ->withCount(['likes', 'comments'])
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(12)
            ->get();

        $threads = $user->threads()
            ->withCount(['likes', 'replies'])
            ->where('visibility', 'public')
            ->latest()
            ->take(12)
            ->get();

        $activities = collect()
            ->concat($articles->take(6)->map(fn ($article) => [
                'type' => 'article',
                'item' => $article,
                'timestamp' => ($article->published_at ?? $article->created_at)?->timestamp ?? 0,
            ]))
            ->concat($podcasts->take(6)->map(fn ($podcast) => [
                'type' => 'podcast',
                'item' => $podcast,
                'timestamp' => ($podcast->published_at ?? $podcast->created_at)?->timestamp ?? 0,
            ]))
            ->concat($threads->take(6)->map(fn ($thread) => [
                'type' => 'thread',
                'item' => $thread,
                'timestamp' => $thread->created_at?->timestamp ?? 0,
            ]))
            ->sortByDesc('timestamp')
            ->take(12)
            ->values();

        $viewer = Auth::user();
        $isOwnProfile = $viewer && $viewer->id === $user->id;
        $isFollowing = $viewer && ! $isOwnProfile
            ? $viewer->isFollowing($user)
            : false;

        $canSeeLikes = $isOwnProfile || (bool) $user->show_likes_on_profile;
        $likedItems = collect();

        if ($tab === 'liked' && $canSeeLikes) {
            $likedArticles = Article::query()
                ->with([
                    'user',
                    'likes' => fn ($query) => $query->where('user_id', $user->id),
                ])
                ->where('is_published', true)
                ->whereHas('likes', fn ($query) => $query->where('user_id', $user->id))
                ->take(12)
                ->get()
                ->map(fn ($article) => [
                    'type' => 'article',
                    'item' => $article,
                    'timestamp' => optional($article->likes->first())->created_at?->timestamp
                        ?? $article->updated_at?->timestamp
                        ?? 0,
                ]);

            $likedPodcasts = Podcast::query()
                ->with([
                    'user',
                    'likes' => fn ($query) => $query->where('user_id', $user->id),
                ])
                ->where('is_published', true)
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now())
                ->whereHas('likes', fn ($query) => $query->where('user_id', $user->id))
                ->take(12)
                ->get()
                ->map(fn ($podcast) => [
                    'type' => 'podcast',
                    'item' => $podcast,
                    'timestamp' => optional($podcast->likes->first())->created_at?->timestamp
                        ?? $podcast->updated_at?->timestamp
                        ?? 0,
                ]);

            $likedThreads = Thread::query()
                ->with([
                    'user',
                    'likes' => fn ($query) => $query->where('user_id', $user->id),
                ])
                ->where('visibility', 'public')
                ->whereHas('likes', fn ($query) => $query->where('user_id', $user->id))
                ->take(12)
                ->get()
                ->map(fn ($thread) => [
                    'type' => 'thread',
                    'item' => $thread,
                    'timestamp' => optional($thread->likes->first())->created_at?->timestamp
                        ?? $thread->updated_at?->timestamp
                        ?? 0,
                ]);

            $likedItems = $likedArticles
                ->concat($likedPodcasts)
                ->concat($likedThreads)
                ->sortByDesc('timestamp')
                ->take(18)
                ->values();
        }

        return view('profile.public', compact(
            'user',
            'tab',
            'articles',
            'podcasts',
            'threads',
            'activities',
            'likedItems',
            'canSeeLikes',
            'isOwnProfile',
            'isFollowing'
        ));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateDetails(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'username' => [
                'nullable',
                'string',
                'min:3',
                'max:30',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'bio' => ['nullable', 'string', 'max:500'],
            'university' => ['nullable', 'string', 'max:120'],
            'major' => ['nullable', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:120'],
            'show_likes_on_profile' => ['nullable', 'boolean'],
        ]);

        $user->fill([
            'username' => $validated['username'] ?: null,
            'bio' => $validated['bio'] ?: null,
            'university' => $validated['university'] ?: null,
            'major' => $validated['major'] ?: null,
            'location' => $validated['location'] ?: null,
            'show_likes_on_profile' => $request->boolean('show_likes_on_profile'),
        ])->save();

        return redirect()
            ->route('users.show', $user)
            ->with('profile_success', 'Profil berhasil diperbarui.');
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'avatar_mode' => ['required', Rule::in(['preset', 'upload'])],
            'avatar_preset' => ['nullable', Rule::in(self::AVATAR_PRESETS)],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($validated['avatar_mode'] === 'preset') {
            $request->validate([
                'avatar_preset' => ['required', Rule::in(self::AVATAR_PRESETS)],
            ]);

            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->update([
                'profile_photo' => null,
                'profile_avatar_preset' => $validated['avatar_preset'],
            ]);
        } else {
            $request->validate([
                'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            ]);

            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');

            $user->update([
                'profile_photo' => $path,
            ]);
        }

        return redirect()
            ->route('users.show', $user)
            ->with('profile_success', 'Foto profil berhasil diperbarui.');
    }

    public function removeAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->update(['profile_photo' => null]);

        return redirect()
            ->route('users.show', $user)
            ->with('profile_success', 'Foto upload dihapus. Avatar Interlude dipakai kembali.');
    }

    public function updateCover(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'cover_mode' => ['required', Rule::in(['preset', 'upload'])],
            'cover_preset' => ['nullable', Rule::in(self::COVER_PRESETS)],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ]);

        if ($validated['cover_mode'] === 'preset') {
            $request->validate([
                'cover_preset' => ['required', Rule::in(self::COVER_PRESETS)],
            ]);

            if ($user->cover_image) {
                Storage::disk('public')->delete($user->cover_image);
            }

            $user->update([
                'cover_image' => null,
                'cover_preset' => $validated['cover_preset'],
            ]);
        } else {
            $request->validate([
                'cover_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            ]);

            if ($user->cover_image) {
                Storage::disk('public')->delete($user->cover_image);
            }

            $path = $request->file('cover_image')->store('profile-covers', 'public');

            $user->update([
                'cover_image' => $path,
            ]);
        }

        return redirect()
            ->route('users.show', $user)
            ->with('profile_success', 'Sampul profil berhasil diperbarui.');
    }

    public function removeCover(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->cover_image) {
            Storage::disk('public')->delete($user->cover_image);
        }

        $user->update(['cover_image' => null]);

        return redirect()
            ->route('users.show', $user)
            ->with('profile_success', 'Sampul upload dihapus. Sampul Interlude dipakai kembali.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        if ($user->cover_image) {
            Storage::disk('public')->delete($user->cover_image);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
