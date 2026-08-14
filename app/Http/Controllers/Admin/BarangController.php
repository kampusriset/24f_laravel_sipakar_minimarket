<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BarangService;
use App\Services\KategoriService;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function __construct(
        protected BarangService $barangService,
        protected KategoriService $kategoriService,
        protected SupplierService $supplierService,
    ) {
    }

    public function index(Request $request)
    {
        $barangs = $this->barangService->getPaginated(
            $request->get('q'),
            $request->get('kategori_id'),
            $request->get('supplier_id'),
            15
        );

        $kategoris = $this->kategoriService->getAll();
        $suppliers = $this->supplierService->getAll();

        return view('barang.index', compact('barangs', 'kategoris', 'suppliers'));
    }

    public function create()
    {
        $kategoris = $this->kategoriService->getAll();
        $suppliers = $this->supplierService->getAll();

        return view('barang.create', compact('kategoris', 'suppliers'));
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);

        $this->barangService->create($data);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan. Kode & tanggal expired dihitung otomatis.');
    }

    public function edit(int $id)
    {
        $barang = $this->barangService->find($id);
        $kategoris = $this->kategoriService->getAll();
        $suppliers = $this->supplierService->getAll();

        return view('barang.edit', compact('barang', 'kategoris', 'suppliers'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validasi($request, $id);

        $this->barangService->update($id, $data);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->barangService->delete($id);

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    private function validasi(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'nama_barang' => ['required', 'string', 'max:150'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'harga_beli' => ['required', 'integer', 'min:0'],
            'harga_jual' => ['required', 'integer', 'min:0', 'gte:harga_beli'],
            'stok' => ['required', 'integer', 'min:0'],
            'minimal_stok' => ['required', 'integer', 'min:0'],
            'tanggal_produksi' => ['required', 'date'],
            'shelf_life_hari' => ['required', 'integer', 'min:1'],
            'total_terjual' => ['nullable', 'integer', 'min:0'],
            'status_barang' => ['nullable', 'in:aktif,nonaktif'],
        ]);
    }
}
