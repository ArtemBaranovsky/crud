<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostService
{
    private PostRepositoryInterface                    $postRepository;
    private LoggerService                              $logger;
    public function __construct(PostRepositoryInterface $postRepository, LoggerService $logger)
    {
        $this->postRepository = $postRepository;
        $this->logger         = $logger;
    }

    /**
     * Get all posts.
     *
     * @return Collection
     */
    public function getAllPosts(): LengthAwarePaginator
    {
        return $this->postRepository->getAll();
    }

    /**
     * Get post by id.
     *
     * @param string $id
     * @return Post
     */
    public function getPostById(string $id): Post
    {
        return $this->postRepository->getById($id);
    }

    /**
     * Create a new post.
     *
     * @param array $postData
     * @param Authenticatable $user
     * @return Post
     */
    public function createPost(array $postData, Authenticatable $user): Post
    {
        $postData = array_merge($postData, ['user_id' => $user->id]);
        $post     = $this->postRepository->create($postData);
        $this->logger->info('Created new post', ['post_id' => $post->id, 'user_id' => $user->id]);

        return $post;
    }

    /**
     * Update the specified post.
     *
     * @param Post $post
     * @param array $postData
     * @param Authenticatable $user
     * @return void
     */
    public function updatePost(Post $post, array $postData, Authenticatable $user): void
    {
        $postData = array_merge($postData, ['user_id' => $user->id]);
        $post     = $this->postRepository->update($post->id, $postData);
        $this->logger->info("Post updated", ['post_id' => $post->id, 'user_id' => $user->id]);

    }

    /**
     * Delete the specified post.
     *
     * @param string $id
     * @param Authenticatable $user
     * @return void
     */
    public function deletePostById(string $id, Authenticatable $user): void
    {
        $this->postRepository->delete($id);
        $this->logger->info("Post updated", ['post_id' => $id, 'user_id' => $user->id]);
    }
}
