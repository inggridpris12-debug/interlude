<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'path',
        'original_name',
        'mime_type',
        'file_size',
        'metadata',
        'position',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function attachable()
    {
        return $this->morphTo();
    }
}
