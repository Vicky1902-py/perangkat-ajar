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
                            <a href="{{ route('modul-ajar.edit', $modulId) }}" class="btn btn-sm btn-outline-warning text-dark fw-semibold">
                                <i class="bi bi-pencil-square"></i> Edit
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
                            <a href="{{ route('lkpd.edit', $lkpdId) }}" class="btn btn-sm btn-outline-warning text-dark fw-semibold">
                                <i class="bi bi-pencil-square"></i> Edit
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

<!-- ============================================================== -->
<!-- FLOATING NOTIFIKASI OBROLAN: VX AGENT CURRICULUM ASSISTANT -->
<!-- ============================================================== -->
<div id="vxAgentFloatingWidget" class="card border-0 shadow-lg rounded-4 position-fixed" 
     style="bottom: 24px; right: 24px; width: 380px; max-width: calc(100vw - 32px); z-index: 1050; background: #ffffff; border: 1.5px solid #10b981 !important; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.25) !important; animation: vxSlideUp 0.5s ease-out;">
    
    <!-- HEADER WIDGET -->
    <div class="card-header border-0 py-2.5 px-3 rounded-top-4 d-flex align-items-center justify-content-between text-white" 
         style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                <i class="bi bi-robot fs-5"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0 text-white" style="font-size: 0.88rem;">Vx Agent</h6>
                <div class="d-flex align-items-center gap-1 text-white text-opacity-90" style="font-size: 0.68rem;">
                    <span class="rounded-circle bg-white" style="width: 6px; height: 6px; display: inline-block;"></span>
                    <span>Online &bull; Asisten Kurikulum Pintar</span>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-1">
            <button type="button" class="btn btn-sm btn-link text-white p-0 text-decoration-none" id="btnToggleVxBody" title="Perkecil">
                <i class="bi bi-dash-lg fs-5"></i>
            </button>
            <button type="button" class="btn btn-sm btn-link text-white p-0 ms-1 text-decoration-none" id="btnCloseVxWidget" title="Tutup">
                <i class="bi bi-x-lg fs-6"></i>
            </button>
        </div>
    </div>

    <!-- BODY WIDGET (BUBBLE NOTIFIKASI) -->
    <div class="card-body p-3" id="vxWidgetBody">
        <div class="d-flex align-items-start gap-2 mb-3">
            <div class="p-2 rounded-3 bg-light border text-dark small" style="line-height: 1.55; font-size: 0.85rem;">
                👋 <strong>Halo Bapak/Ibu Guru!</strong> Seluruh perangkat ajar telah tersusun berdasar standar <strong>BSKAP No. 046/H/KR/2025</strong>.<br><br>
                Jika ada materi yang ingin ditambahkan, alur kegiatan disesuaikan, atau butuh saran pengayaan, <strong>Anda bisa langsung konsultasi dengan saya</strong> atau gunakan tombol <strong>Edit</strong> untuk melengkapi otomatis tanpa merusak format baku!
            </div>
        </div>

        <div class="d-flex flex-column gap-2">
            <button type="button" class="btn text-white rounded-pill py-2 px-3 fw-bold small shadow-sm d-flex align-items-center justify-content-center gap-2" id="btnOpenVxModal" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="bi bi-chat-dots-fill"></i>
                <span>Konsultasi & Minta Saran ke Vx Agent</span>
            </button>

            <div class="d-flex gap-2">
                @if(!empty($modulId))
                    <a href="{{ route('modul-ajar.edit', $modulId) }}" class="btn btn-outline-warning text-dark btn-sm rounded-pill flex-grow-1 fw-semibold" style="font-size: 0.78rem;">
                        <i class="bi bi-pencil-square me-1"></i> Edit Modul
                    </a>
                @endif
                @if(!empty($lkpdId))
                    <a href="{{ route('lkpd.edit', $lkpdId) }}" class="btn btn-outline-info text-dark btn-sm rounded-pill flex-grow-1 fw-semibold" style="font-size: 0.78rem;">
                        <i class="bi bi-pencil-square me-1"></i> Edit LKPD
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL KONSULTASI CEPAT: VX AGENT (IN-PAGE DIALOG) -->
<!-- ============================================================== -->
<div class="modal fade" id="modalVxQuickConsult" tabindex="-1" aria-labelledby="modalVxQuickConsultLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle p-2 text-white shadow-sm" style="background-color: #76b900;">
                        <i class="bi bi-robot fs-5"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-dark mb-0" id="modalVxQuickConsultLabel">Konsultasi dengan Vx Agent</h6>
                        <small class="text-muted">
                            Mata Pelajaran: <strong>{{ $mapel?->nama ?? 'Umum/Kejuruan' }}</strong> &bull; Fase {{ $fase?->kode ?? 'E/F' }}
                        </small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <!-- FORM PERTANYAAN -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">
                        Apa yang ingin Anda tanyakan atau konsultasikan mengenai hasil perangkat ajar ini?
                    </label>
                    <textarea class="form-control rounded-3" id="quickConsultQuestion" rows="3" 
                              placeholder="Contoh: Bagaimana cara membuat langkah kegiatan 'Terapkan' lebih aplikatif untuk murid yang minat belajarnya rendah?"></textarea>
                </div>

                <!-- PILIHAN INSPIRASI CEPAT -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary d-block mb-1">Pertanyaan Cepat Rekomendasi:</label>
                    <div class="d-flex flex-wrap gap-1.5" id="quickConsultPills">
                        <button type="button" class="btn btn-xs btn-outline-success rounded-pill px-2.5 py-1 quick-c-pill" style="font-size: 0.75rem;">
                            Bagaimana ide kegiatan Joyful untuk materi ini?
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-success rounded-pill px-2.5 py-1 quick-c-pill" style="font-size: 0.75rem;">
                            Saran pengayaan HOTS untuk murid berprestasi
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-success rounded-pill px-2.5 py-1 quick-c-pill" style="font-size: 0.75rem;">
                            Bagaimana strategi bimbingan bagi murid remedial?
                        </button>
                    </div>
                </div>

                <!-- TOMBOL KIRIM KONSULTASI -->
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn text-white rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2" id="btnSubmitQuickConsult" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="bi bi-send-fill"></i>
                        <span>Kirim Pertanyaan ke Vx Agent</span>
                    </button>
                </div>

                <!-- LOADING SPINNER -->
                <div id="quickConsultLoading" class="text-center py-4 my-2" style="display: none;">
                    <div class="spinner-border text-success mb-2" role="status"></div>
                    <div class="small fw-bold text-dark">Vx Agent sedang menganalisis kurikulum & regulasi BSKAP 046/2025...</div>
                    <small class="text-muted">Grounded ke Capaian Pembelajaran resmi &bull; Fokus pada murid</small>
                </div>

                <!-- AREA JAWABAN DARI AGENT -->
                <div id="quickConsultAnswerBox" style="display: none;">
                    <div class="alert alert-success border-0 rounded-3 p-2.5 mb-2 d-flex align-items-center justify-content-between">
                        <div class="small fw-bold text-success d-flex align-items-center gap-1.5">
                            <i class="bi bi-patch-check-fill"></i> Saran Resmi dari Vx Agent:
                        </div>
                        <button type="button" class="btn btn-xs btn-outline-success rounded-pill px-2 py-0.5" id="btnCopyQuickAnswer" style="font-size: 0.72rem;">
                            <i class="bi bi-clipboard"></i> Salin
                        </button>
                    </div>
                    <div class="p-3 bg-light rounded-3 border text-dark" id="quickConsultAnswerText" style="font-size: 0.9rem; line-height: 1.65; white-space: pre-line; max-height: 300px; overflow-y: auto;">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes vxSlideUp {
    from {
        transform: translateY(100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const floatingWidget = document.getElementById('vxAgentFloatingWidget');
    const widgetBody = document.getElementById('vxWidgetBody');
    const btnToggle = document.getElementById('btnToggleVxBody');
    const btnClose = document.getElementById('btnCloseVxWidget');
    const btnOpenModal = document.getElementById('btnOpenVxModal');

    const quickModalElement = document.getElementById('modalVxQuickConsult');
    const quickModal = new bootstrap.Modal(quickModalElement);
    const questionInput = document.getElementById('quickConsultQuestion');
    const btnSubmit = document.getElementById('btnSubmitQuickConsult');
    const loadingBox = document.getElementById('quickConsultLoading');
    const answerBox = document.getElementById('quickConsultAnswerBox');
    const answerText = document.getElementById('quickConsultAnswerText');
    const btnCopy = document.getElementById('btnCopyQuickAnswer');

    // Minimalkan widget
    let isMinimized = false;
    btnToggle.addEventListener('click', function() {
        isMinimized = !isMinimized;
        widgetBody.style.display = isMinimized ? 'none' : 'block';
        btnToggle.innerHTML = isMinimized ? '<i class="bi bi-plus-lg fs-5"></i>' : '<i class="bi bi-dash-lg fs-5"></i>';
    });

    // Tutup widget
    btnClose.addEventListener('click', function() {
        floatingWidget.style.display = 'none';
    });

    // Buka Modal Konsultasi Cepat
    btnOpenModal.addEventListener('click', function() {
        quickModal.show();
    });

    // Quick Pills Click
    document.querySelectorAll('.quick-c-pill').forEach(btn => {
        btn.addEventListener('click', function() {
            questionInput.value = this.innerText.trim();
        });
    });

    // Kirim Konsultasi
    btnSubmit.addEventListener('click', function() {
        const q = questionInput.value.trim();
        if (!q) {
            alert('Mohon ketikkan pertanyaan atau topik yang ingin dikonsultasikan.');
            return;
        }

        const mapelId = "{{ $mapel?->id ?? '' }}";
        const faseId = "{{ $fase?->id ?? '' }}";

        loadingBox.style.display = 'block';
        answerBox.style.display = 'none';
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menganalisis...';

        fetch("{{ route('pakar-ai.consult') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                mata_pelajaran_id: mapelId,
                fase_id: faseId,
                pertanyaan: q,
                tipe_konsultasi: 'Konsultasi Pasca-Generate Perangkat'
            })
        })
        .then(res => res.json())
        .then(data => {
            loadingBox.style.display = 'none';
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="bi bi-send-fill me-1"></i> Kirim Pertanyaan ke Vx Agent';

            if (data.success) {
                answerText.innerText = data.answer;
                answerBox.style.display = 'block';
            } else {
                alert(data.message || 'Gagal memproses konsultasi.');
            }
        })
        .catch(err => {
            loadingBox.style.display = 'none';
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="bi bi-send-fill me-1"></i> Kirim Pertanyaan ke Vx Agent';
            alert('Terjadi kesalahan jaringan atau waktu habis.');
        });
    });

    // Salin Jawaban
    btnCopy.addEventListener('click', function() {
        navigator.clipboard.writeText(answerText.innerText).then(() => {
            const old = btnCopy.innerHTML;
            btnCopy.innerHTML = '<i class="bi bi-check2 text-success me-1"></i> Tersalin!';
            setTimeout(() => {
                btnCopy.innerHTML = old;
            }, 2000);
        });
    });
});
</script>
@endpush
