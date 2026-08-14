<?php

namespace App\Repositories\Interfaces;

interface KasirRepositoryInterface extends BaseRepositoryInterface
{
    public function findByUserId(int $userId): ?object;

    public function generateKodeKasir(): string;
}
