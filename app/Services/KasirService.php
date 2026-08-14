<?php

namespace App\Services;

use App\Repositories\Interfaces\KasirRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class KasirService
{
    public function __construct(
        protected KasirRepositoryInterface $kasirRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->kasirRepository->all();
    }

    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->kasirRepository->paginate($perPage);
    }

    public function find(int $id): object
    {
        return $this->kasirRepository->findOrFail($id);
    }

    /**
     * Membuat akun User (role kasir) sekaligus profil Kasir dalam satu transaksi DB.
     */
    public function create(array $data): object
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['nama_kasir'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'kasir',
                'email_verified_at' => now(),
            ]);

            return $this->kasirRepository->create([
                'user_id' => $user->id,
                'kode_kasir' => $this->kasirRepository->generateKodeKasir(),
                'nama_kasir' => $data['nama_kasir'],
                'no_hp' => $data['no_hp'] ?? null,
                'alamat' => $data['alamat'] ?? null,
                'status' => $data['status'] ?? 'aktif',
            ]);
        });
    }

    public function update(int $id, array $data): object
    {
        return $this->kasirRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->kasirRepository->delete($id);
    }
}
