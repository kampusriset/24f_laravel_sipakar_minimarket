<?php

namespace App\Repositories\Eloquent;

use App\Models\Barang;
use App\Repositories\Interfaces\BarangRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class BarangRepository extends BaseRepository implements BarangRepositoryInterface
{
    public function __construct(Barang $model)
    {
        parent::__construct($model);
    }

    public function findByKode(string $kode): ?object
    {
        return $this->model->newQuery()->where('kode_barang', $kode)->first();
    }

    public function search(?string $keyword, ?int $kategoriId, ?int $supplierId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['kategori', 'supplier'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('nama_barang', 'like', "%{$keyword}%")
                        ->orWhere('kode_barang', 'like', "%{$keyword}%");
                });
            })
            ->when($kategoriId, fn ($query) => $query->where('kategori_id', $kategoriId))
            ->when($supplierId, fn ($query) => $query->where('supplier_id', $supplierId))
            ->orderBy('nama_barang')
            ->paginate($perPage);
    }

    public function lowStock(): Collection
    {
        return $this->model->newQuery()
            ->with(['kategori', 'supplier'])
            ->whereColumn('stok', '<=', 'minimal_stok')
            ->where('status_barang', 'aktif')
            ->orderBy('stok')
            ->get();
    }

    public function expiringSoon(int $hari = 30): Collection
    {
        $batas = Carbon::today()->addDays($hari);

        return $this->model->newQuery()
            ->with(['kategori', 'supplier'])
            ->whereBetween('tanggal_expired', [Carbon::today(), $batas])
            ->orderBy('tanggal_expired')
            ->get();
    }

    public function expired(): Collection
    {
        return $this->model->newQuery()
            ->with(['kategori', 'supplier'])
            ->where('tanggal_expired', '<', Carbon::today())
            ->orderBy('tanggal_expired')
            ->get();
    }

    public function mostSold(int $limit = 10): Collection
    {
        return $this->model->newQuery()
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->get();
    }

    public function countAll(): int
    {
        return $this->model->newQuery()->count();
    }

    /**
     * Membuat kode barang berurutan otomatis, format BRG-0001, BRG-0002, dst.
     */
    public function generateKodeBarang(): string
    {
        $last = $this->model->newQuery()
            ->orderByDesc('id')
            ->value('kode_barang');

        $nomor = $last ? ((int) substr($last, 4)) + 1 : 1;

        return 'BRG-' . str_pad((string) $nomor, 4, '0', STR_PAD_LEFT);
    }
}
