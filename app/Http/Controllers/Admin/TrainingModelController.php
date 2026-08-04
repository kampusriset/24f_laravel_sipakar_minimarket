<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PrediksiService;
use App\Services\TrainingDataService;

class TrainingModelController extends Controller
{
    public function __construct(
        protected PrediksiService $prediksiService,
        protected TrainingDataService $trainingDataService,
    ) {
    }

    public function index()
    {
        $modelAktif = $this->prediksiService->getActiveModel();
        $riwayatModel = $this->prediksiService->getRiwayatModel();
        $totalDataAktif = $this->trainingDataService->countActive();

        return view('training-model.index', compact('modelAktif', 'riwayatModel', 'totalDataAktif'));
    }

    public function train()
    {
        try {
            $hasil = $this->prediksiService->trainModel();
        } catch (\RuntimeException $e) {
            return back()->withErrors(['training' => $e->getMessage()]);
        }

        return redirect()->route('admin.training-model.index')
            ->with('success', sprintf(
                'Training selesai. Accuracy: %s%%, Precision: %s%%, Recall: %s%%',
                $hasil['evaluasi']['accuracy'],
                $hasil['evaluasi']['precision_avg'],
                $hasil['evaluasi']['recall_avg']
            ));
    }
}
