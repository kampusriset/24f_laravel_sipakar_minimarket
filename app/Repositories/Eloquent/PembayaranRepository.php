<?php

namespace App\Repositories\Eloquent;

use App\Models\Pembayaran;
use App\Repositories\Interfaces\PembayaranRepositoryInterface;

class PembayaranRepository extends BaseRepository implements PembayaranRepositoryInterface
{
    public function __construct(Pembayaran $model)
    {
        parent::__construct($model);
    }

    public function findByTransaksiId(int $transaksiId): ?object
    {
        return $this->model->newQuery()->where('transaksi_id', $transaksiId)->first();
    }
}
