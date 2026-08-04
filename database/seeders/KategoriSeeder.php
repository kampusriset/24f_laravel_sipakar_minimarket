<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_kategori' => 'KTG-01', 'nama_kategori' => 'Sembako', 'keterangan' => 'Kebutuhan pokok sehari-hari seperti beras, gula, minyak goreng'],
            ['kode_kategori' => 'KTG-02', 'nama_kategori' => 'Makanan', 'keterangan' => 'Mie instan, roti, biskuit, snack, dan makanan ringan lainnya'],
            ['kode_kategori' => 'KTG-03', 'nama_kategori' => 'Minuman', 'keterangan' => 'Air mineral, susu, minuman kemasan, dan minuman kesehatan'],
            ['kode_kategori' => 'KTG-04', 'nama_kategori' => 'Produk Pembersih', 'keterangan' => 'Deterjen, pembersih lantai, dan pemutih pakaian'],
            ['kode_kategori' => 'KTG-05', 'nama_kategori' => 'Perlengkapan Mandi', 'keterangan' => 'Sabun, sampo, dan pasta gigi'],
        ];

        foreach ($data as $row) {
            Kategori::updateOrCreate(['kode_kategori' => $row['kode_kategori']], $row);
        }
    }
}
