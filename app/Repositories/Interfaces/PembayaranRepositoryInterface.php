<?php

namespace App\Repositories\Interfaces;

interface PembayaranRepositoryInterface extends BaseRepositoryInterface
{
    public function findByTransaksiId(int $transaksiId): ?object;
}
