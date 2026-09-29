<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodcastSeries extends Model
{
    use HasFactory;

    protected $table = 'podcast_series';

    protected $fillable = [
        'user_id','title','slug','description','cover_image',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function episodes() {
        return $this->hasMany(Podcast::class, 'podcast_series_id');
    }

    public function getRouteKeyName(): string {
        return 'slug';
    }
}
