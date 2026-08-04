<?php

namespace App\Repositories\Eloquent;

use App\Models\Kategori;
use App\Repositories\Interfaces\KategoriRepositoryInterface;

class KategoriRepository extends BaseRepository implements KategoriRepositoryInterface
{
    public function __construct(Kategori $model)
    {
        parent::__construct($model);
    }

    public function findByKode(string $kode): ?object
    {
        return $this->model->newQuery()->where('kode_kategori', $kode)->first();
    }
}
