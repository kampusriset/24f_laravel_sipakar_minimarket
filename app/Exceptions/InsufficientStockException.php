<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(string $namaBarang, int $stokTersedia, int $qtyDiminta)
    {
        parent::__construct(
            "Stok tidak mencukupi untuk barang \"{$namaBarang}\". Stok tersedia: {$stokTersedia}, diminta: {$qtyDiminta}."
        );
    }
}
