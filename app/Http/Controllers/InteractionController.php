<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Notifications\InteractionNotification;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function like(Article $article)
    {
        $user = auth()->user();

        if ($article->isLikedBy($user)) {
            $article->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $article->likes()->create(['user_id' => $user->id]);
            $liked = true;

            if ($article->user_id !== $user->id) {
                $article->user->notify(new InteractionNotification(
                    'like',
                    $user->name.' menyukai artikelmu.',
                    route('articles.show', $article->slug),
                ));
            }
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $article->likes()->count(),
        ]);
    }

    public function bookmark(Article $article)
    {
        $user = auth()->user();

        if ($article->isBookmarkedBy($user)) {
            $article->bookmarks()->where('user_id', $user->id)->delete();
            $bookmarked = false;
        } else {
            $article->bookmarks()->create(['user_id' => $user->id]);
            $bookmarked = true;
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
        ]);
    }

    public function comment(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $article->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        if ($article->user_id !== auth()->id()) {
            $article->user->notify(new InteractionNotification(
                'comment',
                auth()->user()->name.' mengomentari artikelmu.',
                route('articles.show', $article->slug),
            ));
        }

        return redirect()
            ->route('articles.show', $article->slug)
            ->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function follow(User $user)
    {
        $follower = auth()->user();

        if ($follower->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak bisa mengikuti diri sendiri.',
            ], 400);
        }

        if ($follower->isFollowing($user)) {
            $follower->following()->detach($user->id);
            $following = false;
        } else {
            $follower->following()->attach($user->id);
            $following = true;

            $user->notify(new InteractionNotification(
                'follow',
                $follower->name.' mulai mengikutimu.',
                route('users.show', $follower),
            ));
        }

        return response()->json([
            'success' => true,
            'following' => $following,
            'count' => $user->followers()->count(),
        ]);
    }
}
