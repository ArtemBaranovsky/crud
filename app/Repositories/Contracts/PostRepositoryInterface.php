<?php

namespace App\Repositories\Contracts;

interface PostRepositoryInterface
{
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
