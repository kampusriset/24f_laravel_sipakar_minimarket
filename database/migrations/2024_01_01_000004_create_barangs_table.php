<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 20)->unique();
            $table->string('nama_barang', 150);
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->unsignedBigInteger('harga_beli');
            $table->unsignedBigInteger('harga_jual');
            $table->unsignedInteger('stok')->default(0);
            $table->unsignedInteger('minimal_stok')->default(10);
            $table->date('tanggal_produksi');
            $table->unsignedInteger('shelf_life_hari')->comment('Umur simpan dalam hari, dipakai menghitung tanggal_expired');
            $table->date('tanggal_expired');
            $table->unsignedInteger('total_terjual')->default(0);
            $table->enum('status_barang', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->index(['tanggal_expired']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
