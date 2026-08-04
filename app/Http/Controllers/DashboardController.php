<?php

namespace App\Http\Controllers;

use App\Services\BarangService;
use App\Services\KategoriService;
use App\Services\PrediksiService;
use App\Services\SupplierService;
use App\Services\TransaksiService;

class DashboardController extends Controller
{
    public function __construct(
        protected BarangService $barangService,
        protected SupplierService $supplierService,
        protected KategoriService $kategoriService,
        protected TransaksiService $transaksiService,
        protected PrediksiService $prediksiService,
    ) {
    }

    public function index()
    {
        $stats = [
            'total_barang' => $this->barangService->countAll(),
            'total_supplier' => $this->supplierService->getAll()->count(),
            'total_kategori' => $this->kategoriService->getAll()->count(),
            'total_transaksi' => $this->transaksiService->countAll(),
            'penjualan_hari_ini' => $this->transaksiService->totalPenjualanHariIni(),
        ];

        $barangHampirExpired = $this->barangService->getExpiringSoon(30);
        $barangExpired = $this->barangService->getExpired();
        $barangStokMenipis = $this->barangService->getLowStock();
        $barangTerlaris = $this->barangService->getMostSold(5);

        $grafikPenjualan = $this->transaksiService->grafikPenjualanHarian(7);
        $rekapPrediksi = $this->prediksiService->rekapPerLabel();
        $modelAktif = $this->prediksiService->getActiveModel();

        return view('dashboard.index', compact(
            'stats',
            'barangHampirExpired',
            'barangExpired',
            'barangStokMenipis',
            'barangTerlaris',
            'grafikPenjualan',
            'rekapPrediksi',
            'modelAktif'
        ));
    }
}
