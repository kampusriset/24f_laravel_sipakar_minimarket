<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 5px 7px; text-align: left; }
        th { background: #eee; }
        tfoot td { font-weight: bold; background: #f5f5f5; }
    </style>
</head>
<body>
    <h2>SMARTMINI AI — Laporan Penjualan</h2>
    <p>Dicetak: {{ now()->format('d-m-Y H:i') }} | Total transaksi: {{ $transaksis->count() }}</p>

    <table>
        <thead>
            <tr><th>Kode Transaksi</th><th>Tanggal</th><th>Kasir</th><th>Metode</th><th>Total</th></tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $trx)
                <tr>
                    <td>{{ $trx->kode_transaksi }}</td>
                    <td>{{ $trx->tanggal_transaksi->format('d-m-Y H:i') }}</td>
                    <td>{{ $trx->kasir->nama_kasir ?? '-' }}</td>
                    <td>{{ strtoupper($trx->pembayaran->metode_pembayaran ?? '-') }}</td>
                    <td>Rp {{ number_format($trx->total_belanja, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr><td colspan="4" style="text-align:right">TOTAL KESELURUHAN</td><td>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td></tr>
        </tfoot>
    </table>
</body>
</html>
