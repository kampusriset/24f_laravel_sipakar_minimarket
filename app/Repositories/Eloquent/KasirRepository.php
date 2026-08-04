<?php

namespace App\Repositories\Eloquent;

use App\Models\Kasir;
use App\Repositories\Interfaces\KasirRepositoryInterface;

class KasirRepository extends BaseRepository implements KasirRepositoryInterface
{
    public function __construct(Kasir $model)
    {
        parent::__construct($model);
    }

    public function findByUserId(int $userId): ?object
    {
        return $this->model->newQuery()->where('user_id', $userId)->first();
    }

    public function generateKodeKasir(): string
    {
        $last = $this->model->newQuery()->orderByDesc('id')->value('kode_kasir');
        $nomor = $last ? ((int) substr($last, 4)) + 1 : 1;

        return 'KSR-' . str_pad((string) $nomor, 2, '0', STR_PAD_LEFT);
    }
}
