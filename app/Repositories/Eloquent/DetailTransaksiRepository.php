<?php

namespace App\Repositories\Eloquent;

use App\Models\DetailTransaksi;
use App\Repositories\Interfaces\DetailTransaksiRepositoryInterface;

class DetailTransaksiRepository extends BaseRepository implements DetailTransaksiRepositoryInterface
{
    public function __construct(DetailTransaksi $model)
    {
        parent::__construct($model);
    }

    public function createMany(array $rows): bool
    {
        return $this->model->newQuery()->insert($rows);
    }
}
