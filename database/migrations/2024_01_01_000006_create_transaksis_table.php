<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi', 30)->unique();
            $table->foreignId('kasir_id')->constrained('kasirs')->cascadeOnDelete();
            $table->dateTime('tanggal_transaksi');
            $table->unsignedBigInteger('total_belanja')->default(0);
            $table->enum('status', ['selesai', 'batal'])->default('selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
