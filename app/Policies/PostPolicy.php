<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;
    public function edit(User $user, Post $post): bool
    {
        return $user->canEditPost($post);
    }
}
