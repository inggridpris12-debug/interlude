<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Public profile user lain / profil sendiri dalam mode publik.
     */
    public function show(User $user): View
    {
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
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(6)
            ->get();

        $podcasts = $user->podcasts()
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(6)
            ->get();

        $threads = $user->threads()
            ->where('visibility', 'public')
            ->latest()
            ->take(6)
            ->get();

        $activities = collect()
            ->concat($articles->map(fn ($article) => [
                'type' => 'article',
                'item' => $article,
                'timestamp' => ($article->published_at ?? $article->created_at)?->timestamp ?? 0,
            ]))
            ->concat($podcasts->map(fn ($podcast) => [
                'type' => 'podcast',
                'item' => $podcast,
                'timestamp' => ($podcast->published_at ?? $podcast->created_at)?->timestamp ?? 0,
            ]))
            ->concat($threads->map(fn ($thread) => [
                'type' => 'thread',
                'item' => $thread,
                'timestamp' => $thread->created_at?->timestamp ?? 0,
            ]))
            ->sortByDesc('timestamp')
            ->take(8)
            ->values();

        $viewer = Auth::user();
        $isOwnProfile = $viewer && $viewer->id === $user->id;
        $isFollowing = $viewer && ! $isOwnProfile
            ? $viewer->isFollowing($user)
            : false;

        return view('profile.public', compact(
            'user',
            'activities',
            'isOwnProfile',
            'isFollowing'
        ));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
