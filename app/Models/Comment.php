<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id', 'post_id'];

    public function post(): belongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
