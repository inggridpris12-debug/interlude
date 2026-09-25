<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'download_count',
        'last_downloaded_at',
    ];

    protected $casts = [
        'last_downloaded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
