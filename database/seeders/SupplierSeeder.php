<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_supplier' => 'SUP-01', 'nama_supplier' => 'PT Indofood Sukses Makmur', 'kontak' => '021-5795-8822', 'email' => 'distribusi@indofood.co.id', 'alamat' => 'Jakarta'],
            ['kode_supplier' => 'SUP-02', 'nama_supplier' => 'PT Unilever Indonesia', 'kontak' => '021-8991-9999', 'email' => 'sales@unilever.co.id', 'alamat' => 'Tangerang'],
            ['kode_supplier' => 'SUP-03', 'nama_supplier' => 'PT Wings Surya', 'kontak' => '031-843-0000', 'email' => 'order@wings.co.id', 'alamat' => 'Surabaya'],
            ['kode_supplier' => 'SUP-04', 'nama_supplier' => 'PT Danone Indonesia', 'kontak' => '021-2995-0000', 'email' => 'cs@danone.co.id', 'alamat' => 'Jakarta'],
            ['kode_supplier' => 'SUP-05', 'nama_supplier' => 'PT Mayora Indah', 'kontak' => '021-565-5311', 'email' => 'order@mayora.co.id', 'alamat' => 'Tangerang'],
            ['kode_supplier' => 'SUP-06', 'nama_supplier' => 'PT Ultrajaya Milk Industry', 'kontak' => '022-667-0700', 'email' => 'sales@ultrajaya.co.id', 'alamat' => 'Bandung'],
            ['kode_supplier' => 'SUP-07', 'nama_supplier' => 'PT Sinar Sosro', 'kontak' => '021-8990-2500', 'email' => 'order@sosro.co.id', 'alamat' => 'Bekasi'],
            ['kode_supplier' => 'SUP-08', 'nama_supplier' => 'PT Kalbe Farma', 'kontak' => '021-4287-3888', 'email' => 'distribusi@kalbe.co.id', 'alamat' => 'Jakarta'],
        ];

        foreach ($data as $row) {
            Supplier::updateOrCreate(['kode_supplier' => $row['kode_supplier']], $row);
        }
    }
}
