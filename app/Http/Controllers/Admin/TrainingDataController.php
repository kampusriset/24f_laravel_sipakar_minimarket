<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TrainingDataService;
use Illuminate\Http\Request;

class TrainingDataController extends Controller
{
    public function __construct(
        protected TrainingDataService $trainingDataService
    ) {
    }

    public function index()
    {
        $trainingData = $this->trainingDataService->getPaginated(20);
        $totalAktif = $this->trainingDataService->countActive();

        return view('training-data.index', compact('trainingData', 'totalAktif'));
    }

    public function create()
    {
        return view('training-data.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tingkat_penjualan' => ['required', 'in:Tinggi,Sedang,Rendah'],
            'sisa_stok' => ['required', 'in:Banyak,Cukup,Sedikit'],
            'masa_expired' => ['required', 'in:Dekat,Sedang,Jauh'],
            'keputusan' => ['required', 'in:Restok,Tidak Restok,Diskon,Return Supplier'],
        ]);

        $this->trainingDataService->create($data);

        return redirect()->route('admin.training-data.index')->with('success', 'Data latih berhasil ditambahkan. Jangan lupa Training Model ulang di menu Machine Learning.');
    }

    public function edit(int $id)
    {
        $item = $this->trainingDataService->find($id);

        return view('training-data.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'tingkat_penjualan' => ['required', 'in:Tinggi,Sedang,Rendah'],
            'sisa_stok' => ['required', 'in:Banyak,Cukup,Sedikit'],
            'masa_expired' => ['required', 'in:Dekat,Sedang,Jauh'],
            'keputusan' => ['required', 'in:Restok,Tidak Restok,Diskon,Return Supplier'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $this->trainingDataService->update($id, $data);

        return redirect()->route('admin.training-data.index')->with('success', 'Data latih berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->trainingDataService->delete($id);

        return redirect()->route('admin.training-data.index')->with('success', 'Data latih berhasil dihapus.');
    }
}
