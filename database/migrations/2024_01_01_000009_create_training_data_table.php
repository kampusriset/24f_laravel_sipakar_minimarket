<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel training_data menyimpan dataset latih untuk algoritma Decision Tree C4.5.
 * Setiap baris merepresentasikan satu contoh kasus dengan atribut kategorikal
 * hasil diskritisasi, dan sebuah label keputusan (kelas target).
 *
 * Atribut:
 *  - tingkat_penjualan : Tinggi | Sedang | Rendah   (diturunkan dari total_terjual)
 *  - sisa_stok         : Banyak | Cukup | Sedikit   (diturunkan dari stok vs minimal_stok)
 *  - masa_expired      : Dekat | Sedang | Jauh      (diturunkan dari selisih hari ke tanggal_expired)
 *
 * Label (kelas target):
 *  - Restok | Tidak Restok | Diskon | Return Supplier
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->nullable()->constrained('barangs')->nullOnDelete();
            $table->enum('tingkat_penjualan', ['Tinggi', 'Sedang', 'Rendah']);
            $table->enum('sisa_stok', ['Banyak', 'Cukup', 'Sedikit']);
            $table->enum('masa_expired', ['Dekat', 'Sedang', 'Jauh']);
            $table->enum('keputusan', ['Restok', 'Tidak Restok', 'Diskon', 'Return Supplier']);
            $table->boolean('is_active')->default(true)->comment('Ikut dipakai saat training atau tidak');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_data');
    }
};
