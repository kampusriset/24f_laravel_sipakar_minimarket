<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Setiap kali tombol "Training Model" ditekan, satu baris baru dibuat di sini.
 * Kolom tree_json menyimpan struktur pohon keputusan (hasil algoritma C4.5)
 * dalam bentuk JSON agar bisa dipakai ulang untuk prediksi tanpa training ulang.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_trainings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('jumlah_data_latih');
            $table->unsignedInteger('jumlah_data_uji')->default(0);
            $table->json('tree_json');
            $table->decimal('accuracy', 5, 2)->nullable();
            $table->decimal('precision_avg', 5, 2)->nullable();
            $table->decimal('recall_avg', 5, 2)->nullable();
            $table->json('confusion_matrix')->nullable();
            $table->boolean('is_active')->default(true)->comment('Model yang sedang dipakai untuk prediksi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_trainings');
    }
};
