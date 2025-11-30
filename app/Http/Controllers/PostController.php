<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->postRepository->createPost($request->validated());

        return redirect('/feed')->with('success', 'Post created successfully!');
    }

    /**
     * Delete a post
     */
    public function destroy(Post $post)
    {
        // Authorization: only post owner can delete
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated images from storage
        foreach ($post->images as $image) {
            if (file_exists(public_path('storage/' . $image->url))) {
                unlink(public_path('storage/' . $image->url));
            }
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
