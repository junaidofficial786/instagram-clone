<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    /**
     * Get posts for the feed
     */
    public function getFeedPosts(int $perPage = 10): LengthAwarePaginator;
}
