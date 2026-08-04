<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TransaksiRepositoryInterface extends BaseRepositoryInterface
{
    public function generateKodeTransaksi(): string;

    public function search(?string $keyword, ?string $tanggalAwal, ?string $tanggalAkhir, int $perPage = 15): LengthAwarePaginator;

    /**
     * Total penjualan per tanggal, untuk grafik Chart.js.
     */
    public function totalPenjualanHarian(int $hariTerakhir = 7): SupportCollection;

    public function totalPenjualanHariIni(): int;

    public function countAll(): int;
}
