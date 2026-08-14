@extends('layouts.app')
@section('title', 'Tambah Barang')

@section('content')
    <h4 class="fw-bold mb-3"><i class="bi bi-plus-lg"></i> Tambah Barang</h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.barang.store') }}">
                @csrf
                <div class="alert alert-secondary small">
                    <i class="bi bi-info-circle"></i>
                    Kode barang dibuat otomatis. Tanggal expired dihitung otomatis dari
                    <strong>Tanggal Produksi + Shelf Life (hari)</strong>, tidak diinput manual.
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" @selected(old('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-select" required>
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Beli (Rp)</label>
                        <input type="number" name="harga_beli" value="{{ old('harga_beli') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga Jual (Rp)</label>
                        <input type="number" name="harga_jual" value="{{ old('harga_jual') }}" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok Awal</label>
                        <input type="number" name="stok" value="{{ old('stok', 0) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Minimal Stok</label>
                        <input type="number" name="minimal_stok" value="{{ old('minimal_stok', 10) }}" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Produksi</label>
                        <input type="date" name="tanggal_produksi" value="{{ old('tanggal_produksi') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Shelf Life (hari)</label>
                        <input type="number" name="shelf_life_hari" value="{{ old('shelf_life_hari') }}" class="form-control" placeholder="Contoh: 365" required>
                    </div>
                </div>

                <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
