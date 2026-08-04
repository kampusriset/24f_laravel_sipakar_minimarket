<?php

namespace App\Http\Controllers;

use App\Exceptions\InsufficientStockException;
use App\Services\BarangService;
use App\Services\TransaksiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function __construct(
        protected TransaksiService $transaksiService,
        protected BarangService $barangService,
    ) {
    }

    public function index(Request $request)
    {
        $transaksis = $this->transaksiService->getPaginated(
            $request->get('q'),
            $request->get('tanggal_awal'),
            $request->get('tanggal_akhir'),
            15
        );

        return view('transaksi.index', compact('transaksis'));
    }

    public function show(int $id)
    {
        $transaksi = $this->transaksiService->find($id);
        $transaksi->load(['detailTransaksis.barang', 'pembayaran', 'kasir']);

        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Form kasir (POS) — hanya menampilkan barang aktif & stok tersedia.
     */
    public function create(Request $request)
    {
        $barangs = $this->barangService->getPaginated($request->get('q'), null, null, 20);

        return view('transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'barang_id' => ['required', 'array', 'min:1'],
            'barang_id.*' => ['required', 'exists:barangs,id'],
            'qty' => ['required', 'array', 'min:1'],
            'qty.*' => ['required', 'integer', 'min:1'],
            'metode_pembayaran' => ['required', 'in:tunai,debit,qris'],
            'jumlah_bayar' => ['required', 'integer', 'min:0'],
        ]);

        $kasir = Auth::user()->kasir;

        if (! $kasir) {
            return back()->withErrors(['kasir' => 'Akun Anda tidak terdaftar sebagai kasir aktif.']);
        }

        $items = [];
        foreach ($data['barang_id'] as $index => $barangId) {
            $items[] = ['barang_id' => $barangId, 'qty' => $data['qty'][$index]];
        }

        try {
            $transaksi = $this->transaksiService->createTransaksi(
                $kasir->id,
                $items,
                $data['metode_pembayaran'],
                $data['jumlah_bayar']
            );
        } catch (InsufficientStockException $e) {
            return back()->withErrors(['stok' => $e->getMessage()])->withInput();
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['jumlah_bayar' => $e->getMessage()])->withInput();
        }

        return redirect()->route('transaksi.show', $transaksi->id)
            ->with('success', 'Transaksi berhasil disimpan: ' . $transaksi->kode_transaksi);
    }

    public function batalkan(int $id)
    {
        $this->transaksiService->batalkan($id);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi dibatalkan.');
    }
}
