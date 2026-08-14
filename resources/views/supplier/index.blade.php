@extends('layouts.app')
@section('title', 'Supplier')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-truck"></i> Data Supplier</h4>
        <a href="{{ route('admin.supplier.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Supplier
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Supplier</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->kode_supplier }}</td>
                            <td>{{ $supplier->nama_supplier }}</td>
                            <td>{{ $supplier->kontak }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ $supplier->alamat }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.supplier.edit', $supplier->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus supplier ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data supplier.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $suppliers->links() }}
        </div>
    </div>
@endsection
