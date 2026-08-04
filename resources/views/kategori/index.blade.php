@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-tags"></i> Data Kategori</h4>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Kategori</th>
                        <th>Keterangan</th>
                        <th>Jumlah Barang</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $kategori)
                        <tr>
                            <td>{{ $kategori->kode_kategori }}</td>
                            <td>{{ $kategori->nama_kategori }}</td>
                            <td>{{ $kategori->keterangan }}</td>
                            <td>{{ $kategori->barangs()->count() }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $kategoris->links() }}
        </div>
    </div>
@endsection
