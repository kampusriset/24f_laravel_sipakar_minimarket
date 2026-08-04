@extends('layouts.app')
@section('title', 'Edit Barang')

@section('content')
    <h4 class="fw-bold mb-3"><i class="bi bi-pencil"></i> Edit Barang — {{ $barang->kode_barang }}</h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.barang.update', $barang->id) }}">
                @csrf @method('PUT')
                <div class="alert alert-secondary small">
                    <i class="bi bi-info-circle"></i>
                    Tanggal expired saat ini: <strong>{{ $barang->tanggal_expired->format('d-m-Y') }}</strong>.
                    Jika Tanggal Produksi / Shelf Life diubah, tanggal expired dihitung ulang otomatis.
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_id', $barang->kategori_id) == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-select" required>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id', $barang->supplier_id) == $supplier->id)>{{ $supplier->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Beli (Rp)</label>
                        <input type="number" name="harga_beli" value="{{ old('harga_beli', $barang->harga_beli) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Jual (Rp)</label>
                        <input type="number" name="harga_jual" value="{{ old('harga_jual', $barang->harga_jual) }}" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', $barang->stok) }}" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Minimal Stok</label>
                        <input type="number" name="minimal_stok" value="{{ old('minimal_stok', $barang->minimal_stok) }}" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Total Terjual</label>
                        <input type="number" name="total_terjual" value="{{ old('total_terjual', $barang->total_terjual) }}" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tanggal Produksi</label>
                        <input type="date" name="tanggal_produksi" value="{{ old('tanggal_produksi', $barang->tanggal_produksi->format('Y-m-d')) }}" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Shelf Life (hari)</label>
                        <input type="number" name="shelf_life_hari" value="{{ old('shelf_life_hari', $barang->shelf_life_hari) }}" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status Barang</label>
                        <select name="status_barang" class="form-select">
                            <option value="aktif" @selected(old('status_barang', $barang->status_barang) == 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status_barang', $barang->status_barang) == 'nonaktif')>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <button class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
