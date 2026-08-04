@extends('layouts.app')
@section('title', 'Kasir')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-people"></i> Data Kasir</h4>
        <a href="{{ route('admin.kasir.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Kasir
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kasirs as $kasir)
                        <tr>
                            <td>{{ $kasir->kode_kasir }}</td>
                            <td>{{ $kasir->nama_kasir }}</td>
                            <td>{{ $kasir->user->email ?? '-' }}</td>
                            <td>{{ $kasir->no_hp }}</td>
                            <td>
                                @if ($kasir->status === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.kasir.edit', $kasir->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.kasir.destroy', $kasir->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data kasir ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data kasir.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $kasirs->links() }}
        </div>
    </div>
@endsection
