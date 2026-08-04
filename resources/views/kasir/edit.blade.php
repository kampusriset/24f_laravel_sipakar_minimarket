@extends('layouts.app')
@section('title', 'Edit Kasir')

@section('content')
    <h4 class="fw-bold mb-3"><i class="bi bi-pencil"></i> Edit Kasir — {{ $kasir->kode_kasir }}</h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.kasir.update', $kasir->id) }}">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama Kasir</label>
                    <input type="text" name="nama_kasir" value="{{ old('nama_kasir', $kasir->nama_kasir) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email (login)</label>
                    <input type="email" value="{{ $kasir->user->email ?? '-' }}" class="form-control" disabled>
                    <div class="form-text">Email tidak bisa diubah dari sini.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $kasir->no_hp) }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $kasir->alamat) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="aktif" @selected(old('status', $kasir->status) == 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(old('status', $kasir->status) == 'nonaktif')>Nonaktif</option>
                    </select>
                </div>
                <button class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
                <a href="{{ route('admin.kasir.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
