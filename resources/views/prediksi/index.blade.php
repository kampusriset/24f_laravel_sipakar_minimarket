@extends('layouts.app')
@section('title', 'Prediksi AI')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-graph-up-arrow"></i> Prediksi Keputusan Barang</h4>
        <div>
            <a href="{{ route('admin.prediksi.history') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-clock-history"></i> Riwayat Prediksi
            </a>
            <form method="POST" action="{{ route('admin.prediksi.massal') }}" class="d-inline" onsubmit="return confirm('Jalankan prediksi untuk semua barang di halaman ini?')">
                @csrf
                <button class="btn btn-primary btn-sm"><i class="bi bi-lightning"></i> Prediksi Massal</button>
            </form>
        </div>
    </div>

    @if (! $modelAktif)
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i>
            Belum ada model AI yang di-training. Silakan ke menu
            <a href="{{ route('admin.training-model.index') }}">Training Model</a> terlebih dahulu.
        </div>
    @else
        <div class="alert alert-secondary small">
            Model aktif: Accuracy <strong>{{ $modelAktif->accuracy }}%</strong>,
            dilatih dari <strong>{{ $modelAktif->jumlah_data_latih }}</strong> data
            pada {{ $modelAktif->created_at->format('d-m-Y H:i') }}.
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Barang</th>
                        <th>Tingkat Penjualan</th>
                        <th>Sisa Stok</th>
                        <th>Masa Expired</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        @php $atr = app(\App\Services\BarangService::class)->diskritisasiAtribut($barang); @endphp
                        <tr>
                            <td>{{ $barang->nama_barang }}</td>
                            <td><span class="badge bg-light text-dark">{{ $atr['tingkat_penjualan'] }}</span></td>
                            <td><span class="badge bg-light text-dark">{{ $atr['sisa_stok'] }}</span></td>
                            <td><span class="badge bg-light text-dark">{{ $atr['masa_expired'] }}</span></td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.prediksi.satu', $barang->id) }}">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-primary" @disabled(!$modelAktif)>
                                        <i class="bi bi-magic"></i> Prediksi
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $barangs->links() }}
        </div>
    </div>
@endsection
