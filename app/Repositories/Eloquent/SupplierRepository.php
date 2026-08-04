<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierRepository extends BaseRepository implements SupplierRepositoryInterface
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }

    public function findByKode(string $kode): ?object
    {
        return $this->model->newQuery()->where('kode_supplier', $kode)->first();
    }
}
