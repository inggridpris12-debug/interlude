<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadPollVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_poll_id',
        'thread_poll_option_id',
        'user_id',
    ];

    public function poll()
    {
        return $this->belongsTo(
            ThreadPoll::class,
            'thread_poll_id'
        );
    }

    public function option()
    {
        return $this->belongsTo(
            ThreadPollOption::class,
            'thread_poll_option_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
