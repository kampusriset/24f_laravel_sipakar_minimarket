<?php

namespace App\Services;

/**
 * Implementasi algoritma Decision Tree C4.5 dari nol menggunakan PHP native,
 * TANPA library Machine Learning apa pun.
 *
 * Format satu baris dataset:
 *   [
 *     'attributes' => ['tingkat_penjualan' => 'Tinggi', 'sisa_stok' => 'Sedikit', 'masa_expired' => 'Jauh'],
 *     'label'      => 'Restok',
 *   ]
 *
 * Format node pohon hasil buildTree():
 *   Leaf: ['type' => 'leaf', 'label' => 'Restok', 'jumlah_data' => 12]
 *   Node: [
 *     'type' => 'node',
 *     'attribute' => 'masa_expired',
 *     'entropy' => 1.234,
 *     'gain' => [...],          // detail information gain semua atribut yang dipertimbangkan
 *     'gain_ratio' => [...],    // detail gain ratio semua atribut yang dipertimbangkan
 *     'default_label' => 'Restok', // label mayoritas node ini, dipakai jika value tidak dikenal saat prediksi
 *     'jumlah_data' => 42,
 *     'branches' => ['Dekat' => <subtree>, 'Sedang' => <subtree>, 'Jauh' => <subtree>],
 *   ]
 */
class DecisionTreeService
{
    /**
     * Log seluruh perhitungan matematis (Entropy, Gain, Split Info, Gain Ratio)
     * per level pohon, supaya bisa ditampilkan apa adanya di Dashboard AI.
     */
    private array $log = [];

    public function getLog(): array
    {
        return $this->log;
    }

    /**
     * Menghitung Entropy dari sekumpulan data berdasarkan distribusi label-nya.
     * Entropy(S) = - Σ ( p_i * log2(p_i) )
     */
    public function entropy(array $dataset): float
    {
        $total = count($dataset);
        if ($total === 0) {
            return 0.0;
        }

        $distribusi = $this->distribusiLabel($dataset);
        $entropy = 0.0;

        foreach ($distribusi as $jumlah) {
            $p = $jumlah / $total;
            $entropy -= $p * log($p, 2);
        }

        return $entropy;
    }

    /**
     * Information Gain(S, A) = Entropy(S) - Σ ( |Sv|/|S| * Entropy(Sv) )
     */
    public function informationGain(array $dataset, string $attribute, ?float $entropiS = null): float
    {
        $entropiS ??= $this->entropy($dataset);
        $total = count($dataset);

        $subsets = $this->splitByAttribute($dataset, $attribute);
        $entropiTerbobot = 0.0;

        foreach ($subsets as $subset) {
            $bobot = count($subset) / $total;
            $entropiTerbobot += $bobot * $this->entropy($subset);
        }

        return $entropiS - $entropiTerbobot;
    }

    /**
     * Split Info(S, A) = - Σ ( |Sv|/|S| * log2(|Sv|/|S|) )
     * Mengukur seberapa "terpecah" data oleh atribut A (dipakai menormalkan Information Gain).
     */
    public function splitInfo(array $dataset, string $attribute): float
    {
        $total = count($dataset);
        $subsets = $this->splitByAttribute($dataset, $attribute);
        $splitInfo = 0.0;

        foreach ($subsets as $subset) {
            $p = count($subset) / $total;
            if ($p > 0) {
                $splitInfo -= $p * log($p, 2);
            }
        }

        return $splitInfo;
    }

    /**
     * Gain Ratio(S, A) = Information Gain(S, A) / Split Info(S, A)
     * Ini yang membedakan C4.5 dari ID3 — menghindari bias terhadap atribut
     * yang punya banyak nilai unik.
     */
    public function gainRatio(array $dataset, string $attribute): float
    {
        $gain = $this->informationGain($dataset, $attribute);
        $splitInfo = $this->splitInfo($dataset, $attribute);

        if ($splitInfo == 0.0) {
            return 0.0;
        }

        return $gain / $splitInfo;
    }

    /**
     * Membangun pohon keputusan secara rekursif dari dataset training.
     *
     * @param array $dataset    Baris data ['attributes' => [...], 'label' => ...]
     * @param array $attributes Daftar nama atribut yang masih boleh dipakai untuk split
     */
    public function buildTree(array $dataset, array $attributes, int $depth = 0): array
    {
        $jumlahData = count($dataset);
        $distribusi = $this->distribusiLabel($dataset);
        $labelMayoritas = $this->labelMayoritas($distribusi);

        // Kasus dasar 1: dataset kosong -> tidak mungkin terjadi di root, hanya di cabang kosong
        if ($jumlahData === 0) {
            return ['type' => 'leaf', 'label' => null, 'jumlah_data' => 0];
        }

        // Kasus dasar 2: semua data sudah satu label yang sama -> leaf murni
        if (count($distribusi) === 1) {
            return [
                'type' => 'leaf',
                'label' => $labelMayoritas,
                'jumlah_data' => $jumlahData,
            ];
        }

        // Kasus dasar 3: atribut sudah habis dipakai -> leaf dengan label mayoritas
        if (empty($attributes)) {
            return [
                'type' => 'leaf',
                'label' => $labelMayoritas,
                'jumlah_data' => $jumlahData,
            ];
        }

        $entropiS = $this->entropy($dataset);

        $gainList = [];
        $gainRatioList = [];
        $splitInfoList = [];

        foreach ($attributes as $attr) {
            $gainList[$attr] = $this->informationGain($dataset, $attr, $entropiS);
            $splitInfoList[$attr] = $this->splitInfo($dataset, $attr);
            $gainRatioList[$attr] = $this->gainRatio($dataset, $attr);
        }

        // Pilih atribut dengan Gain Ratio tertinggi (aturan standar C4.5).
        // Jika semua Split Info = 0 (Gain Ratio semua 0), fallback ke Information Gain tertinggi.
        $atributTerpilih = array_search(max($gainRatioList), $gainRatioList);
        if ($gainRatioList[$atributTerpilih] == 0.0) {
            $atributTerpilih = array_search(max($gainList), $gainList);
        }

        $this->log[] = [
            'depth' => $depth,
            'jumlah_data' => $jumlahData,
            'entropy_total' => round($entropiS, 4),
            'atribut_dipertimbangkan' => $attributes,
            'information_gain' => array_map(fn ($v) => round($v, 4), $gainList),
            'split_info' => array_map(fn ($v) => round($v, 4), $splitInfoList),
            'gain_ratio' => array_map(fn ($v) => round($v, 4), $gainRatioList),
            'atribut_terpilih' => $atributTerpilih,
        ];

        // Kasus dasar 4: gain terbaik = 0 -> tidak ada atribut yang informatif lagi
        if (max($gainList) <= 0.0) {
            return [
                'type' => 'leaf',
                'label' => $labelMayoritas,
                'jumlah_data' => $jumlahData,
            ];
        }

        $subsets = $this->splitByAttribute($dataset, $atributTerpilih);
        $sisaAtribut = array_values(array_diff($attributes, [$atributTerpilih]));

        $branches = [];
        foreach ($subsets as $nilaiAtribut => $subset) {
            if (count($subset) === 0) {
                $branches[$nilaiAtribut] = [
                    'type' => 'leaf',
                    'label' => $labelMayoritas,
                    'jumlah_data' => 0,
                ];
                continue;
            }

            $branches[$nilaiAtribut] = $this->buildTree($subset, $sisaAtribut, $depth + 1);
        }

        return [
            'type' => 'node',
            'attribute' => $atributTerpilih,
            'entropy' => round($entropiS, 4),
            'gain' => array_map(fn ($v) => round($v, 4), $gainList),
            'gain_ratio' => array_map(fn ($v) => round($v, 4), $gainRatioList),
            'default_label' => $labelMayoritas,
            'jumlah_data' => $jumlahData,
            'branches' => $branches,
        ];
    }

    /**
     * Menelusuri pohon untuk memprediksi label dari satu set atribut baru.
     * Mengembalikan label hasil prediksi + jejak node yang dilalui (tree_path).
     */
    public function predict(array $tree, array $attributes): array
    {
        $path = [];
        $node = $tree;

        while ($node['type'] === 'node') {
            $nilai = $attributes[$node['attribute']] ?? null;

            $path[] = [
                'attribute' => $node['attribute'],
                'nilai_data' => $nilai,
                'entropy' => $node['entropy'],
            ];

            if ($nilai === null || ! array_key_exists($nilai, $node['branches'])) {
                // Kombinasi nilai tidak ditemukan di data latih -> pakai label mayoritas node ini
                return ['label' => $node['default_label'], 'path' => $path, 'fallback' => true];
            }

            $node = $node['branches'][$nilai];
        }

        $path[] = ['leaf' => true, 'label' => $node['label']];

        return ['label' => $node['label'], 'path' => $path, 'fallback' => false];
    }

    /**
     * Evaluasi model: split dataset menjadi data latih & data uji (default 80:20),
     * bangun pohon dari data latih, lalu uji ke data uji dan hitung
     * Confusion Matrix, Accuracy, Precision, Recall.
     */
    public function evaluate(array $dataset, array $attributes, float $rasioUji = 0.2): array
    {
        $shuffled = $dataset;
        shuffle($shuffled);

        $jumlahUji = (int) round(count($shuffled) * $rasioUji);
        $dataUji = array_slice($shuffled, 0, $jumlahUji);
        $dataLatih = array_slice($shuffled, $jumlahUji);

        $tree = $this->buildTree($dataLatih, $attributes);

        $semuaLabel = array_values(array_unique(array_column($dataset, 'label')));
        $confusionMatrix = [];
        foreach ($semuaLabel as $aktual) {
            foreach ($semuaLabel as $prediksi) {
                $confusionMatrix[$aktual][$prediksi] = 0;
            }
        }

        $benar = 0;
        foreach ($dataUji as $baris) {
            $hasil = $this->predict($tree, $baris['attributes']);
            $labelPrediksi = $hasil['label'] ?? $semuaLabel[0];

            $confusionMatrix[$baris['label']][$labelPrediksi] =
                ($confusionMatrix[$baris['label']][$labelPrediksi] ?? 0) + 1;

            if ($labelPrediksi === $baris['label']) {
                $benar++;
            }
        }

        $totalUji = count($dataUji);
        $accuracy = $totalUji > 0 ? ($benar / $totalUji) * 100 : 0;

        // Precision & Recall per kelas, lalu dirata-rata (macro-average)
        $precisions = [];
        $recalls = [];

        foreach ($semuaLabel as $label) {
            $truePositive = $confusionMatrix[$label][$label] ?? 0;

            $prediksiSebagaiLabelIni = 0;
            foreach ($semuaLabel as $aktual) {
                $prediksiSebagaiLabelIni += $confusionMatrix[$aktual][$label] ?? 0;
            }

            $aktualLabelIni = array_sum($confusionMatrix[$label] ?? []);

            $precisions[$label] = $prediksiSebagaiLabelIni > 0 ? ($truePositive / $prediksiSebagaiLabelIni) * 100 : 0;
            $recalls[$label] = $aktualLabelIni > 0 ? ($truePositive / $aktualLabelIni) * 100 : 0;
        }

        return [
            'tree' => $tree,
            'jumlah_data_latih' => count($dataLatih),
            'jumlah_data_uji' => $totalUji,
            'accuracy' => round($accuracy, 2),
            'precision_per_label' => array_map(fn ($v) => round($v, 2), $precisions),
            'recall_per_label' => array_map(fn ($v) => round($v, 2), $recalls),
            'precision_avg' => round(count($precisions) ? array_sum($precisions) / count($precisions) : 0, 2),
            'recall_avg' => round(count($recalls) ? array_sum($recalls) / count($recalls) : 0, 2),
            'confusion_matrix' => $confusionMatrix,
            'labels' => $semuaLabel,
        ];
    }

    // ================= Helper internal =================

    private function distribusiLabel(array $dataset): array
    {
        $distribusi = [];
        foreach ($dataset as $baris) {
            $label = $baris['label'];
            $distribusi[$label] = ($distribusi[$label] ?? 0) + 1;
        }

        return $distribusi;
    }

    private function labelMayoritas(array $distribusi): ?string
    {
        if (empty($distribusi)) {
            return null;
        }

        arsort($distribusi);

        return array_key_first($distribusi);
    }

    /**
     * Membagi dataset menjadi beberapa subset berdasarkan nilai unik suatu atribut.
     * Kunci hasil = nilai atribut (mis. 'Tinggi', 'Sedang', 'Rendah').
     */
    private function splitByAttribute(array $dataset, string $attribute): array
    {
        $subsets = [];

        // Pastikan semua nilai unik yang muncul di dataset tetap ada sebagai key,
        // walau nanti ada yang kosong (dataset sudah lebih kecil di level rekursi).
        $nilaiUnik = array_values(array_unique(array_map(
            fn ($baris) => $baris['attributes'][$attribute] ?? null,
            $dataset
        )));

        foreach ($nilaiUnik as $nilai) {
            $subsets[$nilai] = array_values(array_filter(
                $dataset,
                fn ($baris) => ($baris['attributes'][$attribute] ?? null) === $nilai
            ));
        }

        return $subsets;
    }
}
