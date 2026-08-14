@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-receipt"></i> Riwayat Transaksi</h4>
        @if (auth()->user()->role === 'kasir')
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-cart-plus"></i> Transaksi Baru (POS)
            </a>
        @endif
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari kode transaksi...">
                </div>
                <div class="col-md-3">
                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-3">
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-search"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $trx)
                        <tr>
                            <td>{{ $trx->kode_transaksi }}</td>
                            <td>{{ $trx->tanggal_transaksi->format('d-m-Y H:i') }}</td>
                            <td>{{ $trx->kasir->nama_kasir ?? '-' }}</td>
                            <td>Rp {{ number_format($trx->total_belanja, 0, ',', '.') }}</td>
                            <td>
                                @if ($trx->status === 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Batal</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $transaksis->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
