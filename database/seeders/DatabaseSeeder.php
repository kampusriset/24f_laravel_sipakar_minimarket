<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Urutan WAJIB seperti ini karena ada foreign key:
     * Kategori & Supplier -> Barang, User -> Kasir.
     * TrainingData tidak bergantung pada Barang (barang_id nullable)
     * sehingga aman dijalankan kapan saja setelah migrate.
     */
    public function run(): void
    {
        $this->call([
            KategoriSeeder::class,
            SupplierSeeder::class,
            UserSeeder::class,
            BarangSeeder::class,
            TrainingDataSeeder::class,
        ]);
    }
}
