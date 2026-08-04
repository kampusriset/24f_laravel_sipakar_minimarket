@extends('layouts.app')
@section('title', 'Edit Data Latih')

@section('content')
    <h4 class="fw-bold mb-3"><i class="bi bi-pencil"></i> Edit Data Latih #{{ $item->id }}</h4>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.training-data.update', $item->id) }}">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Tingkat Penjualan</label>
                    <select name="tingkat_penjualan" class="form-select" required>
                        @foreach (['Tinggi','Sedang','Rendah'] as $opt)
                            <option value="{{ $opt }}" @selected($item->tingkat_penjualan == $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sisa Stok</label>
                    <select name="sisa_stok" class="form-select" required>
                        @foreach (['Banyak','Cukup','Sedikit'] as $opt)
                            <option value="{{ $opt }}" @selected($item->sisa_stok == $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Masa Expired</label>
                    <select name="masa_expired" class="form-select" required>
                        @foreach (['Dekat','Sedang','Jauh'] as $opt)
                            <option value="{{ $opt }}" @selected($item->masa_expired == $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keputusan (Label)</label>
                    <select name="keputusan" class="form-select" required>
                        @foreach (['Restok','Tidak Restok','Diskon','Return Supplier'] as $opt)
                            <option value="{{ $opt }}" @selected($item->keputusan == $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked($item->is_active)>
                    <label class="form-check-label" for="is_active">Aktif (dipakai saat training)</label>
                </div>
                <button class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
                <a href="{{ route('admin.training-data.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
