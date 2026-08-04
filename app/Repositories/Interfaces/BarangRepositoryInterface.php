<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BarangRepositoryInterface extends BaseRepositoryInterface
{
    public function findByKode(string $kode): ?object;

    public function search(?string $keyword, ?int $kategoriId, ?int $supplierId, int $perPage = 15): LengthAwarePaginator;

    public function lowStock(): Collection;

    public function expiringSoon(int $hari = 30): Collection;

    public function expired(): Collection;

    public function mostSold(int $limit = 10): Collection;

    public function countAll(): int;

    public function generateKodeBarang(): string;
}
