<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PrediksiRepositoryInterface extends BaseRepositoryInterface
{
    public function history(int $perPage = 15): LengthAwarePaginator;

    public function latestByBarang(int $barangId): ?object;

    /**
     * Rekap jumlah prediksi per label keputusan, untuk grafik Chart.js.
     */
    public function rekapPerLabel(): Collection;
}
