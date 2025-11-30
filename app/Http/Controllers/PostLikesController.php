<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostLikesController extends Controller
{
    /**
     * Get users who liked a post
     */
    public function index(Post $post)
    {
        $likes = $post->likes()
            ->with('user:id,username,name,avatar')
            ->latest()
            ->get()
            ->map(function ($like) {
                return [
                    'id' => $like->user->id,
                    'username' => $like->user->username,
                    'name' => $like->user->name,
                    'avatar' => $like->user->avatar ? asset('storage/'.$like->user->avatar) : null,
                ];
            });

        return response()->json($likes);
    }
}
