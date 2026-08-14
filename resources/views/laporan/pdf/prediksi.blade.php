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
    <h2>SMARTMINI AI — Laporan Prediksi AI</h2>
    <p>Dicetak: {{ now()->format('d-m-Y H:i') }} | Total prediksi: {{ $prediksis->count() }}</p>

    <table>
        <thead>
            <tr><th>Tanggal</th><th>Barang</th><th>Tingkat Penjualan</th><th>Sisa Stok</th><th>Masa Expired</th><th>Hasil Prediksi</th></tr>
        </thead>
        <tbody>
            @foreach ($prediksis as $p)
                <tr>
                    <td>{{ $p->tanggal_prediksi->format('d-m-Y H:i') }}</td>
                    <td>{{ $p->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $p->tingkat_penjualan }}</td>
                    <td>{{ $p->sisa_stok }}</td>
                    <td>{{ $p->masa_expired }}</td>
                    <td>{{ $p->hasil_prediksi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
