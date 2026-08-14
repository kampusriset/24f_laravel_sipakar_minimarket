<?php

namespace App\Services;

use App\Models\Barang;
use App\Repositories\Interfaces\BarangRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class BarangService
{
    /**
     * Ambang batas diskritisasi atribut numerik menjadi kategori,
     * dipakai baik saat membangun training_data maupun saat prediksi (Fase 5),
     * supaya keduanya konsisten menggunakan aturan yang sama.
     */
    private const BATAS_PENJUALAN_TINGGI = 150;
    private const BATAS_PENJUALAN_SEDANG = 50;

    private const BATAS_EXPIRED_DEKAT = 30;
    private const BATAS_EXPIRED_SEDANG = 90;

    public function __construct(
        protected BarangRepositoryInterface $barangRepository
    ) {
    }

    public function getPaginated(?string $keyword, ?int $kategoriId, ?int $supplierId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->barangRepository->search($keyword, $kategoriId, $supplierId, $perPage);
    }

    public function find(int $id): object
    {
        return $this->barangRepository->findOrFail($id);
    }

    /**
     * Membuat barang baru. Kode barang di-generate otomatis, dan
     * tanggal_expired WAJIB dihitung dari tanggal_produksi + shelf_life_hari
     * (tidak boleh diinput manual sebagai tanggal bebas).
     */
    public function create(array $data): object
    {
        $data['kode_barang'] = $this->barangRepository->generateKodeBarang();
        $data['tanggal_expired'] = $this->hitungTanggalExpired(
            $data['tanggal_produksi'],
            (int) $data['shelf_life_hari']
        );
        $data['total_terjual'] = $data['total_terjual'] ?? 0;
        $data['status_barang'] = $data['status_barang'] ?? 'aktif';

        return $this->barangRepository->create($data);
    }

    public function update(int $id, array $data): object
    {
        if (isset($data['tanggal_produksi'], $data['shelf_life_hari'])) {
            $data['tanggal_expired'] = $this->hitungTanggalExpired(
                $data['tanggal_produksi'],
                (int) $data['shelf_life_hari']
            );
        }

        return $this->barangRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->barangRepository->delete($id);
    }

    private function hitungTanggalExpired(string $tanggalProduksi, int $shelfLifeHari): string
    {
        return Carbon::parse($tanggalProduksi)->addDays($shelfLifeHari)->toDateString();
    }

    // ================= Dashboard & Laporan =================

    public function countAll(): int
    {
        return $this->barangRepository->countAll();
    }

    public function getLowStock(): Collection
    {
        return $this->barangRepository->lowStock();
    }

    public function getExpiringSoon(int $hari = 30): Collection
    {
        return $this->barangRepository->expiringSoon($hari);
    }

    public function getExpired(): Collection
    {
        return $this->barangRepository->expired();
    }

    public function getMostSold(int $limit = 10): Collection
    {
        return $this->barangRepository->mostSold($limit);
    }

    // ================= Dipakai oleh mesin AI (Fase 5) =================

    /**
     * Mengubah atribut numerik sebuah Barang menjadi atribut kategorikal
     * (Tinggi/Sedang/Rendah, Banyak/Cukup/Sedikit, Dekat/Sedang/Jauh)
     * agar bisa dipakai sebagai input Decision Tree C4.5.
     */
    public function diskritisasiAtribut(Barang $barang): array
    {
        return [
            'tingkat_penjualan' => $this->kategoriPenjualan($barang->total_terjual),
            'sisa_stok' => $this->kategoriStok($barang->stok, $barang->minimal_stok),
            'masa_expired' => $this->kategoriExpired($barang->sisa_hari_expired),
        ];
    }

    private function kategoriPenjualan(int $totalTerjual): string
    {
        if ($totalTerjual >= self::BATAS_PENJUALAN_TINGGI) {
            return 'Tinggi';
        }

        if ($totalTerjual >= self::BATAS_PENJUALAN_SEDANG) {
            return 'Sedang';
        }

        return 'Rendah';
    }

    private function kategoriStok(int $stok, int $minimalStok): string
    {
        if ($stok <= $minimalStok) {
            return 'Sedikit';
        }

        if ($stok <= $minimalStok * 3) {
            return 'Cukup';
        }

        return 'Banyak';
    }

    private function kategoriExpired(int $sisaHari): string
    {
        if ($sisaHari <= self::BATAS_EXPIRED_DEKAT) {
            return 'Dekat';
        }

        if ($sisaHari <= self::BATAS_EXPIRED_SEDANG) {
            return 'Sedang';
        }

        return 'Jauh';
    }
}
