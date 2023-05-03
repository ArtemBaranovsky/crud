<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Traits\RepositoryTrait;

class UserRepository implements UserRepositoryInterface
{
    use RepositoryTrait;

    /**
     * The Eloquent user model name.
     *
     * @var string
     */
    protected $model = User::class;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
