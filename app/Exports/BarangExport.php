<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BarangExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Barang::with(['kategori', 'supplier'])->orderBy('nama_barang')->get();
    }

    public function headings(): array
    {
        return [
            'Kode Barang', 'Nama Barang', 'Kategori', 'Supplier',
            'Harga Beli', 'Harga Jual', 'Stok', 'Minimal Stok',
            'Tanggal Produksi', 'Tanggal Expired', 'Status Expired', 'Total Terjual',
        ];
    }

    public function map($barang): array
    {
        return [
            $barang->kode_barang,
            $barang->nama_barang,
            $barang->kategori->nama_kategori ?? '-',
            $barang->supplier->nama_supplier ?? '-',
            $barang->harga_beli,
            $barang->harga_jual,
            $barang->stok,
            $barang->minimal_stok,
            $barang->tanggal_produksi->format('d-m-Y'),
            $barang->tanggal_expired->format('d-m-Y'),
            ucfirst(str_replace('_', ' ', $barang->status_expired)),
            $barang->total_terjual,
        ];
    }
}
