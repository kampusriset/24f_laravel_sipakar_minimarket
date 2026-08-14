<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct(
        protected SupplierService $supplierService
    ) {
    }

    public function index()
    {
        $suppliers = $this->supplierService->getPaginated(10);

        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_supplier' => ['required', 'string', 'max:20', 'unique:suppliers,kode_supplier'],
            'nama_supplier' => ['required', 'string', 'max:150'],
            'kontak' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
            'alamat' => ['nullable', 'string'],
        ]);

        $this->supplierService->create($data);

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $supplier = $this->supplierService->find($id);

        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'kode_supplier' => ['required', 'string', 'max:20', 'unique:suppliers,kode_supplier,' . $id],
            'nama_supplier' => ['required', 'string', 'max:150'],
            'kontak' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
            'alamat' => ['nullable', 'string'],
        ]);

        $this->supplierService->update($id, $data);

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->supplierService->delete($id);

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
