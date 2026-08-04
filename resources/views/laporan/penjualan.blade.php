@extends('layouts.app')
@section('title', 'Laporan Penjualan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-cash-coin"></i> Laporan Penjualan</h4>
        <div>
            <a href="{{ route('admin.laporan.penjualan.pdf', request()->query()) }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
            <a href="{{ route('admin.laporan.penjualan.excel', request()->query()) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <label class="form-label small">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" value="{{ $tanggalAwal }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-sm btn-outline-primary"><i class="bi bi-search"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-sm table-hover">
                <thead class="table-light"><tr><th>Kode</th><th>Tanggal</th><th>Kasir</th><th>Total</th><th>Metode</th></tr></thead>
                <tbody>
                    @foreach ($transaksis as $trx)
                        <tr>
                            <td>{{ $trx->kode_transaksi }}</td>
                            <td>{{ $trx->tanggal_transaksi->format('d-m-Y H:i') }}</td>
                            <td>{{ $trx->kasir->nama_kasir ?? '-' }}</td>
                            <td>Rp {{ number_format($trx->total_belanja, 0, ',', '.') }}</td>
                            <td class="text-uppercase">{{ $trx->pembayaran->metode_pembayaran ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold table-light">
                        <td colspan="3" class="text-end">Total Keseluruhan</td>
                        <td colspan="2">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
