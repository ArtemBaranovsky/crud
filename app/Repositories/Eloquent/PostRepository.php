<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Traits\RepositoryTrait;

class PostRepository implements PostRepositoryInterface
{
    use RepositoryTrait;

    /**
     * The Eloquent user model name.
     *
     * @var string
     */
    protected $model = Post::class;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }
}
