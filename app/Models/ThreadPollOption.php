<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadPollOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_poll_id',
        'label',
        'position',
    ];

    public function poll()
    {
        return $this->belongsTo(
            ThreadPoll::class,
            'thread_poll_id'
        );
    }

    public function votes()
    {
        return $this->hasMany(
            ThreadPollVote::class,
            'thread_poll_option_id'
        );
    }
}
