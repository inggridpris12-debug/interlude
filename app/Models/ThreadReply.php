<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'user_id',
        'parent_id',
        'body',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(
            ThreadReply::class,
            'parent_id'
        );
    }

    public function children()
    {
        return $this->hasMany(
            ThreadReply::class,
            'parent_id'
        )->oldest();
    }

    public function childrenRecursive()
    {
        return $this->hasMany(
            ThreadReply::class,
            'parent_id'
        )
            ->with([
                'user',
                'childrenRecursive',
            ])
            ->oldest();
    }
}
