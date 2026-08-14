<?php

namespace App\Repositories\Interfaces;

interface DetailTransaksiRepositoryInterface extends BaseRepositoryInterface
{
    public function createMany(array $rows): bool;
}
