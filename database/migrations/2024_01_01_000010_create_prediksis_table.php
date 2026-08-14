<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prediksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnDelete();
            $table->enum('tingkat_penjualan', ['Tinggi', 'Sedang', 'Rendah']);
            $table->enum('sisa_stok', ['Banyak', 'Cukup', 'Sedikit']);
            $table->enum('masa_expired', ['Dekat', 'Sedang', 'Jauh']);
            $table->enum('hasil_prediksi', ['Restok', 'Tidak Restok', 'Diskon', 'Return Supplier']);
            $table->json('tree_path')->nullable()->comment('Jejak node pohon keputusan yang dilalui saat prediksi');
            $table->dateTime('tanggal_prediksi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prediksis');
    }
};
