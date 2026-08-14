<?php

namespace App\Repositories\Eloquent;

use App\Models\Transaksi;
use App\Repositories\Interfaces\TransaksiRepositoryInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TransaksiRepository extends BaseRepository implements TransaksiRepositoryInterface
{
    public function __construct(Transaksi $model)
    {
        parent::__construct($model);
    }

    public function generateKodeTransaksi(): string
    {
        $prefix = 'TRX-' . Carbon::today()->format('Ymd') . '-';
        $last = $this->model->newQuery()
            ->where('kode_transaksi', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('kode_transaksi');

        $nomor = $last ? ((int) substr($last, -4)) + 1 : 1;

        return $prefix . str_pad((string) $nomor, 4, '0', STR_PAD_LEFT);
    }

    public function search(?string $keyword, ?string $tanggalAwal, ?string $tanggalAkhir, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['kasir', 'pembayaran'])
            ->when($keyword, fn ($q) => $q->where('kode_transaksi', 'like', "%{$keyword}%"))
            ->when($tanggalAwal, fn ($q) => $q->whereDate('tanggal_transaksi', '>=', $tanggalAwal))
            ->when($tanggalAkhir, fn ($q) => $q->whereDate('tanggal_transaksi', '<=', $tanggalAkhir))
            ->orderByDesc('tanggal_transaksi')
            ->paginate($perPage);
    }

    public function totalPenjualanHarian(int $hariTerakhir = 7): SupportCollection
    {
        $mulai = Carbon::today()->subDays($hariTerakhir - 1);

        return $this->model->newQuery()
            ->selectRaw('DATE(tanggal_transaksi) as tanggal, SUM(total_belanja) as total')
            ->where('status', 'selesai')
            ->where('tanggal_transaksi', '>=', $mulai)
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
    }

    public function totalPenjualanHariIni(): int
    {
        return (int) $this->model->newQuery()
            ->whereDate('tanggal_transaksi', Carbon::today())
            ->where('status', 'selesai')
            ->sum('total_belanja');
    }

    public function countAll(): int
    {
        return $this->model->newQuery()->count();
    }
}
