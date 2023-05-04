<?php

namespace App\Http\Controllers;

use App\Http\Livewire\DataTable;
use App\Http\Livewire\PostTable;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;

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
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $modelClass = \App\Models\Post::class;
        $posts = $this->postService->getAllPosts();
        $headers = ['Id', 'Title', 'Created at', 'Author'];

        return view('posts.index', compact(['posts', 'headers', 'modelClass']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $id): \Illuminate\Contracts\View\View
    {
        $post = $this->postService->getPostById($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(string $id): \Illuminate\Contracts\View\View
    {
        $post = $this->postService->getPostById($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Post $post
     * @param PostRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $this->postService->deletePostById($id, auth()->user());

        return redirect()->route('posts.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPostData(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Post::select(['id', 'title', 'content', 'created_at']);

        if ($request->filled('search.value')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->input('search.value').'%')
                    ->orWhere('content', 'like', '%'.$request->input('search.value').'%');
            });
        }

        if ($request->filled('order.0.column')) {
            $orderByColumn = $request->input('columns.'.$request->input('order.0.column').'.data');
            $orderByDirection = $request->input('order.0.dir');
            $query->orderBy($orderByColumn, $orderByDirection);
        }

        $totalRecords = $query->count();

        $query->offset($request->input('start'))
            ->limit($request->input('length'));

        $posts = $query->get();

        $data = [];
        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                'actions' => view('posts.actions', ['post' => $post])->render(),
            ];
        }

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }

}
