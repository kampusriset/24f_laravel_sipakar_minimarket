@extends('layouts.app')
@section('title', 'Riwayat Prediksi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-clock-history"></i> Riwayat Prediksi AI</h4>
        <a href="{{ route('admin.prediksi.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Tingkat Penjualan</th>
                        <th>Sisa Stok</th>
                        <th>Masa Expired</th>
                        <th>Hasil Prediksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $p)
                        <tr>
                            <td>{{ $p->tanggal_prediksi->format('d-m-Y H:i') }}</td>
                            <td>{{ $p->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $p->tingkat_penjualan }}</td>
                            <td>{{ $p->sisa_stok }}</td>
                            <td>{{ $p->masa_expired }}</td>
                            <td>
                                @php
                                    $warna = match($p->hasil_prediksi) {
                                        'Restok' => 'success',
                                        'Tidak Restok' => 'secondary',
                                        'Diskon' => 'warning',
                                        'Return Supplier' => 'danger',
                                        default => 'light',
                                    };
                                @endphp
                                <span class="badge bg-{{ $warna }}">{{ $p->hasil_prediksi }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada riwayat prediksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $riwayat->links() }}
        </div>
    </div>
@endsection
