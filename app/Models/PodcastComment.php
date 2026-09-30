<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PodcastComment extends Model {
    protected $fillable = ['podcast_id','user_id','parent_id','body'];
    public function podcast(){ return $this->belongsTo(Podcast::class); }
    public function user(){ return $this->belongsTo(User::class); }
    public function parent(){ return $this->belongsTo(self::class,'parent_id'); }
    public function replies(){ return $this->hasMany(self::class,'parent_id')->oldest(); }
    public function repliesRecursive(){ return $this->replies()->with(['user','repliesRecursive']); }
}
