<?php

namespace App\Providers;

use App\Repositories\Interfaces\BarangRepositoryInterface;
use App\Repositories\Interfaces\DetailTransaksiRepositoryInterface;
use App\Repositories\Interfaces\KasirRepositoryInterface;
use App\Repositories\Interfaces\KategoriRepositoryInterface;
use App\Repositories\Interfaces\ModelTrainingRepositoryInterface;
use App\Repositories\Interfaces\PembayaranRepositoryInterface;
use App\Repositories\Interfaces\PrediksiRepositoryInterface;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use App\Repositories\Interfaces\TrainingDataRepositoryInterface;
use App\Repositories\Interfaces\TransaksiRepositoryInterface;
use App\Repositories\Eloquent\BarangRepository;
use App\Repositories\Eloquent\DetailTransaksiRepository;
use App\Repositories\Eloquent\KasirRepository;
use App\Repositories\Eloquent\KategoriRepository;
use App\Repositories\Eloquent\ModelTrainingRepository;
use App\Repositories\Eloquent\PembayaranRepository;
use App\Repositories\Eloquent\PrediksiRepository;
use App\Repositories\Eloquent\SupplierRepository;
use App\Repositories\Eloquent\TrainingDataRepository;
use App\Repositories\Eloquent\TransaksiRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Daftar pasangan Interface => Implementasi.
     * Controller/Service akan meminta lewat Interface (dependency injection),
     * Laravel otomatis mengoper objek Repository konkret sesuai daftar ini.
     */
    public array $bindings = [
        KategoriRepositoryInterface::class => KategoriRepository::class,
        SupplierRepositoryInterface::class => SupplierRepository::class,
        BarangRepositoryInterface::class => BarangRepository::class,
        KasirRepositoryInterface::class => KasirRepository::class,
        TransaksiRepositoryInterface::class => TransaksiRepository::class,
        DetailTransaksiRepositoryInterface::class => DetailTransaksiRepository::class,
        PembayaranRepositoryInterface::class => PembayaranRepository::class,
        TrainingDataRepositoryInterface::class => TrainingDataRepository::class,
        PrediksiRepositoryInterface::class => PrediksiRepository::class,
        ModelTrainingRepositoryInterface::class => ModelTrainingRepository::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
