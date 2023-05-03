<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
