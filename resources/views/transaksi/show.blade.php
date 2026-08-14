@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-receipt"></i> Detail Transaksi — {{ $transaksi->kode_transaksi }}</h4>
        <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4"><strong>Tanggal</strong><br>{{ $transaksi->tanggal_transaksi->format('d-m-Y H:i') }}</div>
                <div class="col-md-4"><strong>Kasir</strong><br>{{ $transaksi->kasir->nama_kasir ?? '-' }}</div>
                <div class="col-md-4"><strong>Status</strong><br>
                    @if ($transaksi->status === 'selesai')
                        <span class="badge bg-success">Selesai</span>
                    @else
                        <span class="badge bg-danger">Batal</span>
                    @endif
                </div>
            </div>

            <table class="table table-sm">
                <thead class="table-light"><tr><th>Barang</th><th>Qty</th><th>Harga Satuan</th><th>Subtotal</th></tr></thead>
                <tbody>
                    @foreach ($transaksi->detailTransaksis as $detail)
                        <tr>
                            <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row justify-content-end">
                <div class="col-md-4">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><td>Total Belanja</td><td class="text-end fw-bold">Rp {{ number_format($transaksi->total_belanja, 0, ',', '.') }}</td></tr>
                        @if ($transaksi->pembayaran)
                            <tr><td>Metode Bayar</td><td class="text-end text-uppercase">{{ $transaksi->pembayaran->metode_pembayaran }}</td></tr>
                            <tr><td>Jumlah Bayar</td><td class="text-end">Rp {{ number_format($transaksi->pembayaran->jumlah_bayar, 0, ',', '.') }}</td></tr>
                            <tr><td>Kembalian</td><td class="text-end">Rp {{ number_format($transaksi->pembayaran->kembalian, 0, ',', '.') }}</td></tr>
                        @endif
                    </table>
                </div>
            </div>

            @if ($transaksi->status === 'selesai' && auth()->user()->isAdmin())
                <form action="{{ route('transaksi.batalkan', $transaksi->id) }}" method="POST" onsubmit="return confirm('Batalkan transaksi ini?')" class="mt-3">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle"></i> Batalkan Transaksi</button>
                </form>
            @endif
        </div>
    </div>
@endsection
