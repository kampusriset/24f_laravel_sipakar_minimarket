<?php

namespace App\Repositories\Eloquent;

use App\Models\Prediksi;
use App\Repositories\Interfaces\PrediksiRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PrediksiRepository extends BaseRepository implements PrediksiRepositoryInterface
{
    public function __construct(Prediksi $model)
    {
        parent::__construct($model);
    }

    public function history(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with('barang')
            ->orderByDesc('tanggal_prediksi')
            ->paginate($perPage);
    }

    public function latestByBarang(int $barangId): ?object
    {
        return $this->model->newQuery()
            ->where('barang_id', $barangId)
            ->orderByDesc('tanggal_prediksi')
            ->first();
    }

    public function rekapPerLabel(): Collection
    {
        return $this->model->newQuery()
            ->selectRaw('hasil_prediksi, COUNT(*) as total')
            ->groupBy('hasil_prediksi')
            ->get();
    }
}
