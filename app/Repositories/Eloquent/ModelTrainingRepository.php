<?php

namespace App\Repositories\Eloquent;

use App\Models\ModelTraining;
use App\Repositories\Interfaces\ModelTrainingRepositoryInterface;

class ModelTrainingRepository extends BaseRepository implements ModelTrainingRepositoryInterface
{
    public function __construct(ModelTraining $model)
    {
        parent::__construct($model);
    }

    public function getActiveModel(): ?object
    {
        return $this->model->newQuery()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->first();
    }

    public function deactivateAll(): void
    {
        $this->model->newQuery()->where('is_active', true)->update(['is_active' => false]);
    }
}
