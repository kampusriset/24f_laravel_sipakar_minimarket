<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->newQuery()->get($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->newQuery()->paginate($perPage, $columns);
    }

    public function find(int $id, array $columns = ['*']): ?object
    {
        return $this->model->newQuery()->find($id, $columns);
    }

    public function findOrFail(int $id, array $columns = ['*']): object
    {
        return $this->model->newQuery()->findOrFail($id, $columns);
    }

    public function create(array $data): object
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(int $id, array $data): object
    {
        $record = $this->findOrFail($id);
        $record->update($data);

        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = $this->findOrFail($id);

        return (bool) $record->delete();
    }
}
