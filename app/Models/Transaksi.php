<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_transaksi',
        'kasir_id',
        'tanggal_transaksi',
        'total_belanja',
        'status',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
    ];

    public function kasir()
    {
        return $this->belongsTo(Kasir::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}
