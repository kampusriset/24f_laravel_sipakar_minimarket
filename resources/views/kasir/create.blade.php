@extends('layouts.app')
@section('title', 'Tambah Kasir')

@section('content')
    <h4 class="fw-bold mb-3"><i class="bi bi-plus-lg"></i> Tambah Kasir</h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.kasir.store') }}">
                @csrf
                <div class="alert alert-secondary small">
                    <i class="bi bi-info-circle"></i> Ini akan membuat akun login (role kasir) sekaligus data profil kasir.
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Kasir</label>
                    <input type="text" name="nama_kasir" value="{{ old('nama_kasir') }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email (untuk login)</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="aktif" selected>Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                <a href="{{ route('admin.kasir.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
