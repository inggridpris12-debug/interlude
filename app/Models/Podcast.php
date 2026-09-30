<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'podcast_series_id',
        'title',
        'slug',
        'description',
        'category',
        'media_type',
        'cover_image',
        'thumbnail_image',
        'media_path',
        'external_url',
        'duration_seconds',
        'episode_number',
        'transcript',
        'is_published',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'duration_seconds' => 'integer',
        'episode_number' => 'integer',
        'views_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Podcast $podcast) {

            if (!$podcast->slug) {

                $base = Str::slug($podcast->title);

                if (!$base) {
                    $base = Str::random(8);
                }

                $slug = $base;
                $counter = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $counter;
                    $counter++;
                }

                $podcast->slug = $slug;
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function series()
    {
        return $this->belongsTo(
            PodcastSeries::class,
            'podcast_series_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Likes
    |--------------------------------------------------------------------------
    */

    public function likes()
    {
        return $this->hasMany(PodcastLike::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Bookmarks
    |--------------------------------------------------------------------------
    */

    public function bookmarks()
    {
        return $this->hasMany(PodcastBookmark::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Comments
    |--------------------------------------------------------------------------
    */

    public function comments()
    {
        return $this->hasMany(PodcastComment::class);
    }

    public function rootComments()
    {
        return $this->comments()
            ->whereNull('parent_id')
            ->oldest();
    }


    /*
    |--------------------------------------------------------------------------
    | Interaction Helpers
    |--------------------------------------------------------------------------
    */

    public function isLikedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->likes()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function isBookmarkedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->bookmarks()
            ->where('user_id', $user->id)
            ->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }


    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFormattedDurationAttribute(): string
    {
        $seconds = max(
            0,
            (int) $this->duration_seconds
        );

        if ($seconds >= 3600) {

            return sprintf(
                '%d:%02d:%02d',
                intdiv($seconds, 3600),
                intdiv($seconds % 3600, 60),
                $seconds % 60
            );
        }

        return sprintf(
            '%d:%02d',
            intdiv($seconds, 60),
            $seconds % 60
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Route Model Binding
    |--------------------------------------------------------------------------
    */

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}