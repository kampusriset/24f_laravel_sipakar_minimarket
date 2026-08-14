<?php

namespace App\Services;

use App\Models\Barang;
use App\Repositories\Interfaces\ModelTrainingRepositoryInterface;
use App\Repositories\Interfaces\PrediksiRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PrediksiService
{
    private const ATRIBUT = ['tingkat_penjualan', 'sisa_stok', 'masa_expired'];

    public function __construct(
        protected DecisionTreeService $decisionTreeService,
        protected TrainingDataService $trainingDataService,
        protected BarangService $barangService,
        protected ModelTrainingRepositoryInterface $modelTrainingRepository,
        protected PrediksiRepositoryInterface $prediksiRepository,
    ) {
    }

    /**
     * Mengubah data Eloquent TrainingData menjadi format dataset yang dipahami DecisionTreeService.
     */
    private function siapkanDataset(Collection $trainingData): array
    {
        return $trainingData->map(fn ($row) => [
            'attributes' => [
                'tingkat_penjualan' => $row->tingkat_penjualan,
                'sisa_stok' => $row->sisa_stok,
                'masa_expired' => $row->masa_expired,
            ],
            'label' => $row->keputusan,
        ])->all();
    }

    /**
     * Menjalankan seluruh proses training: evaluasi (split data latih/uji + confusion matrix),
     * lalu membangun ULANG pohon final dari SELURUH dataset aktif (supaya model produksi
     * memakai semua data yang ada), dan menyimpannya sebagai model aktif baru.
     */
    public function trainModel(): array
    {
        $trainingData = $this->trainingDataService->getActiveDataset();

        if ($trainingData->count() < 10) {
            throw new \RuntimeException('Data latih minimal 10 baris untuk training yang bermakna. Saat ini: ' . $trainingData->count());
        }

        $dataset = $this->siapkanDataset($trainingData);

        // 1) Evaluasi dengan split data latih/uji, supaya akurasi mencerminkan data yang belum pernah dilihat
        $hasilEvaluasi = $this->decisionTreeService->evaluate($dataset, self::ATRIBUT);
        $logPerhitunganEvaluasi = $this->decisionTreeService->getLog();

        // 2) Bangun pohon FINAL dari seluruh data (dipakai untuk prediksi produksi)
        $treeFinal = $this->decisionTreeService->buildTree($dataset, self::ATRIBUT);
        $logPerhitunganFinal = $this->decisionTreeService->getLog();

        $this->modelTrainingRepository->deactivateAll();

        $model = $this->modelTrainingRepository->create([
            'jumlah_data_latih' => count($dataset),
            'jumlah_data_uji' => $hasilEvaluasi['jumlah_data_uji'],
            'tree_json' => $treeFinal,
            'accuracy' => $hasilEvaluasi['accuracy'],
            'precision_avg' => $hasilEvaluasi['precision_avg'],
            'recall_avg' => $hasilEvaluasi['recall_avg'],
            'confusion_matrix' => $hasilEvaluasi['confusion_matrix'],
            'is_active' => true,
        ]);

        return [
            'model' => $model,
            'evaluasi' => $hasilEvaluasi,
            'log_evaluasi' => $logPerhitunganEvaluasi,
            'log_final' => $logPerhitunganFinal,
        ];
    }

    public function getActiveModel(): ?object
    {
        return $this->modelTrainingRepository->getActiveModel();
    }

    public function getRiwayatModel(): Collection
    {
        return $this->modelTrainingRepository->all();
    }

    /**
     * Menjalankan prediksi untuk satu barang memakai model aktif, lalu menyimpan hasilnya.
     */
    public function prediksiBarang(Barang $barang): object
    {
        $model = $this->getActiveModel();

        if (! $model) {
            throw new \RuntimeException('Belum ada model yang di-training. Jalankan Training Model terlebih dahulu.');
        }

        $atribut = $this->barangService->diskritisasiAtribut($barang);
        $hasil = $this->decisionTreeService->predict($model->tree_json, $atribut);

        return $this->prediksiRepository->create([
            'barang_id' => $barang->id,
            'tingkat_penjualan' => $atribut['tingkat_penjualan'],
            'sisa_stok' => $atribut['sisa_stok'],
            'masa_expired' => $atribut['masa_expired'],
            'hasil_prediksi' => $hasil['label'],
            'tree_path' => $hasil['path'],
            'tanggal_prediksi' => now(),
        ]);
    }

    /**
     * Menjalankan prediksi untuk SEMUA barang aktif sekaligus ("Prediksi Massal").
     */
    public function prediksiSemuaBarang(Collection $barangs): int
    {
        $jumlah = 0;
        foreach ($barangs as $barang) {
            $this->prediksiBarang($barang);
            $jumlah++;
        }

        return $jumlah;
    }

    public function getHistory(int $perPage = 15): LengthAwarePaginator
    {
        return $this->prediksiRepository->history($perPage);
    }

    public function rekapPerLabel(): Collection
    {
        return $this->prediksiRepository->rekapPerLabel();
    }
}
