<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\Eloquent\PostRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;


class PostController extends Controller
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $posts = $this->postRepository->getAll();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View
    {
//        dd(auth()->id());
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // add validation
        $userId = auth()->id();
        $postData = $request->all();
        $postData = array_merge($postData, ['user_id' => $userId]);
//        dd($postData);
        $post = $this->postRepository->create($postData);

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): \Illuminate\Contracts\View\View
    {
        $post = $this->postRepository->getById($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): \Illuminate\Contracts\View\View
    {
        $post = $this->postRepository->getById($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Post $post, Request $request): \Illuminate\Http\RedirectResponse
    {

        // add validation
        $userId = auth()->id();
        $postData = $request->all();
        $postData = array_merge($postData, ['user_id' => $userId]);

        $this->postRepository->update($post->id, $postData);

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $this->postRepository->delete($id);

        return redirect()->route('posts.index');
    }
}
