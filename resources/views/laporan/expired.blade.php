@extends('layouts.app')
@section('title', 'Laporan Barang Expired')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-x-octagon"></i> Laporan Barang Expired</h4>
        <div>
            <a href="{{ route('admin.laporan.expired.pdf') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
            <a href="{{ route('admin.laporan.expired.excel') }}" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light"><tr><th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Supplier</th><th>Tanggal Expired</th><th>Stok</th></tr></thead>
                <tbody>
                    @forelse ($barangs as $b)
                        <tr>
                            <td>{{ $b->kode_barang }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $b->supplier->nama_supplier ?? '-' }}</td>
                            <td>{{ $b->tanggal_expired->format('d-m-Y') }}</td>
                            <td>{{ $b->stok }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada barang expired saat ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
