@extends('layouts.app')

@section('title', 'Hasil Generate Perangkat Ajar')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- GUEST CONVERSION CALL-TO-ACTION BANNER -->
        @if($isGuest)
            <div class="card border-0 shadow-sm mb-4 text-white" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 rounded-circle bg-white text-primary shadow-sm">
                            <i class="bi bi-cloud-arrow-up-fill fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Simpan Perangkat Ajar Ini ke Akun Anda!</h5>
                            <p class="mb-0 text-white text-opacity-90 small">
                                Anda membuat dokumen ini dalam mode tamu (Sisa kuota gratis: {{ $guestRemaining }} kali).
                                Daftar akun gratis sekarang agar seluruh dokumen di atas otomatis dialihkan & tersimpan aman ke akun Anda!
                            </p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('register') }}" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm">
                            <i class="bi bi-person-plus-fill me-1"></i> Daftarkan Akun Guru (Gratis)
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- SUCCESS BANNER -->
        <div class="card border-0 shadow-sm mb-4 text-white" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
            <div class="card-body p-4 p-md-5 text-center">
                <div class="rounded-circle bg-white text-success d-inline-flex align-items-center justify-content-center p-3 mb-3 shadow">
                    <i class="bi bi-check-lg fs-1"></i>
                </div>
                <h3 class="fw-bold mb-2">Paket Perangkat Ajar Berhasil Dibuat!</h3>
                <p class="text-white text-opacity-90 mb-0" style="max-width: 650px; margin: 0 auto;">
                    Seluruh dokumen pembelajaran Kurikulum Merdeka (Pendekatan Pembelajaran Mendalam / Deep Learning) 
                    telah selesai dirangkai secara otomatis dan disimpan ke database Anda.
                </p>
            </div>
        </div>

        <!-- GENERATED DOCUMENTS LIST WITH DIRECT EXPORTS -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <div class="fw-bold text-dark fs-6">
                    <i class="bi bi-folder-check text-success me-2"></i> Dokumen yang Telah Tersedia:
                </div>
            </div>
            <div class="card-body p-4">
                <div class="list-group list-group-flush gap-3">
                    <!-- 1. ATP -->
                    <div class="list-group-item border rounded-3 p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-3 bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-diagram-3 fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Alur Tujuan Pembelajaran (ATP)</div>
                                <div class="text-muted small">Rangkaian tujuan pembelajaran terurut, alokasi waktu, asesmen, dan 8 dimensi Profil Lulusan.</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <a href="{{ route('atp.show', $atpId) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li><h6 class="dropdown-header">Ukuran Kertas</h6></li>
                                    <li><a class="dropdown-item py-1" href="{{ route('export.atp.pdf', $atpId) }}?paper=a4"><i class="bi bi-file-text me-2 text-danger"></i> PDF (A4 Standar)</a></li>
                                    <li><a class="dropdown-item py-1" href="{{ route('export.atp.pdf', $atpId) }}?paper=f4"><i class="bi bi-file-text me-2 text-primary"></i> PDF (F4 / Folio)</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('export.atp.excel', $atpId) }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-file-earmark-excel"></i> Excel
                            </a>
                            <a href="{{ route('export.atp.docx', $atpId) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-word"></i> Word
                            </a>
                        </div>
                    </div>

                    <!-- 2. MODUL AJAR -->
                    <div class="list-group-item border rounded-3 p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-3 bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-journal-richtext fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Modul Ajar Deep Learning (Alur PEDATTI)</div>
                                <div class="text-muted small">Langkah pembelajaran (Pendahuluan-Dalami-Terapkan-Tularkan-Inovasi) dan 4 proses olah holistik.</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <a href="{{ route('modul-ajar.show', $modulId) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li><h6 class="dropdown-header">Ukuran Kertas</h6></li>
                                    <li><a class="dropdown-item py-1" href="{{ route('export.modul-ajar.pdf', $modulId) }}?paper=a4"><i class="bi bi-file-text me-2 text-danger"></i> PDF (A4 Standar)</a></li>
                                    <li><a class="dropdown-item py-1" href="{{ route('export.modul-ajar.pdf', $modulId) }}?paper=f4"><i class="bi bi-file-text me-2 text-primary"></i> PDF (F4 / Folio)</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('export.modul-ajar.docx', $modulId) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-word"></i> Word
                            </a>
                        </div>
                    </div>

                    <!-- 3. LKPD -->
                    <div class="list-group-item border rounded-3 p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-3 bg-info bg-opacity-10 text-info">
                                <i class="bi bi-file-earmark-text fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Lembar Kerja Murid (LKPD)</div>
                                <div class="text-muted small">Stimulus otentik industri dengan 3 tahapan pengalaman belajar (Memahami, Mengaplikasi, Merefleksi).</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <a href="{{ route('lkpd.show', $lkpdId) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li><h6 class="dropdown-header">Ukuran Kertas</h6></li>
                                    <li><a class="dropdown-item py-1" href="{{ route('export.lkpd.pdf', $lkpdId) }}?paper=a4"><i class="bi bi-file-text me-2 text-danger"></i> PDF (A4 Standar)</a></li>
                                    <li><a class="dropdown-item py-1" href="{{ route('export.lkpd.pdf', $lkpdId) }}?paper=f4"><i class="bi bi-file-text me-2 text-primary"></i> PDF (F4 / Folio)</a></li>
                                </ul>
                            </div>
                            <a href="{{ route('export.lkpd.docx', $lkpdId) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-word"></i> Word
                            </a>
                        </div>
                    </div>

                    <!-- 4. PROGRAM TAHUNAN (PROTA) -->
                    <div class="list-group-item border rounded-3 p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-3 bg-secondary bg-opacity-10 text-secondary">
                                <i class="bi bi-calendar-check fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Program Tahunan (Prota)</div>
                                <div class="text-muted small">Rencana distribusi alokasi waktu tahunan seluruh elemen dan TP per semester (Permendikdasmen No. 13/2025).</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            @if(!empty($protaId))
                                <a href="{{ route('prota.show', $protaId) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><h6 class="dropdown-header">Ukuran Kertas</h6></li>
                                        <li><a class="dropdown-item py-1" href="{{ route('export.prota.pdf', $protaId) }}?paper=a4"><i class="bi bi-file-text me-2 text-danger"></i> PDF (A4 Standar)</a></li>
                                        <li><a class="dropdown-item py-1" href="{{ route('export.prota.pdf', $protaId) }}?paper=f4"><i class="bi bi-file-text me-2 text-primary"></i> PDF (F4 / Folio)</a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('export.prota.excel', $protaId) }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-file-earmark-excel"></i> Excel
                                </a>
                                <a href="{{ route('export.prota.docx', $protaId) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark-word"></i> Word
                                </a>
                            @else
                                <a href="{{ route('prota-promes.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i> Buka Prota
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- 5. PROGRAM SEMESTER (PROMES) -->
                    <div class="list-group-item border rounded-3 p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-3 bg-secondary bg-opacity-10 text-secondary">
                                <i class="bi bi-calendar-week fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Program Semester (Promes)</div>
                                <div class="text-muted small">Matriks jadwal mingguan dan alokasi jam pembelajaran per bulan pada minggu efektif belajar.</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            @if(!empty($promesId))
                                <a href="{{ route('promes.show', $promesId) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><h6 class="dropdown-header">Ukuran Kertas</h6></li>
                                        <li><a class="dropdown-item py-1" href="{{ route('export.promes.pdf', $promesId) }}?paper=a4"><i class="bi bi-file-text me-2 text-danger"></i> PDF (A4 Standar)</a></li>
                                        <li><a class="dropdown-item py-1" href="{{ route('export.promes.pdf', $promesId) }}?paper=f4"><i class="bi bi-file-text me-2 text-primary"></i> PDF (F4 / Folio)</a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('export.promes.excel', $promesId) }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-file-earmark-excel"></i> Excel
                                </a>
                                <a href="{{ route('export.promes.docx', $promesId) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark-word"></i> Word
                                </a>
                            @else
                                <a href="{{ route('prota-promes.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i> Buka Promes
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- 6. INSTRUMEN ASESMEN -->
                    <div class="list-group-item border rounded-3 p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-3 bg-dark bg-opacity-10 text-dark">
                                <i class="bi bi-check2-square fs-4"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Instrumen & Rubrik Asesmen</div>
                                <div class="text-muted small">Asesmen Awal, Formatif (Rubrik KKTP 4 Level), dan Sumatif (Job Sheet Vokasi K/BK).</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            @if(!empty($asesmenId))
                                <a href="{{ route('asesmen.show', $asesmenId) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li><h6 class="dropdown-header">Ukuran Kertas</h6></li>
                                        <li><a class="dropdown-item py-1" href="{{ route('export.asesmen.pdf', $asesmenId) }}?paper=a4"><i class="bi bi-file-text me-2 text-danger"></i> PDF (A4 Standar)</a></li>
                                        <li><a class="dropdown-item py-1" href="{{ route('export.asesmen.pdf', $asesmenId) }}?paper=f4"><i class="bi bi-file-text me-2 text-primary"></i> PDF (F4 / Folio)</a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('export.asesmen.docx', $asesmenId) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark-word"></i> Word
                                </a>
                            @else
                                <a href="{{ route('asesmen.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye"></i> Buka Asesmen
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('generator.index') }}" class="btn btn-outline-primary rounded-pill px-4 me-2">
                        <i class="bi bi-plus-circle me-1"></i> Generate Mata Pelajaran Lain
                    </a>
                    <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="btn btn-light border rounded-pill px-4">
                        {{ auth()->check() ? 'Kembali ke Dashboard' : 'Masuk / Login' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
