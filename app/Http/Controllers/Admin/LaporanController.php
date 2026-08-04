<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BarangExport;
use App\Exports\ExpiredExport;
use App\Exports\PenjualanExport;
use App\Exports\PrediksiExport;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Prediksi;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    // ================= Laporan Barang =================

    public function barang()
    {
        $barangs = Barang::with(['kategori', 'supplier'])->orderBy('nama_barang')->get();

        return view('laporan.barang', compact('barangs'));
    }

    public function barangPdf()
    {
        $barangs = Barang::with(['kategori', 'supplier'])->orderBy('nama_barang')->get();
        $pdf = Pdf::loadView('laporan.pdf.barang', compact('barangs'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-barang-' . now()->format('Ymd-His') . '.pdf');
    }

    public function barangExcel()
    {
        return Excel::download(new BarangExport(), 'laporan-barang-' . now()->format('Ymd-His') . '.xlsx');
    }

    // ================= Laporan Penjualan =================

    public function penjualan(Request $request)
    {
        $tanggalAwal = $request->get('tanggal_awal');
        $tanggalAkhir = $request->get('tanggal_akhir');

        $transaksis = Transaksi::with(['kasir', 'pembayaran'])
            ->where('status', 'selesai')
            ->when($tanggalAwal, fn ($q) => $q->whereDate('tanggal_transaksi', '>=', $tanggalAwal))
            ->when($tanggalAkhir, fn ($q) => $q->whereDate('tanggal_transaksi', '<=', $tanggalAkhir))
            ->orderByDesc('tanggal_transaksi')
            ->get();

        $totalPenjualan = $transaksis->sum('total_belanja');

        return view('laporan.penjualan', compact('transaksis', 'totalPenjualan', 'tanggalAwal', 'tanggalAkhir'));
    }

    public function penjualanPdf(Request $request)
    {
        $tanggalAwal = $request->get('tanggal_awal');
        $tanggalAkhir = $request->get('tanggal_akhir');

        $transaksis = Transaksi::with(['kasir', 'pembayaran'])
            ->where('status', 'selesai')
            ->when($tanggalAwal, fn ($q) => $q->whereDate('tanggal_transaksi', '>=', $tanggalAwal))
            ->when($tanggalAkhir, fn ($q) => $q->whereDate('tanggal_transaksi', '<=', $tanggalAkhir))
            ->orderByDesc('tanggal_transaksi')
            ->get();

        $totalPenjualan = $transaksis->sum('total_belanja');

        $pdf = Pdf::loadView('laporan.pdf.penjualan', compact('transaksis', 'totalPenjualan'))->setPaper('a4', 'portrait');

        return $pdf->download('laporan-penjualan-' . now()->format('Ymd-His') . '.pdf');
    }

    public function penjualanExcel(Request $request)
    {
        return Excel::download(
            new PenjualanExport($request->get('tanggal_awal'), $request->get('tanggal_akhir')),
            'laporan-penjualan-' . now()->format('Ymd-His') . '.xlsx'
        );
    }

    // ================= Laporan Prediksi =================

    public function prediksi()
    {
        $prediksis = Prediksi::with('barang')->orderByDesc('tanggal_prediksi')->get();

        return view('laporan.prediksi', compact('prediksis'));
    }

    public function prediksiPdf()
    {
        $prediksis = Prediksi::with('barang')->orderByDesc('tanggal_prediksi')->get();
        $pdf = Pdf::loadView('laporan.pdf.prediksi', compact('prediksis'))->setPaper('a4', 'portrait');

        return $pdf->download('laporan-prediksi-' . now()->format('Ymd-His') . '.pdf');
    }

    public function prediksiExcel()
    {
        return Excel::download(new PrediksiExport(), 'laporan-prediksi-' . now()->format('Ymd-His') . '.xlsx');
    }

    // ================= Laporan Barang Expired =================

    public function expired()
    {
        $barangs = Barang::with(['kategori', 'supplier'])
            ->where('tanggal_expired', '<', Carbon::today())
            ->orderBy('tanggal_expired')
            ->get();

        return view('laporan.expired', compact('barangs'));
    }

    public function expiredPdf()
    {
        $barangs = Barang::with(['kategori', 'supplier'])
            ->where('tanggal_expired', '<', Carbon::today())
            ->orderBy('tanggal_expired')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.expired', compact('barangs'))->setPaper('a4', 'portrait');

        return $pdf->download('laporan-expired-' . now()->format('Ymd-His') . '.pdf');
    }

    public function expiredExcel()
    {
        return Excel::download(new ExpiredExport(), 'laporan-expired-' . now()->format('Ymd-His') . '.xlsx');
    }
}
