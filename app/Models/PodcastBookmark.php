<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PodcastBookmark extends Model {
    protected $fillable = ['podcast_id','user_id'];
    public function podcast(){ return $this->belongsTo(Podcast::class); }
    public function user(){ return $this->belongsTo(User::class); }
}
