<?php

namespace App\Repositories\Interfaces;

interface SupplierRepositoryInterface extends BaseRepositoryInterface
{
    public function findByKode(string $kode): ?object;
}
