<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body',
        'topic',
        'visibility',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(ThreadLike::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(ThreadBookmark::class);
    }

    public function replies()
    {
        return $this->hasMany(ThreadReply::class);
    }

    public function topLevelReplies()
    {
        return $this->hasMany(ThreadReply::class)
            ->whereNull('parent_id')
            ->with([
                'user',
                'childrenRecursive',
            ])
            ->oldest();
    }

    public function isLikedBy($user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->likes()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function isBookmarkedBy($user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->bookmarks()
            ->where('user_id', $user->id)
            ->exists();
    }
}
