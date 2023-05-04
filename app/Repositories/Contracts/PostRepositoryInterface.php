<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getAll(): LengthAwarePaginator;
    public function search(string $query): LengthAwarePaginator;
}
