<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpiredExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Barang::with(['kategori', 'supplier'])
            ->where('tanggal_expired', '<', Carbon::today())
            ->orderBy('tanggal_expired')
            ->get();
    }

    public function headings(): array
    {
        return ['Kode Barang', 'Nama Barang', 'Kategori', 'Supplier', 'Tanggal Expired', 'Stok Tersisa'];
    }

    public function map($barang): array
    {
        return [
            $barang->kode_barang,
            $barang->nama_barang,
            $barang->kategori->nama_kategori ?? '-',
            $barang->supplier->nama_supplier ?? '-',
            $barang->tanggal_expired->format('d-m-Y'),
            $barang->stok,
        ];
    }
}
