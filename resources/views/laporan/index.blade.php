@extends('layouts.app')
@section('title', 'Laporan')

@section('content')
    <h4 class="fw-bold mb-3"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</h4>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam fs-1 text-primary"></i>
                    <h6 class="mt-2">Laporan Barang</h6>
                    <a href="{{ route('admin.laporan.barang') }}" class="btn btn-sm btn-primary w-100">Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-cash-coin fs-1 text-success"></i>
                    <h6 class="mt-2">Laporan Penjualan</h6>
                    <a href="{{ route('admin.laporan.penjualan') }}" class="btn btn-sm btn-success w-100">Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up-arrow fs-1 text-warning"></i>
                    <h6 class="mt-2">Laporan Prediksi AI</h6>
                    <a href="{{ route('admin.laporan.prediksi') }}" class="btn btn-sm btn-warning w-100">Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-x-octagon fs-1 text-danger"></i>
                    <h6 class="mt-2">Laporan Barang Expired</h6>
                    <a href="{{ route('admin.laporan.expired') }}" class="btn btn-sm btn-danger w-100">Lihat</a>
                </div>
            </div>
        </div>
    </div>
@endsection
