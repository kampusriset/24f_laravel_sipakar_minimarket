@extends('layouts.app')
@section('title', 'Tambah Data Latih')

@section('content')
    <h4 class="fw-bold mb-3"><i class="bi bi-plus-lg"></i> Tambah Data Latih</h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.training-data.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Tingkat Penjualan</label>
                    <select name="tingkat_penjualan" class="form-select" required>
                        <option value="Tinggi">Tinggi</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Rendah">Rendah</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sisa Stok</label>
                    <select name="sisa_stok" class="form-select" required>
                        <option value="Banyak">Banyak</option>
                        <option value="Cukup">Cukup</option>
                        <option value="Sedikit">Sedikit</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Masa Expired</label>
                    <select name="masa_expired" class="form-select" required>
                        <option value="Dekat">Dekat</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Jauh">Jauh</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keputusan (Label)</label>
                    <select name="keputusan" class="form-select" required>
                        <option value="Restok">Restok</option>
                        <option value="Tidak Restok">Tidak Restok</option>
                        <option value="Diskon">Diskon</option>
                        <option value="Return Supplier">Return Supplier</option>
                    </select>
                </div>
                <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin.training-data.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
