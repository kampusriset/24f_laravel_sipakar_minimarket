<?php

namespace App\Repositories\Interfaces;

interface ModelTrainingRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Ambil model (pohon keputusan) yang sedang aktif dipakai untuk prediksi.
     */
    public function getActiveModel(): ?object;

    /**
     * Nonaktifkan semua model lama, dipanggil sebelum menyimpan model baru
     * agar hanya ada satu model aktif pada satu waktu.
     */
    public function deactivateAll(): void;
}
