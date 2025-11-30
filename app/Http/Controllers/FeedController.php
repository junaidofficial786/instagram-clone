<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FeedController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    /**
     * Display the feed.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        $posts = $this->postRepository->getFeedPosts();

        // Transform posts for frontend if needed, or pass as is if models are sufficient
        // We'll pass them and let Inertia/Vue handle the structure, 
        // but we might need to map them to match the exact expected prop structure if we don't change Vue enough.
        // For now, let's pass the paginated object.

        return Inertia::render('Feed', [
            'currentUser' => [
                'username' => $user->username,
                'name' => $user->name,
                'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : null,
            ],
            'posts' => $posts,
        ]);
    }
}
