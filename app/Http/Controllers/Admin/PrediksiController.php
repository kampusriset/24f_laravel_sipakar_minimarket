<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BarangService;
use App\Services\PrediksiService;
use Illuminate\Http\Request;

class PrediksiController extends Controller
{
    public function __construct(
        protected PrediksiService $prediksiService,
        protected BarangService $barangService,
    ) {
    }

    public function index(Request $request)
    {
        $barangs = $this->barangService->getPaginated($request->get('q'), null, null, 15);
        $modelAktif = $this->prediksiService->getActiveModel();

        return view('prediksi.index', compact('barangs', 'modelAktif'));
    }

    public function prediksiSatu(int $barangId)
    {
        $barang = $this->barangService->find($barangId);

        try {
            $hasil = $this->prediksiService->prediksiBarang($barang);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['prediksi' => $e->getMessage()]);
        }

        return back()->with('success', "Prediksi untuk \"{$barang->nama_barang}\": {$hasil->hasil_prediksi}");
    }

    public function prediksiMassal()
    {
        $barangs = $this->barangService->getPaginated(null, null, null, 1000)->getCollection();

        try {
            $jumlah = $this->prediksiService->prediksiSemuaBarang($barangs);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['prediksi' => $e->getMessage()]);
        }

        return back()->with('success', "Prediksi massal selesai untuk {$jumlah} barang.");
    }

    public function history()
    {
        $riwayat = $this->prediksiService->getHistory(20);

        return view('prediksi.history', compact('riwayat'));
    }
}
