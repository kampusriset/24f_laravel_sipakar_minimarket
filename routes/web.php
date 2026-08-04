<?php

use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\KasirController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PrediksiController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TrainingDataController;
use App\Http\Controllers\Admin\TrainingModelController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Tamu (belum login)
|--------------------------------------------------------------------------
*/
// Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
        ->name('auth.google.callback');
// });

/*
|--------------------------------------------------------------------------
| Rute Wajib Login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |----------------------------------------------------------------
    | Khusus Admin — Master Data, Machine Learning, Laporan
    |----------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('kategori', KategoriController::class)->except(['show']);
        Route::resource('supplier', SupplierController::class)->except(['show']);
        Route::resource('barang', BarangController::class)->except(['show']);
        Route::resource('kasir', KasirController::class)->except(['show']);

        Route::resource('training-data', TrainingDataController::class)
            ->parameters(['training-data' => 'id'])
            ->except(['show']);

        // ---- Machine Learning (Fase 5) ----
        Route::get('/training-model', [TrainingModelController::class, 'index'])
            ->name('training-model.index');

        Route::post('/training-model/train', [TrainingModelController::class, 'train'])
            ->name('training-model.train');

        Route::get('/prediksi', [PrediksiController::class, 'index'])
            ->name('prediksi.index');

        Route::post('/prediksi/{barangId}', [PrediksiController::class, 'prediksiSatu'])
            ->name('prediksi.satu');

        Route::post('/prediksi-massal', [PrediksiController::class, 'prediksiMassal'])
            ->name('prediksi.massal');

        Route::get('/prediksi-riwayat', [PrediksiController::class, 'history'])
            ->name('prediksi.history');

        // ---- Laporan (Fase 6) ----
        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/barang', [LaporanController::class, 'barang'])
            ->name('laporan.barang');

        Route::get('/laporan/barang/pdf', [LaporanController::class, 'barangPdf'])
            ->name('laporan.barang.pdf');

        Route::get('/laporan/barang/excel', [LaporanController::class, 'barangExcel'])
            ->name('laporan.barang.excel');

        Route::get('/laporan/penjualan', [LaporanController::class, 'penjualan'])
            ->name('laporan.penjualan');

        Route::get('/laporan/penjualan/pdf', [LaporanController::class, 'penjualanPdf'])
            ->name('laporan.penjualan.pdf');

        Route::get('/laporan/penjualan/excel', [LaporanController::class, 'penjualanExcel'])
            ->name('laporan.penjualan.excel');

        Route::get('/laporan/prediksi', [LaporanController::class, 'prediksi'])
            ->name('laporan.prediksi');

        Route::get('/laporan/prediksi/pdf', [LaporanController::class, 'prediksiPdf'])
            ->name('laporan.prediksi.pdf');

        Route::get('/laporan/prediksi/excel', [LaporanController::class, 'prediksiExcel'])
            ->name('laporan.prediksi.excel');

        Route::get('/laporan/expired', [LaporanController::class, 'expired'])
            ->name('laporan.expired');

        Route::get('/laporan/expired/pdf', [LaporanController::class, 'expiredPdf'])
            ->name('laporan.expired.pdf');

        Route::get('/laporan/expired/excel', [LaporanController::class, 'expiredExcel'])
            ->name('laporan.expired.excel');
    });

    /*
    |----------------------------------------------------------------
    | Admin & Kasir — Transaksi / POS
    |----------------------------------------------------------------
    */
    Route::middleware('role:admin,kasir')->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])
            ->name('transaksi.index');

        Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])
            ->name('transaksi.show');

        Route::post('/transaksi/{id}/batalkan', [TransaksiController::class, 'batalkan'])
            ->name('transaksi.batalkan');
    });

    /*
    |----------------------------------------------------------------
    | Khusus Kasir — hanya kasir yang boleh membuat transaksi baru
    |----------------------------------------------------------------
    */
    Route::middleware('role:kasir')->group(function () {
        Route::get('/transaksi-baru', [TransaksiController::class, 'create'])
            ->name('transaksi.create');

        Route::post('/transaksi-baru', [TransaksiController::class, 'store'])
            ->name('transaksi.store');
    });
});

Route::redirect('/home', '/');
