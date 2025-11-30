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
        $userId = auth()->id();

        return Post::with([
            'user',
            'images',
            'comments' => function ($query) {
                $query->latest()->limit(3); // Get only recent 3 comments for preview
            },
            'comments.user',
        ])
            ->withCount('likes')
            ->latest()
            ->paginate($perPage)
            ->through(function ($post) use ($userId) {
                $post->is_liked_by_current_user = $post->isLikedBy($userId);
                $post->is_own_post = $post->user_id === $userId;
                return $post;
            });
    }

    /**
     * Create a new post
     */
    public function createPost(array $data): Post
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($data) {
            $post = Post::create([
                'user_id' => auth()->id(),
                'caption' => $data['caption'] ?? null,
                'location' => $data['location'] ?? null,
                'hide_likes' => false,
                'hide_comments' => false,
            ]);

            if (isset($data['images'])) {
                foreach ($data['images'] as $index => $imageFile) {
                    $path = $imageFile->store('posts', 'public');

                    $post->images()->create([
                        'url' => $path,
                        'type' => 'image',
                        'order' => $index,
                    ]);
                }
            }

            return $post;
        });
    }
}
