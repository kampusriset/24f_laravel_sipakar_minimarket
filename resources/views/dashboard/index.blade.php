@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <h4 class="fw-bold mb-1">Selamat datang, {{ auth()->user()->name }} 👋</h4>
    <p class="text-muted mb-4">Ringkasan operasional SMARTMINI AI hari ini.</p>

    @if (auth()->user()->isAdmin())
        {{-- ================= KARTU STATISTIK (Admin) ================= --}}
        <div class="row g-3 mb-4">
            <div class="col-lg col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Total Barang</div>
                        <div class="fs-4 fw-bold">{{ $stats['total_barang'] }}</div>
                        <i class="bi bi-box-seam text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Total Supplier</div>
                        <div class="fs-4 fw-bold">{{ $stats['total_supplier'] }}</div>
                        <i class="bi bi-truck text-info"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Total Transaksi</div>
                        <div class="fs-4 fw-bold">{{ $stats['total_transaksi'] }}</div>
                        <i class="bi bi-receipt text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">Penjualan Hari Ini</div>
                        <div class="fs-5 fw-bold">Rp {{ number_format($stats['penjualan_hari_ini'], 0, ',', '.') }}</div>
                        <i class="bi bi-cash-coin text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg col-6">
                <div class="card border-0 shadow-sm h-100 {{ $barangExpired->count() > 0 ? 'border-danger' : '' }}">
                    <div class="card-body">
                        <div class="text-muted small">Barang Expired</div>
                        <div class="fs-4 fw-bold text-danger">{{ $barangExpired->count() }}</div>
                        <i class="bi bi-x-circle text-danger"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg col-6">
                <div class="card border-0 shadow-sm h-100 {{ $barangStokMenipis->count() > 0 ? 'border-warning' : '' }}">
                    <div class="card-body">
                        <div class="text-muted small">Stok Menipis</div>
                        <div class="fs-4 fw-bold text-warning">{{ $barangStokMenipis->count() }}</div>
                        <i class="bi bi-exclamation-triangle text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= GRAFIK ================= --}}
        <div class="row g-3 mb-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold"><i class="bi bi-graph-up"></i> Grafik Penjualan (7 Hari Terakhir)</div>
                    <div class="card-body"><canvas id="chartPenjualan" height="180"></canvas></div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold"><i class="bi bi-bar-chart"></i> Barang Terlaris</div>
                    <div class="card-body"><canvas id="chartTerlaris" height="220"></canvas></div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold"><i class="bi bi-pie-chart"></i> Prediksi AI</div>
                    <div class="card-body">
                        @if ($rekapPrediksi->count() > 0)
                            <canvas id="chartPrediksi" height="220"></canvas>
                        @else
                            <p class="text-muted small text-center py-4">Belum ada data prediksi. Jalankan Training Model & Prediksi terlebih dahulu.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($modelAktif)
            <div class="alert alert-info small">
                <i class="bi bi-cpu"></i> Model AI aktif — Accuracy: <strong>{{ $modelAktif->accuracy }}%</strong>,
                Precision: <strong>{{ $modelAktif->precision_avg }}%</strong>,
                Recall: <strong>{{ $modelAktif->recall_avg }}%</strong>.
                <a href="{{ route('admin.training-model.index') }}">Lihat detail →</a>
            </div>
        @endif

        {{-- ================= TABEL BARANG HAMPIR EXPIRED / EXPIRED ================= --}}
        <div class="row g-3">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold text-warning"><i class="bi bi-hourglass-split"></i> Barang Hampir Expired (≤ 30 hari)</div>
                    <div class="card-body table-responsive" style="max-height:300px; overflow-y:auto;">
                        <table class="table table-sm mb-0">
                            <thead><tr><th>Barang</th><th>Expired</th><th>Sisa Hari</th></tr></thead>
                            <tbody>
                                @forelse ($barangHampirExpired as $b)
                                    <tr>
                                        <td>{{ $b->nama_barang }}</td>
                                        <td>{{ $b->tanggal_expired->format('d-m-Y') }}</td>
                                        <td><span class="badge bg-warning text-dark">{{ $b->sisa_hari_expired }} hari</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold text-danger"><i class="bi bi-x-octagon"></i> Barang Sudah Expired</div>
                    <div class="card-body table-responsive" style="max-height:300px; overflow-y:auto;">
                        <table class="table table-sm mb-0">
                            <thead><tr><th>Barang</th><th>Expired</th><th>Stok</th></tr></thead>
                            <tbody>
                                @forelse ($barangExpired as $b)
                                    <tr>
                                        <td>{{ $b->nama_barang }}</td>
                                        <td>{{ $b->tanggal_expired->format('d-m-Y') }}</td>
                                        <td>{{ $b->stok }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- ================= TAMPILAN KASIR ================= --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <i class="bi bi-person-badge text-warning fs-2"></i>
                <h5 class="mt-2">Anda login sebagai Kasir</h5>
                <p class="text-muted">Gunakan menu <strong>Kasir / POS</strong> di sidebar untuk memulai transaksi baru.</p>
                <a href="{{ route('transaksi.create') }}" class="btn btn-primary"><i class="bi bi-cart-plus"></i> Mulai Transaksi</a>
            </div>
        </div>
    @endif
@endsection

@if (auth()->user()->isAdmin())
@push('scripts')
<script
    src="URL-CHART-JS"
    integrity="NILAI-SRI-YANG-SESUAI"
    crossorigin="anonymous">
</script><script>
    const tglPenjualan = @json($grafikPenjualan->pluck('tanggal'));
    const totalPenjualan = @json($grafikPenjualan->pluck('total'));

    new Chart(document.getElementById('chartPenjualan'), {
        type: 'line',
        data: {
            labels: tglPenjualan,
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: totalPenjualan,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.1)',
                tension: 0.3,
                fill: true,
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });

    const namaTerlaris = @json($barangTerlaris->pluck('nama_barang'));
    const jumlahTerlaris = @json($barangTerlaris->pluck('total_terjual'));

    new Chart(document.getElementById('chartTerlaris'), {
        type: 'bar',
        data: {
            labels: namaTerlaris,
            datasets: [{
                label: 'Total Terjual',
                data: jumlahTerlaris,
                backgroundColor: '#198754',
            }]
        },
        options: {
            indexAxis: 'y',
            plugins: { legend: { display: false } }
        }
    });

    @if ($rekapPrediksi->count() > 0)
    const labelPrediksi = @json($rekapPrediksi->pluck('hasil_prediksi'));
    const jumlahPrediksi = @json($rekapPrediksi->pluck('total'));

    new Chart(document.getElementById('chartPrediksi'), {
        type: 'doughnut',
        data: {
            labels: labelPrediksi,
            datasets: [{
                data: jumlahPrediksi,
                backgroundColor: ['#198754', '#6c757d', '#ffc107', '#dc3545', '#0dcaf0'],
            }]
        }
    });
    @endif
</script>
@endpush
@endif
