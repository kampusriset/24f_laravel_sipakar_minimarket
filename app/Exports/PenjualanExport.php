<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PenjualanExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected ?string $tanggalAwal = null,
        protected ?string $tanggalAkhir = null,
    ) {
    }

    public function collection()
    {
        return Transaksi::with(['kasir', 'pembayaran'])
            ->where('status', 'selesai')
            ->when($this->tanggalAwal, fn ($q) => $q->whereDate('tanggal_transaksi', '>=', $this->tanggalAwal))
            ->when($this->tanggalAkhir, fn ($q) => $q->whereDate('tanggal_transaksi', '<=', $this->tanggalAkhir))
            ->orderBy('tanggal_transaksi')
            ->get();
    }

    public function headings(): array
    {
        return ['Kode Transaksi', 'Tanggal', 'Kasir', 'Total Belanja', 'Metode Bayar'];
    }

    public function map($trx): array
    {
        return [
            $trx->kode_transaksi,
            $trx->tanggal_transaksi->format('d-m-Y H:i'),
            $trx->kasir->nama_kasir ?? '-',
            $trx->total_belanja,
            strtoupper($trx->pembayaran->metode_pembayaran ?? '-'),
        ];
    }
}
