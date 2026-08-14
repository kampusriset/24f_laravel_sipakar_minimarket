<?php

namespace App\Repositories\Interfaces;

interface KategoriRepositoryInterface extends BaseRepositoryInterface
{
    public function findByKode(string $kode): ?object;
}
