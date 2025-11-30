<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'caption',
        'location',
        'hide_likes',
        'hide_comments',
    ];

    protected $casts = [
        'hide_likes' => 'boolean',
        'hide_comments' => 'boolean',
    ];

    /**
     * Get the user that owns the post
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all images for the post
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get all comments for the post
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
