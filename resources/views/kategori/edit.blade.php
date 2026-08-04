@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
    <h4 class="fw-bold mb-3"><i class="bi bi-pencil"></i> Edit Kategori</h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.kategori.update', $kategori->id) }}">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Kode Kategori</label>
                    <input type="text" name="kode_kategori" value="{{ old('kode_kategori', $kategori->kode_kategori) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $kategori->keterangan) }}</textarea>
                </div>
                <button class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
