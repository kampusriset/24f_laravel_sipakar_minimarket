<?php

namespace Database\Seeders;

use App\Models\TrainingData;
use Illuminate\Database\Seeder;

class TrainingDataSeeder extends Seeder
{
    /**
     * Aturan bisnis dasar (pakar domain) yang menjadi acuan label pada dataset latih.
     * Kombinasi 3 atribut x 3 nilai = 27 kasus dasar. Setiap kasus digandakan
     * beberapa kali dengan sedikit noise (label berbeda dari aturan) supaya
     * pohon keputusan yang terbentuk nanti tidak sempurna 100% seperti dunia nyata,
     * dan perhitungan Entropy / Gain Ratio benar-benar bermakna.
     */
    private function labelDasar(string $penjualan, string $stok, string $expired): string
    {
        if ($expired === 'Dekat') {
            return $stok === 'Banyak' ? 'Return Supplier' : 'Diskon';
        }

        if ($penjualan === 'Tinggi') {
            return $stok === 'Banyak' ? 'Tidak Restok' : 'Restok';
        }

        if ($penjualan === 'Sedang') {
            return $stok === 'Sedikit' ? 'Restok' : 'Tidak Restok';
        }

        // Rendah
        return $stok === 'Banyak' ? 'Diskon' : 'Tidak Restok';
    }

    public function run(): void
    {
        $penjualanList = ['Tinggi', 'Sedang', 'Rendah'];
        $stokList = ['Banyak', 'Cukup', 'Sedikit'];
        $expiredList = ['Dekat', 'Sedang', 'Jauh'];
        $labelAlternatif = ['Restok', 'Tidak Restok', 'Diskon', 'Return Supplier'];

        $rows = [];

        foreach ($penjualanList as $penjualan) {
            foreach ($stokList as $stok) {
                foreach ($expiredList as $expired) {
                    $labelUtama = $this->labelDasar($penjualan, $stok, $expired);

                    // 6 baris per kombinasi, ~85% mengikuti aturan & ~15% noise
                    for ($i = 0; $i < 6; $i++) {
                        $pakaiNoise = random_int(1, 100) <= 15;
                        $label = $pakaiNoise
                            ? $labelAlternatif[array_rand($labelAlternatif)]
                            : $labelUtama;

                        $rows[] = [
                            'barang_id' => null,
                            'tingkat_penjualan' => $penjualan,
                            'sisa_stok' => $stok,
                            'masa_expired' => $expired,
                            'keputusan' => $label,
                            'is_active' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
        }

        TrainingData::truncate();

        foreach (array_chunk($rows, 100) as $chunk) {
            TrainingData::insert($chunk);
        }

        $this->command->info('Total training_data di-seed: ' . count($rows));
    }
}
