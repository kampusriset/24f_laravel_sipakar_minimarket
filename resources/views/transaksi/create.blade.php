@extends('layouts.app')
@section('title', 'Transaksi Baru (POS)')

@section('content')
    <h4 class="fw-bold mb-3"><i class="bi bi-cart-plus"></i> Transaksi Baru (POS)</h4>

    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <form method="GET" class="mb-3">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama / kode barang...">
                    </form>

                    <div style="max-height: 480px; overflow-y: auto;">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr><th>Barang</th><th>Harga</th><th>Stok</th><th></th></tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr>
                                        <td>{{ $barang->nama_barang }}</td>
                                        <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                                        <td>{{ $barang->stok }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                onclick="tambahKeranjang({{ $barang->id }}, '{{ addslashes($barang->nama_barang) }}', {{ $barang->harga_jual }}, {{ $barang->stok }})"
                                                @disabled($barang->stok <= 0)>
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $barangs->links() }}
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold"><i class="bi bi-basket"></i> Keranjang</h6>

                    <table class="table table-sm">
                        <thead><tr><th>Barang</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
                        <tbody id="keranjang-body">
                            <tr id="keranjang-kosong"><td colspan="4" class="text-center text-muted">Keranjang masih kosong</td></tr>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between fw-bold border-top pt-2">
                        <span>Total</span>
                        <span id="total-belanja">Rp 0</span>
                    </div>

                    <form method="POST" action="{{ route('transaksi.store') }}" id="form-transaksi" class="mt-3">
                        @csrf
                        <div id="hidden-items"></div>

                        <div class="mb-2">
                            <label class="form-label small">Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-select form-select-sm">
                                <option value="tunai">Tunai</option>
                                <option value="debit">Debit</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Jumlah Bayar (Rp)</label>
                            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control form-control-sm" required>
                        </div>
                        <div class="mb-2 small text-muted" id="kembalian-info"></div>

                        <button type="submit" class="btn btn-success w-100" id="btn-bayar" disabled>
                            <i class="bi bi-check-circle"></i> Proses Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let keranjang = {}; // { barang_id: {nama, harga, qty, maxStok} }

    function renderKeranjang() {
        const body = document.getElementById('keranjang-body');
        const hiddenWrap = document.getElementById('hidden-items');
        const keys = Object.keys(keranjang);

        if (keys.length === 0) {
            body.innerHTML = '<tr id="keranjang-kosong"><td colspan="4" class="text-center text-muted">Keranjang masih kosong</td></tr>';
            hiddenWrap.innerHTML = '';
            document.getElementById('total-belanja').innerText = 'Rp 0';
            document.getElementById('btn-bayar').disabled = true;
            return;
        }

        let html = '';
        let hiddenHtml = '';
        let total = 0;

        keys.forEach(id => {
            const item = keranjang[id];
            const subtotal = item.harga * item.qty;
            total += subtotal;

            html += `<tr>
                <td>${item.nama}</td>
                <td>
                    <input type="number" min="1" max="${item.maxStok}" value="${item.qty}" class="form-control form-control-sm" style="width:70px"
                        onchange="ubahQty(${id}, this.value)">
                </td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusItem(${id})"><i class="bi bi-x"></i></button></td>
            </tr>`;

            hiddenHtml += `<input type="hidden" name="barang_id[]" value="${id}">
                <input type="hidden" name="qty[]" value="${item.qty}">`;
        });

        body.innerHTML = html;
        hiddenWrap.innerHTML = hiddenHtml;
        document.getElementById('total-belanja').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('btn-bayar').disabled = false;
        window.totalBelanjaSaatIni = total;
        hitungKembalian();
    }

    function tambahKeranjang(id, nama, harga, stok) {
        if (keranjang[id]) {
            if (keranjang[id].qty < stok) keranjang[id].qty++;
        } else {
            keranjang[id] = { nama, harga, qty: 1, maxStok: stok };
        }
        renderKeranjang();
    }

    function ubahQty(id, qty) {
        qty = parseInt(qty) || 1;
        if (qty < 1) qty = 1;
        if (qty > keranjang[id].maxStok) qty = keranjang[id].maxStok;
        keranjang[id].qty = qty;
        renderKeranjang();
    }

    function hapusItem(id) {
        delete keranjang[id];
        renderKeranjang();
    }

    function hitungKembalian() {
        const bayar = parseInt(document.getElementById('jumlah_bayar').value) || 0;
        const total = window.totalBelanjaSaatIni || 0;
        const info = document.getElementById('kembalian-info');
        if (bayar >= total && total > 0) {
            info.innerText = 'Kembalian: Rp ' + (bayar - total).toLocaleString('id-ID');
            info.className = 'mb-2 small text-success';
        } else {
            info.innerText = total > 0 ? 'Jumlah bayar kurang dari total.' : '';
            info.className = 'mb-2 small text-danger';
        }
    }

    document.getElementById('jumlah_bayar').addEventListener('input', hitungKembalian);
</script>
@endpush
