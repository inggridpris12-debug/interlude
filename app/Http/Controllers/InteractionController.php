<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function like(Article $article)
    {
        $user = auth()->user();

        if ($article->isLikedBy($user)) {
            // Unlike
            $article->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            // Like
            $article->likes()->create(['user_id' => $user->id]);
            $liked = true;
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
            // Remove bookmark
            $article->bookmarks()->where('user_id', $user->id)->delete();
            $bookmarked = false;
        } else {
            // Add bookmark
            $article->bookmarks()->create(['user_id' => $user->id]);
            $bookmarked = true;
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
        ]);
    }

    public function follow(User $user)
    {
        $follower = auth()->user();

        // Can't follow yourself
        if ($follower->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak bisa mengikuti diri sendiri.',
            ], 400);
        }

        if ($follower->isFollowing($user)) {
            // Unfollow
            $follower->following()->detach($user->id);
            $following = false;
        } else {
            // Follow
            $follower->following()->attach($user->id);
            $following = true;
        }

        return response()->json([
            'success' => true,
            'following' => $following,
            'count' => $user->followers()->count(),
        ]);
    }
}