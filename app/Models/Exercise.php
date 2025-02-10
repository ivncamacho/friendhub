<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'exercise';
    protected $fillable = [
        'title',
        'description',
        'media',
        'youtube_video_id',
        'user_id',
    ];
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
