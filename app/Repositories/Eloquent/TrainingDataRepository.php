<?php

namespace App\Repositories\Eloquent;

use App\Models\TrainingData;
use App\Repositories\Interfaces\TrainingDataRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TrainingDataRepository extends BaseRepository implements TrainingDataRepositoryInterface
{
    public function __construct(TrainingData $model)
    {
        parent::__construct($model);
    }

    public function getActiveDataset(): Collection
    {
        return $this->model->newQuery()->where('is_active', true)->get();
    }

    public function countActive(): int
    {
        return $this->model->newQuery()->where('is_active', true)->count();
    }
}
