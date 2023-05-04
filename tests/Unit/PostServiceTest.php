<?php

use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    private PostService $postService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postService = app(PostService::class);
    }

    public function testGetAllPosts()
    {
        $posts = $this->postService->getAllPosts();
        $this->assertInstanceOf(LengthAwarePaginator::class, $posts);
    }

    public function testGetPostById()
    {
        $post = Post::factory()->create();
        $foundPost = $this->postService->getPostById($post->id);
        $this->assertEquals($post->id, $foundPost->id);
    }

    public function testCreatePost()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $postData = [
            'title' => 'Test post',
            'content' => 'Test post content',
        ];

        $post = $this->postService->createPost($postData, $user);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Test post',
            'content' => 'Test post content',
            'user_id' => $user->id,
        ]);
    }

    public function testUpdatePost()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $postData = [
            'title' => 'Updated post',
            'content' => 'Updated post content',
        ];

        $this->postService->updatePost($post, $postData, $user);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated post',
            'content' => 'Updated post content',
            'user_id' => $user->id,
        ]);
    }

    public function testDeletePostById()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->postService->deletePostById($post->id, $user);
        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
