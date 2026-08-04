<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\KasirService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class KasirController extends Controller
{
    public function __construct(
        protected KasirService $kasirService
    ) {
    }

    public function index()
    {
        $kasirs = $this->kasirService->getPaginated(10);

        return view('kasir.index', compact('kasirs'));
    }

    public function create()
    {
        return view('kasir.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kasir' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $this->kasirService->create($data);

        return redirect()->route('admin.kasir.index')->with('success', 'Akun kasir berhasil dibuat.');
    }

    public function edit(int $id)
    {
        $kasir = $this->kasirService->find($id);

        return view('kasir.edit', compact('kasir'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'nama_kasir' => ['required', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $this->kasirService->update($id, $data);

        return redirect()->route('admin.kasir.index')->with('success', 'Data kasir berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->kasirService->delete($id);

        return redirect()->route('admin.kasir.index')->with('success', 'Data kasir berhasil dihapus.');
    }
}
