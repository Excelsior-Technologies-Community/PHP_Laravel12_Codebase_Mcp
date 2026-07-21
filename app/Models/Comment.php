<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['post_id', 'name', 'email', 'comment', 'status'];

    protected $casts = [
        'status' => 'string',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
