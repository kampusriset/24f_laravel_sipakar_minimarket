<?php

namespace App\Services;

use App\Repositories\Interfaces\PembayaranRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PembayaranService
{
    public function __construct(
        protected PembayaranRepositoryInterface $pembayaranRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->pembayaranRepository->all();
    }

    public function findByTransaksi(int $transaksiId): ?object
    {
        return $this->pembayaranRepository->findByTransaksiId($transaksiId);
    }
}
