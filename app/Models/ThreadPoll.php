<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadPoll extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'question',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function options()
    {
        return $this->hasMany(
            ThreadPollOption::class
        )->orderBy('position');
    }

    public function votes()
    {
        return $this->hasMany(
            ThreadPollVote::class
        );
    }
}
