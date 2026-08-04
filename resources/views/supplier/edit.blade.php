@extends('layouts.app')
@section('title', 'Edit Supplier')

@section('content')
    <h4 class="fw-bold mb-3"><i class="bi bi-pencil"></i> Edit Supplier</h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.supplier.update', $supplier->id) }}">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode Supplier</label>
                        <input type="text" name="kode_supplier" value="{{ old('kode_supplier', $supplier->kode_supplier) }}" class="form-control" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nama Supplier</label>
                        <input type="text" name="nama_supplier" value="{{ old('nama_supplier', $supplier->nama_supplier) }}" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kontak</label>
                        <input type="text" name="kontak" value="{{ old('kontak', $supplier->kontak) }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $supplier->email) }}" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $supplier->alamat) }}</textarea>
                </div>
                <button class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
                <a href="{{ route('admin.supplier.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
