<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $excerpt
 * @property string $content
 * @property string $category
 * @property string $slug
 * @property string|null $cover_image
 * @property int $reading_time
 * @property int $views_count
 * @property bool $is_published
 * @property bool $is_featured
 * @property Carbon|null $published_at
 * @property-read User $user
 * @property-read Collection<int, Comment> $comments
 * @property-read Collection<int, Like> $likes
 * @property-read Collection<int, Bookmark> $bookmarks
 * @property-read int $likes_count
 * @property-read int $comments_count
 */
class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'excerpt',
        'content',
        'category',
        'slug',
        'cover_image',
        'reading_time',
        'is_published',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function viewRecords()
    {
        return $this->hasMany(ArticleView::class);
    }

    public function downloadRecords()
    {
        return $this->hasMany(ArticleDownload::class);
    }

    public function isLikedBy($user)
    {
        if (! $user) {
            return false;
        }

        return $this->likes()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function isBookmarkedBy($user)
    {
        if (! $user) {
            return false;
        }

        return $this->bookmarks()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title).'-'.Str::random(6);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
