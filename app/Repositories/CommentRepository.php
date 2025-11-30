<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Contracts\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * Get comments for a post
     */
    public function getPostComments(int $postId, int $limit = 10): Collection
    {
        return Comment::where('post_id', $postId)
            ->with('user')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
