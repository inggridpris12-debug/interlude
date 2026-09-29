<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','podcast_series_id','title','slug','description','category',
        'media_type','cover_image','thumbnail_image','media_path','external_url',
        'duration_seconds','episode_number','transcript','is_published',
        'published_at','views_count'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'duration_seconds' => 'integer',
        'views_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Podcast $podcast) {
            if (!$podcast->slug) {
                $base = Str::slug($podcast->title) ?: Str::random(8);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $podcast->slug = $slug;
            }
        });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function series() {
        return $this->belongsTo(PodcastSeries::class, 'podcast_series_id');
    }

    public function scopePublished($query) {
        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getFormattedDurationAttribute(): string
    {
        $seconds = max(0, (int) $this->duration_seconds);
        return $seconds >= 3600
            ? sprintf('%d:%02d:%02d', intdiv($seconds,3600), intdiv($seconds%3600,60), $seconds%60)
            : sprintf('%d:%02d', intdiv($seconds,60), $seconds%60);
    }

    public function getRouteKeyName(): string {
        return 'slug';
    }
}
