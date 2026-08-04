<?php

namespace App\Services;

use App\Repositories\Interfaces\SupplierRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SupplierService
{
    public function __construct(
        protected SupplierRepositoryInterface $supplierRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->supplierRepository->all();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->supplierRepository->paginate($perPage);
    }

    public function find(int $id): object
    {
        return $this->supplierRepository->findOrFail($id);
    }

    public function create(array $data): object
    {
        return $this->supplierRepository->create($data);
    }

    public function update(int $id, array $data): object
    {
        return $this->supplierRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->supplierRepository->delete($id);
    }
}
