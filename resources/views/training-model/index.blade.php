@extends('layouts.app')
@section('title', 'Training Model AI')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><i class="bi bi-cpu"></i> Training Model — Decision Tree C4.5</h4>
        <form method="POST" action="{{ route('admin.training-model.train') }}" onsubmit="return confirm('Jalankan training ulang dengan {{ $totalDataAktif }} data latih aktif?')">
            @csrf
            <button class="btn btn-primary"><i class="bi bi-play-circle"></i> Training Model</button>
        </form>
    </div>

    <div class="alert alert-secondary small">
        <i class="bi bi-info-circle"></i>
        Data latih aktif saat ini: <strong>{{ $totalDataAktif }}</strong> baris (lihat/kelola di menu Dataset Training).
        Training akan membagi data menjadi <strong>80% data latih : 20% data uji</strong> untuk menghitung Accuracy/Precision/Recall,
        lalu membangun pohon final dari <strong>seluruh</strong> data aktif untuk dipakai memprediksi barang.
    </div>

    @if ($modelAktif)
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="text-muted small">Accuracy</div>
                        <div class="fs-3 fw-bold text-success">{{ $modelAktif->accuracy }}%</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="text-muted small">Precision (avg)</div>
                        <div class="fs-3 fw-bold text-primary">{{ $modelAktif->precision_avg }}%</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="text-muted small">Recall (avg)</div>
                        <div class="fs-3 fw-bold text-warning">{{ $modelAktif->recall_avg }}%</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="text-muted small">Data Latih / Uji</div>
                        <div class="fs-5 fw-bold">{{ $modelAktif->jumlah_data_latih }} / {{ $modelAktif->jumlah_data_uji }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white fw-bold"><i class="bi bi-table"></i> Confusion Matrix</div>
                    <div class="card-body table-responsive">
                        @php $labels = array_keys($modelAktif->confusion_matrix); @endphp
                        <table class="table table-sm table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Aktual \ Prediksi</th>
                                    @foreach ($labels as $l)
                                        <th>{{ $l }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modelAktif->confusion_matrix as $aktual => $row)
                                    <tr>
                                        <th class="table-light">{{ $aktual }}</th>
                                        @foreach ($row as $prediksi => $jumlah)
                                            <td class="{{ $aktual === $prediksi ? 'table-success fw-bold' : '' }}">{{ $jumlah }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p class="small text-muted mb-0">Diagonal (hijau) = prediksi benar. Baris = label aktual, kolom = label hasil prediksi model.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white fw-bold"><i class="bi bi-diagram-3"></i> Visualisasi Pohon Keputusan (Model Aktif)</div>
                    <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                        @include('training-model.partials.tree-node', ['node' => $modelAktif->tree_json])
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> Belum ada model yang di-training. Klik tombol "Training Model" di atas.
        </div>
    @endif

    @if ($riwayatModel->count() > 1)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="bi bi-clock-history"></i> Riwayat Training</div>
            <div class="card-body table-responsive">
                <table class="table table-sm">
                    <thead class="table-light"><tr><th>#</th><th>Tanggal</th><th>Data Latih</th><th>Accuracy</th><th>Status</th></tr></thead>
                    <tbody>
                        @foreach ($riwayatModel->sortByDesc('id') as $m)
                            <tr>
                                <td>{{ $m->id }}</td>
                                <td>{{ $m->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $m->jumlah_data_latih }}</td>
                                <td>{{ $m->accuracy }}%</td>
                                <td>{!! $m->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Riwayat</span>' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
