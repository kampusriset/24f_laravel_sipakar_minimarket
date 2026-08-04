<?php

namespace App\Exports;

use App\Models\Prediksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PrediksiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Prediksi::with('barang')->orderByDesc('tanggal_prediksi')->get();
    }

    public function headings(): array
    {
        return ['Tanggal', 'Barang', 'Tingkat Penjualan', 'Sisa Stok', 'Masa Expired', 'Hasil Prediksi'];
    }

    public function map($p): array
    {
        return [
            $p->tanggal_prediksi->format('d-m-Y H:i'),
            $p->barang->nama_barang ?? '-',
            $p->tingkat_penjualan,
            $p->sisa_stok,
            $p->masa_expired,
            $p->hasil_prediksi,
        ];
    }
}
