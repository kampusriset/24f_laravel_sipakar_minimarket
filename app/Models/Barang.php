<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'supplier_id',
        'harga_beli',
        'harga_jual',
        'stok',
        'minimal_stok',
        'tanggal_produksi',
        'shelf_life_hari',
        'tanggal_expired',
        'total_terjual',
        'status_barang',
    ];

    protected $casts = [
        'tanggal_produksi' => 'date',
        'tanggal_expired' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function prediksis()
    {
        return $this->hasMany(Prediksi::class);
    }

    /**
     * Sisa hari menuju tanggal_expired. Bisa negatif jika sudah lewat.
     */
    public function getSisaHariExpiredAttribute(): int
    {
        return (int) Carbon::today()->diffInDays($this->tanggal_expired, false);
    }

    /**
     * Status expired praktis untuk ditampilkan di UI & dipakai dashboard.
     * kadaluarsa    : sudah lewat tanggal_expired
     * hampir_expired: sisa <= 30 hari
     * aman          : selebihnya
     */
    public function getStatusExpiredAttribute(): string
    {
        $sisa = $this->sisa_hari_expired;

        if ($sisa < 0) {
            return 'kadaluarsa';
        }

        if ($sisa <= 30) {
            return 'hampir_expired';
        }

        return 'aman';
    }
}
