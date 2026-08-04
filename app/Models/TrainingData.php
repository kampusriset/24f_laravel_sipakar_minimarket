<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingData extends Model
{
    use HasFactory;

    protected $table = 'training_data';

    protected $fillable = [
        'barang_id',
        'tingkat_penjualan',
        'sisa_stok',
        'masa_expired',
        'keputusan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
