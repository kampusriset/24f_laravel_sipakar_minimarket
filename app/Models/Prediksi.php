<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'tingkat_penjualan',
        'sisa_stok',
        'masa_expired',
        'hasil_prediksi',
        'tree_path',
        'tanggal_prediksi',
    ];

    protected $casts = [
        'tree_path' => 'array',
        'tanggal_prediksi' => 'datetime',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
