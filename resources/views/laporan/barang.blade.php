@extends('layouts.app')
@section('title', 'Laporan Barang')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-box-seam"></i> Laporan Barang</h4>
        <div>
            <a href="{{ route('admin.laporan.barang.pdf') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
            <a href="{{ route('admin.laporan.barang.excel') }}" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light">
                    <tr><th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Supplier</th><th>Harga Jual</th><th>Stok</th><th>Expired</th></tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $b)
                        <tr>
                            <td>{{ $b->kode_barang }}</td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>{{ $b->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $b->supplier->nama_supplier ?? '-' }}</td>
                            <td>Rp {{ number_format($b->harga_jual, 0, ',', '.') }}</td>
                            <td>{{ $b->stok }}</td>
                            <td>{{ $b->tanggal_expired->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
