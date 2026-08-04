<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Katalog produk dasar nyata yang dijual di minimarket Indonesia.
     * shelf_life dalam hari (min, max) sesuai karakteristik produk.
     * Setiap produk dasar akan dibuatkan beberapa varian ukuran/kemasan
     * agar dataset mencapai + 150 baris.
     */
    private array $katalog = [
        // Sembako (KTG-01)
        ['nama' => 'Beras Ramos', 'kategori' => 'KTG-01', 'shelf' => [540, 720], 'harga' => [12000, 15000], 'varian' => ['5kg', '10kg', '25kg']],
        ['nama' => 'Gula Pasir Gulaku', 'kategori' => 'KTG-01', 'shelf' => [540, 720], 'harga' => [14000, 16000], 'varian' => ['500g', '1kg']],
        ['nama' => 'Tepung Terigu Segitiga Biru', 'kategori' => 'KTG-01', 'shelf' => [365, 540], 'harga' => [10000, 13000], 'varian' => ['500g', '1kg']],
        ['nama' => 'Minyak Goreng Bimoli', 'kategori' => 'KTG-01', 'shelf' => [540, 720], 'harga' => [16000, 38000], 'varian' => ['1L', '2L', '5L']],
        ['nama' => 'Garam Dapur Cap Kapal', 'kategori' => 'KTG-01', 'shelf' => [720, 1080], 'harga' => [3000, 5000], 'varian' => ['250g', '500g']],
        ['nama' => 'Mentega Blue Band', 'kategori' => 'KTG-01', 'shelf' => [270, 365], 'harga' => [9000, 22000], 'varian' => ['200g', '500g']],
        ['nama' => 'Kecap Manis ABC', 'kategori' => 'KTG-01', 'shelf' => [365, 540], 'harga' => [8000, 18000], 'varian' => ['135ml', '275ml', '600ml']],
        ['nama' => 'Saus Sambal ABC', 'kategori' => 'KTG-01', 'shelf' => [365, 540], 'harga' => [8000, 18000], 'varian' => ['140ml', '335ml']],
        ['nama' => 'Penyedap Rasa Royco', 'kategori' => 'KTG-01', 'shelf' => [365, 540], 'harga' => [1000, 5000], 'varian' => ['sachet', 'refill']],
        ['nama' => 'Santan Kara', 'kategori' => 'KTG-01', 'shelf' => [270, 365], 'harga' => [4000, 12000], 'varian' => ['65ml', '200ml', '1L']],
        ['nama' => 'Kopi Kapal Api', 'kategori' => 'KTG-01', 'shelf' => [365, 540], 'harga' => [1000, 15000], 'varian' => ['sachet', '165g', '400g']],
        ['nama' => 'Susu Bubuk Dancow', 'kategori' => 'KTG-01', 'shelf' => [365, 540], 'harga' => [3000, 45000], 'varian' => ['sachet', '400g', '800g']],
        ['nama' => 'Bumbu Instan Indofood', 'kategori' => 'KTG-01', 'shelf' => [270, 365], 'harga' => [3000, 6000], 'varian' => ['rendang', 'soto', 'gulai']],

        // Makanan (KTG-02)
        ['nama' => 'Indomie Goreng', 'kategori' => 'KTG-02', 'shelf' => [270, 365], 'harga' => [2800, 3200], 'varian' => ['reguler', 'jumbo']],
        ['nama' => 'Mie Sedaap Goreng', 'kategori' => 'KTG-02', 'shelf' => [270, 365], 'harga' => [2700, 3100], 'varian' => ['reguler']],
        ['nama' => 'Supermi Ayam Bawang', 'kategori' => 'KTG-02', 'shelf' => [270, 365], 'harga' => [2600, 3000], 'varian' => ['reguler']],
        ['nama' => 'Sarimi Ayam Kremes', 'kategori' => 'KTG-02', 'shelf' => [270, 365], 'harga' => [2600, 3000], 'varian' => ['reguler']],
        ['nama' => 'Pop Mie Ayam', 'kategori' => 'KTG-02', 'shelf' => [270, 365], 'harga' => [5000, 6000], 'varian' => ['cup']],
        ['nama' => 'Roti Tawar Sari Roti', 'kategori' => 'KTG-02', 'shelf' => [3, 7], 'harga' => [12000, 16000], 'varian' => ['reguler', 'gandum']],
        ['nama' => 'Roti Sobek Sari Roti', 'kategori' => 'KTG-02', 'shelf' => [3, 5], 'harga' => [10000, 14000], 'varian' => ['coklat', 'keju']],
        ['nama' => 'Biskuit Roma Kelapa', 'kategori' => 'KTG-02', 'shelf' => [180, 300], 'harga' => [7000, 12000], 'varian' => ['reguler']],
        ['nama' => 'Biskuit Oreo', 'kategori' => 'KTG-02', 'shelf' => [180, 300], 'harga' => [8000, 13000], 'varian' => ['reguler', 'family pack']],
        ['nama' => 'Chitato Snack Kentang', 'kategori' => 'KTG-02', 'shelf' => [180, 270], 'harga' => [10000, 12000], 'varian' => ['reguler']],
        ['nama' => 'Taro Net Snack', 'kategori' => 'KTG-02', 'shelf' => [180, 270], 'harga' => [7000, 9000], 'varian' => ['reguler']],
        ['nama' => 'Silverqueen Coklat', 'kategori' => 'KTG-02', 'shelf' => [270, 365], 'harga' => [12000, 18000], 'varian' => ['reguler', 'chunky']],
        ['nama' => 'Wafer Tango', 'kategori' => 'KTG-02', 'shelf' => [180, 300], 'harga' => [3000, 9000], 'varian' => ['coklat', 'keju', 'vanila']],
        ['nama' => 'Kacang Dua Kelinci', 'kategori' => 'KTG-02', 'shelf' => [180, 300], 'harga' => [6000, 11000], 'varian' => ['reguler', 'family pack']],
        ['nama' => 'Sosis Frozen Kanzler', 'kategori' => 'KTG-02', 'shelf' => [180, 360], 'harga' => [15000, 28000], 'varian' => ['sosis sapi', 'sosis ayam']],
        ['nama' => 'Nugget So Good', 'kategori' => 'KTG-02', 'shelf' => [180, 360], 'harga' => [18000, 32000], 'varian' => ['reguler', 'crispy']],

        // Minuman (KTG-03)
        ['nama' => 'Air Mineral Aqua', 'kategori' => 'KTG-03', 'shelf' => [365, 540], 'harga' => [3000, 20000], 'varian' => ['600ml', '1500ml', 'galon']],
        ['nama' => 'Air Mineral Le Minerale', 'kategori' => 'KTG-03', 'shelf' => [365, 540], 'harga' => [3000, 18000], 'varian' => ['600ml', '1500ml']],
        ['nama' => 'Susu UHT Ultra Milk', 'kategori' => 'KTG-03', 'shelf' => [180, 270], 'harga' => [6000, 18000], 'varian' => ['250ml', '1L']],
        ['nama' => 'Susu Kental Manis Indomilk', 'kategori' => 'KTG-03', 'shelf' => [270, 365], 'harga' => [10000, 12000], 'varian' => ['370g']],
        ['nama' => 'Milo Susu Coklat', 'kategori' => 'KTG-03', 'shelf' => [270, 365], 'harga' => [4000, 22000], 'varian' => ['200ml', 'kaleng 400g']],
        ['nama' => 'Floridina Jeruk', 'kategori' => 'KTG-03', 'shelf' => [180, 270], 'harga' => [4000, 6000], 'varian' => ['350ml']],
        ['nama' => 'Teh Botol Sosro', 'kategori' => 'KTG-03', 'shelf' => [180, 270], 'harga' => [4000, 6000], 'varian' => ['350ml', '450ml']],
        ['nama' => 'Pocari Sweat', 'kategori' => 'KTG-03', 'shelf' => [180, 270], 'harga' => [6000, 9000], 'varian' => ['350ml', '500ml']],
        ['nama' => 'Good Day Coffee', 'kategori' => 'KTG-03', 'shelf' => [180, 270], 'harga' => [2000, 9000], 'varian' => ['sachet', 'can 250ml']],
        ['nama' => 'Nutrisari Jeruk', 'kategori' => 'KTG-03', 'shelf' => [270, 365], 'harga' => [1000, 12000], 'varian' => ['sachet', 'kotak 10']],
        ['nama' => 'Yakult', 'kategori' => 'KTG-03', 'shelf' => [30, 45], 'harga' => [8000, 9500], 'varian' => ['botol 5', 'botol 10']],
        ['nama' => 'Cimory Susu UHT', 'kategori' => 'KTG-03', 'shelf' => [180, 270], 'harga' => [7000, 12000], 'varian' => ['200ml']],

        // Produk Pembersih (KTG-04)
        ['nama' => 'Deterjen Rinso', 'kategori' => 'KTG-04', 'shelf' => [720, 1080], 'harga' => [4000, 35000], 'varian' => ['sachet', '800g', '1.8kg']],
        ['nama' => 'Deterjen Daia', 'kategori' => 'KTG-04', 'shelf' => [720, 1080], 'harga' => [4000, 28000], 'varian' => ['sachet', '800g']],
        ['nama' => 'Deterjen So Klin', 'kategori' => 'KTG-04', 'shelf' => [720, 1080], 'harga' => [4000, 30000], 'varian' => ['sachet', '800g']],
        ['nama' => 'Pemutih Bayclin', 'kategori' => 'KTG-04', 'shelf' => [720, 1080], 'harga' => [8000, 16000], 'varian' => ['400ml', '800ml']],
        ['nama' => 'Pembersih Lantai Wipol', 'kategori' => 'KTG-04', 'shelf' => [720, 1080], 'harga' => [9000, 20000], 'varian' => ['400ml', '780ml']],
        ['nama' => 'Pembersih Lantai Super Pell', 'kategori' => 'KTG-04', 'shelf' => [720, 1080], 'harga' => [7000, 15000], 'varian' => ['400ml']],
        ['nama' => 'Pembersih Kloset Vixal', 'kategori' => 'KTG-04', 'shelf' => [720, 1080], 'harga' => [10000, 17000], 'varian' => ['400ml']],
        ['nama' => 'Pewangi Pakaian Molto', 'kategori' => 'KTG-04', 'shelf' => [720, 1080], 'harga' => [3000, 20000], 'varian' => ['sachet', '400ml', '900ml']],
        ['nama' => 'Sabun Cuci Piring Sunlight', 'kategori' => 'KTG-04', 'shelf' => [720, 1080], 'harga' => [3000, 21000], 'varian' => ['sachet', '400ml', '750ml']],

        // Perlengkapan Mandi (KTG-05)
        ['nama' => 'Sabun Lifebuoy', 'kategori' => 'KTG-05', 'shelf' => [720, 1080], 'harga' => [3000, 4000], 'varian' => ['batang', 'sachet']],
        ['nama' => 'Sabun Lux', 'kategori' => 'KTG-05', 'shelf' => [720, 1080], 'harga' => [3000, 4500], 'varian' => ['batang']],
        ['nama' => 'Sabun Mandi Cair Dove', 'kategori' => 'KTG-05', 'shelf' => [720, 1080], 'harga' => [4000, 22000], 'varian' => ['sachet', '250ml']],
        ['nama' => 'Sampo Pantene', 'kategori' => 'KTG-05', 'shelf' => [720, 1080], 'harga' => [1000, 20000], 'varian' => ['sachet', '170ml']],
        ['nama' => 'Sampo Sunsilk', 'kategori' => 'KTG-05', 'shelf' => [720, 1080], 'harga' => [1000, 18000], 'varian' => ['sachet', '170ml']],
        ['nama' => 'Sampo Clear', 'kategori' => 'KTG-05', 'shelf' => [720, 1080], 'harga' => [1000, 19000], 'varian' => ['sachet', '170ml']],
        ['nama' => 'Pasta Gigi Pepsodent', 'kategori' => 'KTG-05', 'shelf' => [720, 1080], 'harga' => [3000, 12000], 'varian' => ['75g', '190g']],
        ['nama' => 'Pasta Gigi Close Up', 'kategori' => 'KTG-05', 'shelf' => [720, 1080], 'harga' => [3000, 12000], 'varian' => ['75g', '190g']],
        ['nama' => 'Sabun Cuci Muka Ponds', 'kategori' => 'KTG-05', 'shelf' => [540, 720], 'harga' => [12000, 28000], 'varian' => ['50g', '100g']],
        ['nama' => 'Sikat Gigi Formula', 'kategori' => 'KTG-05', 'shelf' => [720, 1080], 'harga' => [5000, 9000], 'varian' => ['soft', 'medium']],
        ['nama' => 'Pembalut Charm', 'kategori' => 'KTG-05', 'shelf' => [720, 1080], 'harga' => [10000, 22000], 'varian' => ['reguler', 'maxi']],
    ];

    public function run(): void
    {
        $kategoriMap = Kategori::pluck('id', 'kode_kategori');
        $supplierIds = Supplier::pluck('id')->all();

        // Pemetaan kategori -> supplier yang relevan agar data logis
        $supplierByKategori = [
            'KTG-01' => Supplier::whereIn('kode_supplier', ['SUP-01'])->pluck('id')->all(),
            'KTG-02' => Supplier::whereIn('kode_supplier', ['SUP-01', 'SUP-05'])->pluck('id')->all(),
            'KTG-03' => Supplier::whereIn('kode_supplier', ['SUP-04', 'SUP-06', 'SUP-07'])->pluck('id')->all(),
            'KTG-04' => Supplier::whereIn('kode_supplier', ['SUP-02', 'SUP-03'])->pluck('id')->all(),
            'KTG-05' => Supplier::whereIn('kode_supplier', ['SUP-02', 'SUP-03', 'SUP-08'])->pluck('id')->all(),
        ];

        $counter = 1;
        $rows = [];
        $now = Carbon::today();

        foreach ($this->katalog as $produk) {
            $kategoriId = $kategoriMap[$produk['kategori']] ?? null;
            $suppliers = $supplierByKategori[$produk['kategori']] ?: $supplierIds;

            foreach ($produk['varian'] as $varian) {
                $kodeBarang = 'BRG-' . str_pad((string) $counter, 4, '0', STR_PAD_LEFT);
                $namaBarang = $produk['nama'] . ' ' . $varian;

                $shelfLife = random_int($produk['shelf'][0], $produk['shelf'][1]);
                $hargaBeli = random_int($produk['harga'][0], $produk['harga'][1]);
                $hargaJual = (int) round($hargaBeli * (1 + random_int(10, 30) / 100));

                // Sebagian tanggal produksi dibuat agak lama agar tercipta variasi
                // kondisi stok: ada yang masih jauh dari expired, hampir expired,
                // bahkan sudah lewat expired (untuk menguji logika AI & dashboard).
                $umurProduksi = random_int(0, (int) ($shelfLife * 1.05));
                $tanggalProduksi = $now->copy()->subDays($umurProduksi);
                $tanggalExpired = $tanggalProduksi->copy()->addDays($shelfLife);

                $stok = random_int(0, 200);
                $minimalStok = random_int(10, 30);
                $totalTerjual = random_int(0, 500);

                $rows[] = [
                    'kode_barang' => $kodeBarang,
                    'nama_barang' => $namaBarang,
                    'kategori_id' => $kategoriId,
                    'supplier_id' => $suppliers[array_rand($suppliers)],
                    'harga_beli' => $hargaBeli,
                    'harga_jual' => $hargaJual,
                    'stok' => $stok,
                    'minimal_stok' => $minimalStok,
                    'tanggal_produksi' => $tanggalProduksi->toDateString(),
                    'shelf_life_hari' => $shelfLife,
                    'tanggal_expired' => $tanggalExpired->toDateString(),
                    'total_terjual' => $totalTerjual,
                    'status_barang' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $counter++;
            }
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            Barang::upsert($chunk, ['kode_barang'], [
                'nama_barang', 'kategori_id', 'supplier_id', 'harga_beli', 'harga_jual',
                'stok', 'minimal_stok', 'tanggal_produksi', 'shelf_life_hari',
                'tanggal_expired', 'total_terjual', 'status_barang', 'updated_at',
            ]);
        }

        $this->command->info('Total barang di-seed: ' . count($rows));
    }
}
