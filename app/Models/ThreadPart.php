<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'body',
        'position',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
