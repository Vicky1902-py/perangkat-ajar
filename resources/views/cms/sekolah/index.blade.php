@extends('layouts.app')

@section('title', 'CMS Satuan Pendidikan (Sekolah)')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-building text-primary me-2"></i> Satuan Pendidikan (Sekolah)</h4>
        <p class="text-muted small mb-0">Kelola profil identitas sekolah, kepala sekolah, dan NPSN untuk kop dokumen resmi.</p>
    </div>
</div>

<div class="row g-4">
    @foreach($sekolahs as $s)
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light py-3">
                    <div class="fw-bold text-dark">
                        {{ $s->nama }} <span class="badge bg-primary ms-1">{{ $s->jenjang }}</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('cms.sekolah.update', $s->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold small">Nama Sekolah:</label>
                                <input type="text" class="form-control small" name="nama" value="{{ $s->nama }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">NPSN:</label>
                                <input type="text" class="form-control small" name="npsn" value="{{ $s->npsn }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold small">Nama Kepala Sekolah & Gelar:</label>
                                <input type="text" class="form-control small" name="kepala_sekolah" value="{{ $s->kepala_sekolah }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Nomor Telepon:</label>
                                <input type="text" class="form-control small" name="telepon" value="{{ $s->telepon }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Email Resmi Sekolah:</label>
                                <input type="email" class="form-control small" name="email" value="{{ $s->email }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold small">Alamat Lengkap:</label>
                                <textarea class="form-control small" name="alamat" rows="2">{{ $s->alamat }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4">
                                Simpan Profil Sekolah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
