@if ($node['type'] === 'leaf')
    <span class="badge bg-success">
        <i class="bi bi-flag"></i> {{ $node['label'] ?? '-' }} ({{ $node['jumlah_data'] }} data)
    </span>
@else
    <div class="border rounded p-2 mb-1 bg-white">
        <div class="fw-bold text-primary">
            <i class="bi bi-diagram-2"></i> {{ $node['attribute'] }}
            <span class="badge bg-light text-dark ms-1">Entropy: {{ $node['entropy'] }}</span>
            <span class="badge bg-light text-dark">{{ $node['jumlah_data'] }} data</span>
        </div>
        <ul class="list-unstyled ms-3 mt-2 mb-0">
            @foreach ($node['branches'] as $nilai => $cabang)
                <li class="mb-2">
                    <span class="badge bg-secondary">{{ $nilai }}</span> &rarr;
                    @include('training-model.partials.tree-node', ['node' => $cabang])
                </li>
            @endforeach
        </ul>
    </div>
@endif
