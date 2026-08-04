<?php

namespace App\Services;

use App\Repositories\Interfaces\KategoriRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class KategoriService
{
    public function __construct(
        protected KategoriRepositoryInterface $kategoriRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->kategoriRepository->all();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->kategoriRepository->paginate($perPage);
    }

    public function find(int $id): object
    {
        return $this->kategoriRepository->findOrFail($id);
    }

    public function create(array $data): object
    {
        return $this->kategoriRepository->create($data);
    }

    public function update(int $id, array $data): object
    {
        return $this->kategoriRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->kategoriRepository->delete($id);
    }
}
