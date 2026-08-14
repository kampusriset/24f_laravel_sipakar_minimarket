<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id, array $columns = ['*']): ?object;

    public function findOrFail(int $id, array $columns = ['*']): object;

    public function create(array $data): object;

    public function update(int $id, array $data): object;

    public function delete(int $id): bool;
}
