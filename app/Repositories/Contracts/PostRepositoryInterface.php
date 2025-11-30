<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    /**
     * Get posts for the feed
     */
    public function getFeedPosts(int $perPage = 10): LengthAwarePaginator;

    /**
     * Create a new post
     */
    public function createPost(array $data): \App\Models\Post;
}
