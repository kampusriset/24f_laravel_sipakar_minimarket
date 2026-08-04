<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\KategoriService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct(
        protected KategoriService $kategoriService
    ) {
    }

    public function index()
    {
        $kategoris = $this->kategoriService->getPaginated(10);

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_kategori' => ['required', 'string', 'max:20', 'unique:kategoris,kode_kategori'],
            'nama_kategori' => ['required', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $this->kategoriService->create($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $kategori = $this->kategoriService->find($id);

        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'kode_kategori' => ['required', 'string', 'max:20', 'unique:kategoris,kode_kategori,' . $id],
            'nama_kategori' => ['required', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $this->kategoriService->update($id, $data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->kategoriService->delete($id);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
