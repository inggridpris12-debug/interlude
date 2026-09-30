<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_photo',
        'profile_avatar_preset',
        'cover_image',
        'cover_preset',
        'university',
        'major',
        'location',
        'bio',
        'show_likes_on_profile',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'show_likes_on_profile' => 'boolean',
        ];
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function podcasts()
    {
        return $this->hasMany(Podcast::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'following_id',
            'follower_id'
        )->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',
            'following_id'
        )->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function articleViews()
    {
        return $this->hasMany(ArticleView::class);
    }

    public function articleDownloads()
    {
        return $this->hasMany(ArticleDownload::class);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function threadLikes()
    {
        return $this->hasMany(ThreadLike::class);
    }

    public function threadBookmarks()
    {
        return $this->hasMany(ThreadBookmark::class);
    }

    public function threadReplies()
    {
        return $this->hasMany(ThreadReply::class);
    }

    public function pollVotes()
    {
        return $this->hasMany(ThreadPollVote::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function isFollowing($user)
    {
        if (! $user) {
            return false;
        }

        return $this->following()
            ->where('following_id', $user->id)
            ->exists();
    }

    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

    public function getFollowingCountAttribute()
    {
        return $this->following()->count();
    }
}
