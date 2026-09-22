@extends('layouts.app')

@section('title', 'CMS Template Alur Belajar PEDATTI')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-layout-text-window-reverse text-info me-2"></i> Template Alur Belajar PEDATTI</h4>
        <p class="text-muted small mb-0">Atur template teks skenario aktivitas yang digunakan oleh mesin Generator Sekali Klik.</p>
    </div>
</div>

<div class="row g-4">
    @foreach($templates as $t)
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light py-3 d-flex align-items-center justify-content-between">
                    <div class="fw-bold text-primary">
                        Tahap: {{ strtoupper($t->tahap) }}
                    </div>
                    <span class="badge bg-secondary">{{ $t->durasi_default_menit ?? 30 }} Menit</span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('cms.template-pedatti.update', $t->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Template Kegiatan Pembelajaran:</label>
                            <textarea class="form-control small font-monospace" name="template_kegiatan" rows="6" required>{{ $t->template_kegiatan }}</textarea>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Prinsip Deep Learning:</label>
                                <input type="text" class="form-control small" name="prinsip_deep_learning" value="{{ $t->prinsip_deep_learning }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Proses Olah Holistik:</label>
                                <input type="text" class="form-control small" name="olah" value="{{ $t->olah }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Durasi Default (Menit):</label>
                                <input type="number" class="form-control small" name="durasi_default_menit" value="{{ $t->durasi_default_menit }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Contoh Pertanyaan Pemantik:</label>
                                <input type="text" class="form-control small" name="contoh_pertanyaan" value="{{ $t->contoh_pertanyaan }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">
                                Simpan Template
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
