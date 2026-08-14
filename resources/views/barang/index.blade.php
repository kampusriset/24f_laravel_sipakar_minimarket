@extends('layouts.app')
@section('title', 'Barang')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-box-seam"></i> Data Barang</h4>
        <a href="{{ route('admin.barang.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Barang
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama / kode barang...">
                </div>
                <div class="col-md-3">
                    <select name="kategori_id" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" @selected(request('kategori_id') == $kategori->id)>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="supplier_id" class="form-select form-select-sm">
                        <option value="">Semua Supplier</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" @selected(request('supplier_id') == $supplier->id)>{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-search"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Supplier</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th>Terjual</th>
                        <th>Expired</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangs as $barang)
                        <tr>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $barang->supplier->nama_supplier ?? '-' }}</td>
                            <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                            <td>
                                {{ $barang->stok }}
                                @if ($barang->stok <= $barang->minimal_stok)
                                    <span class="badge bg-warning text-dark">Menipis</span>
                                @endif
                            </td>
                            <td>{{ $barang->total_terjual }}</td>
                            <td>
                                {{ $barang->tanggal_expired->format('d-m-Y') }}<br>
                                @php $status = $barang->status_expired; @endphp
                                @if ($status === 'kadaluarsa')
                                    <span class="badge bg-danger">Expired</span>
                                @elseif ($status === 'hampir_expired')
                                    <span class="badge bg-warning text-dark">Hampir Expired</span>
                                @else
                                    <span class="badge bg-success">Aman</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.barang.edit', $barang->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">Tidak ada data barang.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $barangs->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
