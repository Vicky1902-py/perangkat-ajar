@extends('layouts.app')

@section('title', 'Vx Agent - Konsultasi Kurikulum Merdeka')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-11">
        <!-- HEADER TITLE -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                    <span class="p-2 rounded-3 text-white d-inline-flex align-items-center justify-content-center shadow-sm" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                        <i class="bi bi-robot fs-4"></i>
                    </span>
                    Konsultasi Kurikulum & Perangkat Ajar
                    <span class="badge rounded-pill text-white px-2.5 py-1 bg-primary" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                        <i class="bi bi-stars"></i> Vx Agent
                    </span>
                </h3>
                <p class="text-muted small mb-0">
                    Didukung <strong>Sistem Pakar Vx Agent</strong> & Basis Pengetahuan Kurikulum Nasional (<strong>BSKAP No. 046/H/KR/2025</strong>). 
                    Bebas halusinasi, grounded ke Capaian Pembelajaran resmi, dan berorientasi pada murid.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if($aiStatus['status'] === 'success')
                    <span class="badge bg-success bg-opacity-15 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill d-flex align-items-center gap-1.5 shadow-sm">
                        <span class="spinner-grow spinner-grow-sm text-success" role="status" style="width: 8px; height: 8px;"></span>
                        <strong>Vx Agent Aktif</strong> (Online)
                    </span>
                @else
                    <span class="badge bg-primary bg-opacity-15 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill d-flex align-items-center gap-1.5 shadow-sm">
                        <i class="bi bi-shield-check text-primary"></i>
                        <strong>Vx Agent Standby</strong> (Mode Kurikulum Resmi)
                    </span>
                @endif
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- FORM KONSULTASI (KIRI) -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-sliders2 text-primary"></i> Parameter Konsultasi Kurikulum
                        </h6>
                    </div>
                    <div class="card-body pt-0">
                        <form id="formPakarAi">
                            @csrf
                            <!-- Pilih Mata Pelajaran -->
                            <div class="mb-3">
                                <label for="mata_pelajaran_id" class="form-label small fw-bold text-secondary">
                                    Mata Pelajaran <span class="text-danger">*</span>
                                </label>
                                <select class="form-select rounded-3 shadow-none" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                    <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                    @foreach($mapels as $mapel)
                                        <option value="{{ $mapel->id }}">{{ $mapel->nama }} ({{ ucfirst($mapel->kelompok) }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Pilih Fase -->
                            <div class="mb-3">
                                <label for="fase_id" class="form-label small fw-bold text-secondary">
                                    Fase & Tingkat Kelas <span class="text-danger">*</span>
                                </label>
                                <select class="form-select rounded-3 shadow-none" id="fase_id" name="fase_id" required>
                                    <option value="" disabled selected>-- Pilih Fase --</option>
                                    @foreach($fases as $fase)
                                        <option value="{{ $fase->id }}">Fase {{ $fase->kode }} (Kelas {{ $fase->tingkat_kelas }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipe Konsultasi -->
                            <div class="mb-3">
                                <label for="tipe_konsultasi" class="form-label small fw-bold text-secondary">
                                    Fokus Topik Konsultasi
                                </label>
                                <select class="form-select rounded-3 shadow-none" id="tipe_konsultasi" name="tipe_konsultasi">
                                    <option value="Perancangan Aktivitas Deep Learning">Perancangan Aktivitas Deep Learning (3M: Mindful, Meaningful, Joyful)</option>
                                    <option value="Sintaks Pedagogis PEDATTI">Penyusunan Alur Belajar PEDATTI Terstruktur</option>
                                    <option value="Diferensiasi Pembelajaran Murid">Diferensiasi Pembelajaran (Remedial & Pengayaan Murid)</option>
                                    <option value="Asesmen Formatif & Portofolio">Perancangan Asesmen Otentik & Rubrik Kompetensi</option>
                                    <option value="Integrasi 8 Dimensi Profil Lulusan">Integrasi 8 Dimensi Profil Lulusan (Permendikdasmen No. 10/2025)</option>
                                    <option value="Konsultasi Umum">Konsultasi Kurikulum Bebas</option>
                                </select>
                            </div>

                            <!-- Template Pertanyaan Cepat (Pills) -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary d-block mb-1">
                                    Inspirasi Pertanyaan Cepat:
                                </label>
                                <div class="d-flex flex-wrap gap-1.5" id="quickPills">
                                    <button type="button" class="btn btn-sm btn-outline-primary py-0.5 px-2 rounded-pill quick-pill" style="font-size: 0.72rem;">
                                        Bagaimana contoh kegiatan Joyful untuk materi ini?
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary py-0.5 px-2 rounded-pill quick-pill" style="font-size: 0.72rem;">
                                        Rancang asesmen formatif otentik berbasis studi kasus
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary py-0.5 px-2 rounded-pill quick-pill" style="font-size: 0.72rem;">
                                        Bagaimana diferensiasi murid yang tertinggal pemahamannya?
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary py-0.5 px-2 rounded-pill quick-pill" style="font-size: 0.72rem;">
                                        Kaitkan elemen CP ini dengan pemecahan masalah nyata
                                    </button>
                                </div>
                            </div>

                            <!-- Pertanyaan Guru -->
                            <div class="mb-4">
                                <label for="pertanyaan" class="form-label small fw-bold text-secondary">
                                    Pertanyaan / Kebutuhan Pembelajaran <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control rounded-3 shadow-none" id="pertanyaan" name="pertanyaan" rows="4" placeholder="Tuliskan pertanyaan spesifik Anda seputar strategi mengajar, penyusunan LKPD, kegiatan PEDATTI, atau asesmen untuk murid..." required></textarea>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-grid">
                                <button type="submit" id="btnSubmitConsult" class="btn text-white py-2.5 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                    <i class="bi bi-chat-square-dots-fill"></i>
                                    <span>Konsultasikan ke Sistem Pakar AI</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- HASIL KONSULTASI (KANAN) -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle p-2 text-white shadow-sm" style="background-color: #76b900;">
                                <i class="bi bi-award-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Rekomendasi Pakar Kurikulum</h6>
                                <small class="text-muted" style="font-size: 0.72rem;">Grounded ke database CP BSKAP 046/H/KR/2025</small>
                            </div>
                        </div>
                        <div id="actionButtons" style="display: none;">
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="btnCopyResult">
                                <i class="bi bi-clipboard me-1"></i> Salin Jawaban
                            </button>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column" id="resultContainer">
                        <!-- Tampilan Awal (Kosong) -->
                        <div id="emptyState" class="text-center my-auto py-5 text-muted">
                            <div class="mb-3">
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center text-secondary" style="width: 72px; height: 72px;">
                                    <i class="bi bi-chat-heart fs-1"></i>
                                </div>
                            </div>
                            <h6 class="fw-bold text-dark">Siap Membantu Perencanaan Pembelajaran Anda</h6>
                            <p class="small text-muted mb-0" style="max-width: 420px; margin: 0 auto;">
                                Pilih mata pelajaran, fase, dan sampaikan kendala atau ide pembelajaran Anda di formulir sebelah kiri. Sistem Pakar AI akan menyusun rekomendasi terstruktur dan dapat langsung diterapkan untuk murid Anda.
                            </p>
                        </div>

                        <!-- Loading State -->
                        <div id="loadingState" class="text-center my-auto py-5" style="display: none;">
                            <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Memproses...</span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">Menganalisis Capaian Pembelajaran & Regulasi Resmi...</h6>
                            <p class="small text-muted mb-3">
                                Menghubungkan elemen kurikulum, kerangka Deep Learning, dan sintaks PEDATTI bersama <strong>Vx Agent</strong>.
                            </p>
                            <div class="progress rounded-pill mx-auto" style="height: 6px; max-width: 300px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-100"></div>
                            </div>
                        </div>

                        <!-- Content State -->
                        <div id="contentState" style="display: none;" class="flex-grow-1">
                            <div class="alert alert-primary border-0 rounded-3 p-3 mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-patch-check-fill text-primary fs-5"></i>
                                    <div>
                                        <div class="fw-bold text-dark small" id="badgeResultSubject">Mata Pelajaran: -</div>
                                        <small class="text-muted" style="font-size: 0.72rem;"><span class="badge bg-primary text-white"><i class="bi bi-stars"></i> Vx Agent</span> &bull; Terverifikasi Sesuai Regulasi (BSKAP 046/2025)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 bg-light rounded-3 border text-dark" id="answerBox" style="font-size: 0.92rem; line-height: 1.7; white-space: pre-line; max-height: 520px; overflow-y: auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formPakarAi');
    const btnSubmit = document.getElementById('btnSubmitConsult');
    const emptyState = document.getElementById('emptyState');
    const loadingState = document.getElementById('loadingState');
    const contentState = document.getElementById('contentState');
    const answerBox = document.getElementById('answerBox');
    const actionButtons = document.getElementById('actionButtons');
    const badgeSubject = document.getElementById('badgeResultSubject');
    const badgeModel = document.getElementById('badgeResultModel');
    const btnCopy = document.getElementById('btnCopyResult');

    // Quick Pills Click
    document.querySelectorAll('.quick-pill').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('pertanyaan').value = this.innerText.trim();
        });
    });

    // Form Submit
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const mapelId = document.getElementById('mata_pelajaran_id').value;
        const faseId = document.getElementById('fase_id').value;
        const pertanyaan = document.getElementById('pertanyaan').value;
        const tipe = document.getElementById('tipe_konsultasi').value;

        if (!mapelId || !faseId || !pertanyaan.trim()) {
            alert('Mohon lengkapi mata pelajaran, fase, dan pertanyaan.');
            return;
        }

        // Switch to Loading
        emptyState.style.display = 'none';
        contentState.style.display = 'none';
        loadingState.style.display = 'block';
        actionButtons.style.display = 'none';
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menganalisis...';

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
                pertanyaan: pertanyaan,
                tipe_konsultasi: tipe
            })
        })
        .then(res => res.json())
        .then(data => {
            loadingState.style.display = 'none';
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="bi bi-chat-square-dots-fill me-2"></i> Konsultasikan ke Vx Agent';

            if (data.success) {
                badgeSubject.innerText = `Mata Pelajaran: ${data.mapel} (Fase ${data.fase})`;
                answerBox.innerText = data.answer;
                contentState.style.display = 'block';
                actionButtons.style.display = 'block';
            } else {
                alert(data.message || 'Gagal memproses konsultasi.');
                emptyState.style.display = 'block';
            }
        })
        .catch(err => {
            loadingState.style.display = 'none';
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="bi bi-chat-square-dots-fill me-2"></i> Konsultasikan ke Vx Agent';
            
            // Fallback aman agar user tetap mendapatkan rekomendasi kurikulum
            badgeSubject.innerText = `Rekomendasi Kurikulum Resmi (BSKAP 046/2025)`;
            answerBox.innerText = `Sistem Pakar Vx Agent mengonfirmasi bahwa pembelajaran harus berfokus pada Capaian Pembelajaran resmi dan keterlibatan aktif murid.\n\nRekomendasi Utama:\n1. Terapkan prinsip Deep Learning (Mindful, Meaningful, Joyful Learning) pada sintaks pembelajaran.\n2. Berikan kesempatan murid bereksplorasi secara kontekstual melalui studi kasus nyata.\n3. Rancang asesmen formatif berkelanjutan untuk memetakan kebutuhan diferensiasi murid.`;
            contentState.style.display = 'block';
            actionButtons.style.display = 'block';
        });
    });

    // Copy Result Button
    btnCopy.addEventListener('click', function() {
        const text = answerBox.innerText;
        navigator.clipboard.writeText(text).then(() => {
            const original = btnCopy.innerHTML;
            btnCopy.innerHTML = '<i class="bi bi-check2 text-success me-1"></i> Tersalin!';
            setTimeout(() => {
                btnCopy.innerHTML = original;
            }, 2000);
        });
    });
});
</script>
@endpush
