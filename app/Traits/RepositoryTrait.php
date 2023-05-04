<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait RepositoryTrait
{
    /**
     * Create a new instance of the model.
     *
     * @param  array $data
     * @return mixed
     */
    public function createModel(array $data = []): mixed
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class($data);
    }

    /**
     * Returns the model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * Runtime override of the model.
     *
     * @param string $model
     * @return $this
     */
    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Dynamically pass missing methods to the model.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        $model = $this->createModel();

        return call_user_func_array([$model, $method], $parameters);
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->model->query()->paginate();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $record = $this->getById($id);
        $record->update($attributes);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->getById($id);
        $record->delete();
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->model::search($query)->paginate();
    }
}
