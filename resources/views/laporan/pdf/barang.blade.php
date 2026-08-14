<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        h2 { margin-bottom: 2px; }
        p.sub { margin-top: 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 4px 6px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>SMARTMINI AI — Laporan Barang</h2>
    <p class="sub">Dicetak: {{ now()->format('d-m-Y H:i') }} | Total item: {{ $barangs->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Supplier</th>
                <th>Harga Jual</th><th>Stok</th><th>Tgl Produksi</th><th>Tgl Expired</th><th>Terjual</th>
            </tr>
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
                    <td>{{ $b->tanggal_produksi->format('d-m-Y') }}</td>
                    <td>{{ $b->tanggal_expired->format('d-m-Y') }}</td>
                    <td>{{ $b->total_terjual }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
