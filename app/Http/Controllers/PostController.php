<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
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

        return redirect()->route('feed')->with('success', 'Post created successfully!');
    }
}
