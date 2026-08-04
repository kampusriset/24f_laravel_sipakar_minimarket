<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Repositories\Interfaces\BarangRepositoryInterface;
use App\Repositories\Interfaces\KategoriRepositoryInterface;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use App\Repositories\Interfaces\KasirRepositoryInterface;
use App\Repositories\Interfaces\TransaksiRepositoryInterface;
use App\Repositories\Interfaces\DetailTransaksiRepositoryInterface;
use App\Repositories\Interfaces\PembayaranRepositoryInterface;
use App\Repositories\Interfaces\TrainingDataRepositoryInterface;
use App\Repositories\Interfaces\PrediksiRepositoryInterface;
use App\Repositories\Interfaces\ModelTrainingRepositoryInterface;

// Repositories
use App\Repositories\Eloquent\BarangRepository;
use App\Repositories\Eloquent\KategoriRepository;
use App\Repositories\Eloquent\SupplierRepository;
use App\Repositories\Eloquent\KasirRepository;
use App\Repositories\Eloquent\TransaksiRepository;
use App\Repositories\Eloquent\DetailTransaksiRepository;
use App\Repositories\Eloquent\PembayaranRepository;
use App\Repositories\Eloquent\TrainingDataRepository;
use App\Repositories\Eloquent\PrediksiRepository;
use App\Repositories\Eloquent\ModelTrainingRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BarangRepositoryInterface::class, BarangRepository::class);
        $this->app->bind(KategoriRepositoryInterface::class, KategoriRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(KasirRepositoryInterface::class, KasirRepository::class);
        $this->app->bind(TransaksiRepositoryInterface::class, TransaksiRepository::class);
        $this->app->bind(DetailTransaksiRepositoryInterface::class, DetailTransaksiRepository::class);
        $this->app->bind(PembayaranRepositoryInterface::class, PembayaranRepository::class);
        $this->app->bind(TrainingDataRepositoryInterface::class, TrainingDataRepository::class);
        $this->app->bind(PrediksiRepositoryInterface::class, PrediksiRepository::class);
        $this->app->bind(ModelTrainingRepositoryInterface::class, ModelTrainingRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}