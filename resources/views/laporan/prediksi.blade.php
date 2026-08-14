@extends('layouts.app')
@section('title', 'Laporan Prediksi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-graph-up-arrow"></i> Laporan Prediksi AI</h4>
        <div>
            <a href="{{ route('admin.laporan.prediksi.pdf') }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
            <a href="{{ route('admin.laporan.prediksi.excel') }}" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light"><tr><th>Tanggal</th><th>Barang</th><th>Penjualan</th><th>Stok</th><th>Expired</th><th>Hasil</th></tr></thead>
                <tbody>
                    @foreach ($prediksis as $p)
                        <tr>
                            <td>{{ $p->tanggal_prediksi->format('d-m-Y H:i') }}</td>
                            <td>{{ $p->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $p->tingkat_penjualan }}</td>
                            <td>{{ $p->sisa_stok }}</td>
                            <td>{{ $p->masa_expired }}</td>
                            <td><span class="badge bg-primary">{{ $p->hasil_prediksi }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
