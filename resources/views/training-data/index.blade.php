@extends('layouts.app')
@section('title', 'Dataset Training')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-diagram-3"></i> Dataset Training AI</h4>
        <a href="{{ route('admin.training-data.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Data Latih
        </a>
    </div>

    <div class="alert alert-info small">
        <i class="bi bi-info-circle"></i>
        Total data latih aktif: <strong>{{ $totalAktif }}</strong> baris.
        Data ini dipakai saat tombol <strong>"Training Model"</strong> di menu Machine Learning ditekan (Fase 5).
        Jika Anda menambah/mengubah/menghapus data di sini, lakukan training ulang agar pohon keputusan ter-update.
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle table-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tingkat Penjualan</th>
                        <th>Sisa Stok</th>
                        <th>Masa Expired</th>
                        <th>Keputusan</th>
                        <th>Aktif</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trainingData as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->tingkat_penjualan }}</td>
                            <td>{{ $item->sisa_stok }}</td>
                            <td>{{ $item->masa_expired }}</td>
                            <td><span class="badge bg-primary">{{ $item->keputusan }}</span></td>
                            <td>{!! $item->is_active ? '<i class="bi bi-check-circle text-success"></i>' : '<i class="bi bi-x-circle text-muted"></i>' !!}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.training-data.edit', $item->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.training-data.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data latih ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data latih.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $trainingData->links() }}
        </div>
    </div>
@endsection
