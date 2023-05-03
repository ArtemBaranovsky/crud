<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        parent::__construct();
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $posts = $this->postService->getAllPosts();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $postData = [
            'title'   => $request->input('title'),
            'content' => $request->input('content'),
        ];

        $post = $this->postService->createPost($postData, auth()->user());

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Contracts\View\View
    {
        $post = $this->postService->getPostById($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): \Illuminate\Contracts\View\View
    {
        $post = $this->postService->getPostById($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Post $post, PostRequest $request): \Illuminate\Http\RedirectResponse
    {
        $postData = array_filter([
            'title'   => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        $this->postService->updatePost($post, $postData, auth()->user());

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $this->postService->deletePostById($id, auth()->user());

        return redirect()->route('posts.index');
    }
}
