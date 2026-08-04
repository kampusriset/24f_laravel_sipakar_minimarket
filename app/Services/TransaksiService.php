<?php

namespace App\Services;

use App\Exceptions\InsufficientStockException;
use App\Repositories\Interfaces\BarangRepositoryInterface;
use App\Repositories\Interfaces\DetailTransaksiRepositoryInterface;
use App\Repositories\Interfaces\PembayaranRepositoryInterface;
use App\Repositories\Interfaces\TransaksiRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

class TransaksiService
{
    public function __construct(
        protected TransaksiRepositoryInterface $transaksiRepository,
        protected DetailTransaksiRepositoryInterface $detailTransaksiRepository,
        protected PembayaranRepositoryInterface $pembayaranRepository,
        protected BarangRepositoryInterface $barangRepository,
    ) {
    }

    public function getPaginated(?string $keyword, ?string $tanggalAwal, ?string $tanggalAkhir, int $perPage = 15): LengthAwarePaginator
    {
        return $this->transaksiRepository->search($keyword, $tanggalAwal, $tanggalAkhir, $perPage);
    }

    public function find(int $id): object
    {
        return $this->transaksiRepository->findOrFail($id);
    }

    /**
     * Membuat transaksi baru beserta detail item & pembayaran.
     *
     * @param int $kasirId
     * @param array $items  [['barang_id' => int, 'qty' => int], ...]
     * @param string $metodePembayaran  tunai|debit|qris
     * @param int $jumlahBayar
     *
     * @throws InsufficientStockException
     */
    public function createTransaksi(int $kasirId, array $items, string $metodePembayaran, int $jumlahBayar): object
    {
        return DB::transaction(function () use ($kasirId, $items, $metodePembayaran, $jumlahBayar) {
            $totalBelanja = 0;
            $detailRows = [];
            $now = now();

            $transaksi = $this->transaksiRepository->create([
                'kode_transaksi' => $this->transaksiRepository->generateKodeTransaksi(),
                'kasir_id' => $kasirId,
                'tanggal_transaksi' => $now,
                'total_belanja' => 0,
                'status' => 'selesai',
            ]);

            foreach ($items as $item) {
                $barang = $this->barangRepository->findOrFail($item['barang_id']);
                $qty = (int) $item['qty'];

                if ($barang->stok < $qty) {
                    throw new InsufficientStockException($barang->nama_barang, $barang->stok, $qty);
                }

                $subtotal = $barang->harga_jual * $qty;
                $totalBelanja += $subtotal;

                $detailRows[] = [
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'qty' => $qty,
                    'harga_satuan' => $barang->harga_jual,
                    'subtotal' => $subtotal,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                // Stok berkurang, total_terjual bertambah -> dipakai ulang oleh mesin AI (Fase 5)
                $this->barangRepository->update($barang->id, [
                    'stok' => $barang->stok - $qty,
                    'total_terjual' => $barang->total_terjual + $qty,
                ]);
            }

            $this->detailTransaksiRepository->createMany($detailRows);

            if ($jumlahBayar < $totalBelanja) {
                throw new \InvalidArgumentException('Jumlah bayar kurang dari total belanja.');
            }

            $this->pembayaranRepository->create([
                'transaksi_id' => $transaksi->id,
                'metode_pembayaran' => $metodePembayaran,
                'jumlah_bayar' => $jumlahBayar,
                'kembalian' => $jumlahBayar - $totalBelanja,
            ]);

            $this->transaksiRepository->update($transaksi->id, ['total_belanja' => $totalBelanja]);

            return $this->transaksiRepository->findOrFail($transaksi->id);
        });
    }

    public function batalkan(int $transaksiId): object
    {
        return $this->transaksiRepository->update($transaksiId, ['status' => 'batal']);
    }

    // ================= Dashboard =================

    public function countAll(): int
    {
        return $this->transaksiRepository->countAll();
    }

    public function totalPenjualanHariIni(): int
    {
        return $this->transaksiRepository->totalPenjualanHariIni();
    }

    public function grafikPenjualanHarian(int $hariTerakhir = 7): SupportCollection
    {
        return $this->transaksiRepository->totalPenjualanHarian($hariTerakhir);
    }
}
