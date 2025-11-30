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
    public function index(Request $request): Response|\Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $posts = $this->postRepository->getFeedPosts(7);

        if ($request->wantsJson() && !$request->inertia()) {
            return response()->json($posts);
        }

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
