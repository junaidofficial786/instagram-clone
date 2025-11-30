<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Get all comments for a post
     */
    public function index(Post $post)
    {
        $comments = $post->comments()
            ->with('user:id,username,name,avatar')
            ->latest()
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user' => [
                        'id' => $comment->user->id,
                        'username' => $comment->user->username,
                        'name' => $comment->user->name,
                        'avatar' => $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : null,
                    ],
                ];
            });

        return response()->json($comments);
    }

    /**
     * Store a new comment
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:2200',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        $comment->load('user:id,username,name,avatar');

        return response()->json([
            'id' => $comment->id,
            'content' => $comment->content,
            'created_at' => $comment->created_at->diffForHumans(),
            'user' => [
                'id' => $comment->user->id,
                'username' => $comment->user->username,
                'name' => $comment->user->name,
                'avatar' => $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : null,
            ],
        ]);
    }
}
