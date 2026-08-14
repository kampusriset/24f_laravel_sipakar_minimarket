<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 5px 7px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>SMARTMINI AI — Laporan Barang Expired</h2>
    <p>Dicetak: {{ now()->format('d-m-Y H:i') }} | Total item expired: {{ $barangs->count() }}</p>

    <table>
        <thead>
            <tr><th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Supplier</th><th>Tanggal Expired</th><th>Stok</th></tr>
        </thead>
        <tbody>
            @foreach ($barangs as $b)
                <tr>
                    <td>{{ $b->kode_barang }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td>{{ $b->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $b->supplier->nama_supplier ?? '-' }}</td>
                    <td>{{ $b->tanggal_expired->format('d-m-Y') }}</td>
                    <td>{{ $b->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
