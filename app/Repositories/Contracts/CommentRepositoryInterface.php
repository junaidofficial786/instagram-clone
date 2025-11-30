<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    /**
     * Get comments for a post
     */
    public function getPostComments(int $postId, int $limit = 10): Collection;
}
