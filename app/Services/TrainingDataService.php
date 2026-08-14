<?php

namespace App\Services;

use App\Repositories\Interfaces\TrainingDataRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TrainingDataService
{
    public function __construct(
        protected TrainingDataRepositoryInterface $trainingDataRepository
    ) {
    }

    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->trainingDataRepository->paginate($perPage);
    }

    public function getActiveDataset(): Collection
    {
        return $this->trainingDataRepository->getActiveDataset();
    }

    public function countActive(): int
    {
        return $this->trainingDataRepository->countActive();
    }

    public function find(int $id): object
    {
        return $this->trainingDataRepository->findOrFail($id);
    }

    public function create(array $data): object
    {
        $data['is_active'] = $data['is_active'] ?? true;

        return $this->trainingDataRepository->create($data);
    }

    public function update(int $id, array $data): object
    {
        return $this->trainingDataRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->trainingDataRepository->delete($id);
    }
}
