@extends('layouts.app')

@section('title', 'CMS Bidang & Program Keahlian SMK')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-gear-wide-connected text-primary me-2"></i> Bidang & Program Keahlian SMK</h4>
        <p class="text-muted small mb-0">10 Bidang Keahlian dan Spektrum Program Keahlian SMK Kurikulum Merdeka.</p>
    </div>
</div>

<div class="row g-4">
    @foreach($bidangs as $b)
        <div class="col-md-6 col-xl-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-light py-3 d-flex align-items-center justify-content-between">
                    <div class="fw-bold text-dark">
                        <span class="badge bg-primary me-1">{{ $b->kode }}</span> {{ $b->nama }}
                    </div>
                </div>
                <div class="card-body p-3">
                    <p class="small text-muted mb-3">{{ $b->deskripsi }}</p>
                    <div class="fw-semibold text-secondary small mb-2">Program Keahlian:</div>
                    @if($b->programKeahlians->isEmpty())
                        <div class="text-muted small italic">Belum ada program keahlian.</div>
                    @else
                        <ul class="list-group list-group-flush small">
                            @foreach($b->programKeahlians as $p)
                                <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                    <span><strong>{{ $p->kode }}</strong> - {{ $p->nama }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
