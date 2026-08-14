<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface TrainingDataRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Ambil seluruh data latih yang aktif (dipakai saat training model).
     */
    public function getActiveDataset(): Collection;

    public function countActive(): int;
}
