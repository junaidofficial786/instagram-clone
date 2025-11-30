<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Get posts for the feed
     */
    public function getFeedPosts(int $perPage = 10): LengthAwarePaginator
    {
        return Post::with([
            'user',
            'images',
            'comments' => function ($query) {
                $query->latest()->limit(3); // Get only recent 3 comments for preview
            },
            'comments.user'
        ])
        ->latest()
        ->paginate($perPage);
    }
}
