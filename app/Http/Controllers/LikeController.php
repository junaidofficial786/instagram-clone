<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Like a post
     */
    public function store(Request $request, Post $post)
    {
        $user = $request->user();

        // Check if already liked
        if ($post->isLikedBy($user->id)) {
            return response()->json(['message' => 'Already liked'], 400);
        }

        $post->likes()->create([
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Post liked',
            'likes_count' => $post->likes()->count(),
        ]);
    }

    /**
     * Unlike a post
     */
    public function destroy(Request $request, Post $post)
    {
        $user = $request->user();

        $post->likes()
            ->where('user_id', $user->id)
            ->delete();

        return response()->json([
            'message' => 'Post unliked',
            'likes_count' => $post->likes()->count(),
        ]);
    }
}
