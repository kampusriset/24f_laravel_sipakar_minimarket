@php
    $user = auth()->user();
    $isAdmin = $user->isAdmin();
    $isKasir = $user->isKasir();
@endphp

<ul class="nav nav-pills flex-column gap-1">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'text-dark' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
    </li>

    <li class="nav-item mt-2"><small class="text-muted text-uppercase px-3">Transaksi</small></li>
    @if ($isKasir)
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('transaksi.create') ? 'active' : 'text-dark' }}" href="{{ route('transaksi.create') }}">
                <i class="bi bi-cart-plus"></i> Kasir / POS
            </a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : 'text-dark' }}" href="{{ route('transaksi.index') }}">
            <i class="bi bi-receipt"></i> Riwayat Transaksi
        </a>
    </li>

    @if ($isAdmin)
        <li class="nav-item mt-2"><small class="text-muted text-uppercase px-3">Master Data</small></li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.barang.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.barang.index') }}">
                <i class="bi bi-box-seam"></i> Barang
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.kategori.index') }}">
                <i class="bi bi-tags"></i> Kategori
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.supplier.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.supplier.index') }}">
                <i class="bi bi-truck"></i> Supplier
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.kasir.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.kasir.index') }}">
                <i class="bi bi-people"></i> Kasir
            </a>
        </li>

        <li class="nav-item mt-2"><small class="text-muted text-uppercase px-3">Machine Learning</small></li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.training-data.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.training-data.index') }}">
                <i class="bi bi-diagram-3"></i> Dataset Training
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.training-model.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.training-model.index') }}">
                <i class="bi bi-cpu"></i> Training Model
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.prediksi.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.prediksi.index') }}">
                <i class="bi bi-graph-up-arrow"></i> Prediksi
            </a>
        </li>

        <li class="nav-item mt-2"><small class="text-muted text-uppercase px-3">Laporan</small></li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.laporan.index') }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan
            </a>
        </li>
    @endif
</ul>
