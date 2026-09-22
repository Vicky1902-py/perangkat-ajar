@extends('layouts.app')

@section('title', 'CMS Profil Lulusan (8 Dimensi)')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-stars text-warning me-2"></i> 8 Dimensi Profil Lulusan</h4>
        <p class="text-muted small mb-0">Standar Kompetensi Lulusan (SKL) terbaru berdasarkan <strong>Permendikdasmen Nomor 10 Tahun 2025</strong>.</p>
    </div>
</div>

<div class="row g-3">
    @foreach($profils as $p)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="fw-bold text-primary fs-6">
                            <span class="badge bg-primary rounded-circle me-1">{{ $p->urutan }}</span>
                            {{ $p->dimensi }}
                        </div>
                    </div>
                    <form action="{{ route('cms.profil-lulusan.update', $p->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <textarea class="form-control small" name="deskripsi" rows="3" required>{{ $p->deskripsi }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
