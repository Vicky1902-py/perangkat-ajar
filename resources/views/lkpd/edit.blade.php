@extends('layouts.app')

@section('title', 'Edit LKPD: ' . $lkpd->judul)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-11">
        <!-- HEADER -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-warning bg-opacity-15 text-warning border border-warning border-opacity-25 px-2.5 py-1 rounded-pill small fw-bold">
                        <i class="bi bi-pencil-square me-1"></i> EDIT LEMBAR KERJA
                    </span>
                    <span class="badge bg-success bg-opacity-15 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill small fw-bold">
                        <i class="bi bi-robot me-1"></i> Vx Agent Ready
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-text text-info"></i> Edit Lembar Kerja Murid (LKPD) Deep Learning
                </h3>
                <p class="text-muted small mb-0">
                    Sesuaikan stimulus kasus nyata, petunjuk belajar, dan tahapan kerja murid. Gunakan <strong>Vx Agent</strong> untuk melengkapi studi kasus industri secara instan.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('lkpd.show', $lkpd->id) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali ke Tampilan
                </a>
            </div>
        </div>

        <form action="{{ route('lkpd.update', $lkpd->id) }}" method="POST" id="formEditLkpd">
            @csrf
            @method('PUT')

            <!-- Hidden input untuk konteks Mapel & Fase bagi Vx Agent -->
            <input type="hidden" id="agent_mapel_id" value="{{ $lkpd->mata_pelajaran_id }}">
            <input type="hidden" id="agent_fase_id" value="{{ $lkpd->fase_id }}">

            <!-- 1. IDENTITAS LKPD -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle text-primary"></i> I. Identitas Lembar Kerja Murid
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-secondary">Judul LKPD <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" name="judul" value="{{ old('judul', $lkpd->judul) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-secondary">Alokasi Waktu (Menit)</label>
                            <input type="number" class="form-control rounded-3" name="alokasi_waktu_menit" value="{{ old('alokasi_waktu_menit', $lkpd->alokasi_waktu_menit ?? 90) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select class="form-select rounded-3" name="mata_pelajaran_id" required>
                                @foreach($mapels as $mapel)
                                    <option value="{{ $mapel->id }}" {{ $lkpd->mata_pelajaran_id == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->nama }} ({{ ucfirst($mapel->kelompok) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Fase <span class="text-danger">*</span></label>
                            <select class="form-select rounded-3" name="fase_id" required>
                                @foreach($fases as $fase)
                                    <option value="{{ $fase->id }}" {{ $lkpd->fase_id == $fase->id ? 'selected' : '' }}>
                                        Fase {{ $fase->kode }} (Kelas {{ $fase->tingkat_kelas }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. TUJUAN & STIMULUS OTENTIK KASUS NYATA -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-lightbulb text-warning"></i> II. Tujuan & Stimulus Kasus Nyata Industri
                    </h6>
                    <button type="button" class="btn btn-sm text-white rounded-pill px-3 py-1 shadow-sm d-flex align-items-center gap-1.5 btn-vx-assist" 
                            style="background-color: #059669;"
                            data-target="stimulus_otentik" data-type="stimulus_lkpd" data-label="Stimulus Otentik Kasus Nyata">
                        <i class="bi bi-robot"></i> ✨ Buatkan Kasus Otentik via Vx Agent
                    </button>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Tujuan Pembelajaran pada LKPD</label>
                        <textarea class="form-control rounded-3" name="tujuan_pembelajaran" rows="2">{{ old('tujuan_pembelajaran', $lkpd->tujuan_pembelajaran) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Stimulus Kasus Otentik (Wacana / Studi Kasus Dunia Kerja)</label>
                        <textarea class="form-control rounded-3" id="stimulus_otentik" name="stimulus_otentik" rows="5">{{ old('stimulus_otentik', $lkpd->stimulus_otentik) }}</textarea>
                        <small class="text-muted">Kisah nyata atau skenario pemecahan masalah yang memantik daya kritis murid.</small>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Petunjuk Belajar Murid</label>
                            <textarea class="form-control rounded-3" name="petunjuk_belajar" rows="3">{{ old('petunjuk_belajar', $lkpd->petunjuk_belajar) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Alat &amp; Bahan Praktikum / Belajar</label>
                            <textarea class="form-control rounded-3" name="alat_bahan" rows="3">{{ old('alat_bahan', $lkpd->alat_bahan) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. TAHAPAN PENGALAMAN KERJA MURID (3 TAHAPAN DEEP LEARNING) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-list-task text-primary"></i> III. Tiga Tahapan Pengalaman Belajar Murid
                    </h6>
                </div>
                <div class="card-body pt-0">
                    @foreach($lkpd->kegiatans->sortBy('urutan') as $keg)
                        <div class="border rounded-3 p-3 mb-3 bg-light">
                            <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                                <span class="badge bg-primary px-2.5 py-1">Tahap {{ $keg->urutan }}: {{ $keg->tahap }}</span>
                                <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-2.5 py-0.5 btn-vx-assist" 
                                        data-target="instruksi_{{ $keg->id }}" data-type="kegiatan_pedatti" data-label="Instruksi {{ $keg->tahap }}">
                                    <i class="bi bi-robot me-1"></i> ✨ Lengkapi via Vx Agent
                                </button>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold text-secondary mb-1">Instruksi Kerja & Penugasan:</label>
                                <textarea class="form-control rounded-3" id="instruksi_{{ $keg->id }}" name="kegiatans[{{ $keg->id }}][instruksi]" rows="3">{{ old("kegiatans.{$keg->id}.instruksi", $keg->instruksi) }}</textarea>
                            </div>
                            <div>
                                <label class="form-label small fw-bold text-secondary mb-1">Pertanyaan Analitis / Tantangan Solusi:</label>
                                <textarea class="form-control rounded-3" name="kegiatans[{{ $keg->id }}][pertanyaan]" rows="2">{{ old("kegiatans.{$keg->id}.pertanyaan", $keg->pertanyaan) }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 4. RUBRIK PENILAIAN -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-check2-square text-success"></i> IV. Rubrik Penilaian Kinerja Murid
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 btn-vx-assist"
                            data-target="rubrik_penilaian" data-type="rubrik" data-label="Rubrik Penilaian LKPD">
                        <i class="bi bi-robot me-1"></i> ✨ Susun Rubrik via Vx Agent
                    </button>
                </div>
                <div class="card-body pt-0">
                    <textarea class="form-control rounded-3" id="rubrik_penilaian" name="rubrik_penilaian" rows="5">{{ old('rubrik_penilaian', $lkpd->rubrik_penilaian) }}</textarea>
                </div>
            </div>

            <!-- TOMBOL SIMPAN -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-body p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <a href="{{ route('lkpd.show', $lkpd->id) }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                        <i class="bi bi-check-circle-fill me-1"></i> Simpan Perubahan LKPD
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL ASSISTANT: VX AGENT AUTO-COMPLETE INTERAKTIF -->
<!-- ============================================================== -->
<div class="modal fade" id="modalVxAgent" tabindex="-1" aria-labelledby="modalVxAgentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <span class="p-2 rounded-3 text-white d-inline-flex align-items-center justify-content-center" style="background-color: #76b900;">
                        <i class="bi bi-robot fs-5"></i>
                    </span>
                    <div>
                        <h6 class="modal-title fw-bold text-dark mb-0" id="modalVxAgentLabel">Vx Agent &bull; Asisten Pelengkap LKPD</h6>
                        <small class="text-muted" id="modalTargetLabel">Melengkapi seksi...</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <!-- FORM PERINTAH DARI GURU -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">
                        Apa konteks atau kasus khusus yang ingin Anda tambahkan ke LKPD ini?
                    </label>
                    <textarea class="form-control rounded-3" id="agentPromptInput" rows="3" 
                              placeholder="Contoh: Buatkan studi kasus masalah jaringan putus-nyambung di kantor cabang bank lokal..."></textarea>
                </div>

                <!-- PILIHAN MODE AKSI -->
                <div class="mb-3 p-2.5 rounded-3 bg-light border d-flex align-items-center gap-4 flex-wrap">
                    <span class="small fw-bold text-secondary">Mode Penyisipan:</span>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="agentActionMode" id="modeAppend" value="append" checked>
                        <label class="form-check-label small fw-semibold" for="modeAppend">
                            Sisipkan di Bawah Teks yang Ada (Append)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="agentActionMode" id="modeReplace" value="replace">
                        <label class="form-check-label small fw-semibold" for="modeReplace">
                            Gantikan Teks Bagian Ini (Replace)
                        </label>
                    </div>
                </div>

                <!-- TOMBOL EKSEKUSI AGENT -->
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn text-white rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2" id="btnExecuteAgent" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="bi bi-stars"></i>
                        <span>Susun Otomatis via Vx Agent</span>
                    </button>
                </div>

                <!-- LOADING INDICATOR -->
                <div id="agentLoading" class="text-center py-4 my-2" style="display: none;">
                    <div class="spinner-border text-success mb-2" role="status"></div>
                    <div class="small fw-bold text-dark">Vx Agent sedang menyusun narasi LKPD kontekstual...</div>
                    <small class="text-muted">Bebas halusinasi &bull; Terikat Capaian Pembelajaran &bull; Berorientasi Murid</small>
                </div>

                <!-- PREVIEW HASIL DARI AGENT -->
                <div id="agentPreviewContainer" style="display: none;">
                    <label class="form-label small fw-bold text-success d-flex align-items-center gap-1.5">
                        <i class="bi bi-check2-circle fs-6"></i> Pratinjau Hasil Vx Agent:
                    </label>
                    <div class="p-3 bg-light rounded-3 border text-dark mb-3" id="agentPreviewText" style="font-size: 0.9rem; line-height: 1.6; white-space: pre-line; max-height: 250px; overflow-y: auto;">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" id="btnApplyAgentText" style="display: none;">
                    <i class="bi bi-check2-all me-1"></i> Terapkan ke LKPD
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentTargetId = '';
    let currentFieldType = '';
    let generatedResultText = '';
    let combinedResultText = '';

    const modalElement = document.getElementById('modalVxAgent');
    const modal = new bootstrap.Modal(modalElement);
    const targetLabel = document.getElementById('modalTargetLabel');
    const promptInput = document.getElementById('agentPromptInput');
    const btnExecute = document.getElementById('btnExecuteAgent');
    const btnApply = document.getElementById('btnApplyAgentText');
    const loadingBox = document.getElementById('agentLoading');
    const previewBox = document.getElementById('agentPreviewContainer');
    const previewText = document.getElementById('agentPreviewText');

    // Klik tombol ✨ Lengkapi via Vx Agent
    document.querySelectorAll('.btn-vx-assist').forEach(btn => {
        btn.addEventListener('click', function() {
            currentTargetId = this.getAttribute('data-target');
            currentFieldType = this.getAttribute('data-type');
            const label = this.getAttribute('data-label') || 'Seksi LKPD';

            targetLabel.innerText = `Melengkapi: ${label}`;
            promptInput.value = '';
            previewBox.style.display = 'none';
            btnApply.style.display = 'none';
            loadingBox.style.display = 'none';
            btnExecute.disabled = false;

            modal.show();
        });
    });

    // Eksekusi Pembuatan oleh Vx Agent
    btnExecute.addEventListener('click', function() {
        const instruksi = promptInput.value.trim();
        if (!instruksi) {
            alert('Mohon tuliskan arahan atau konteks yang ingin Anda tambahkan.');
            return;
        }

        const mapelId = document.getElementById('agent_mapel_id').value;
        const faseId = document.getElementById('agent_fase_id').value;
        const currentTargetField = document.getElementById(currentTargetId);
        const currentVal = currentTargetField ? currentTargetField.value : '';
        const actionMode = document.querySelector('input[name="agentActionMode"]:checked').value;

        loadingBox.style.display = 'block';
        previewBox.style.display = 'none';
        btnApply.style.display = 'none';
        btnExecute.disabled = true;

        fetch("{{ route('vx-agent.complete-field') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                field_type: currentFieldType,
                instruksi: instruksi,
                mata_pelajaran_id: mapelId,
                fase_id: faseId,
                current_text: currentVal,
                action_mode: actionMode
            })
        })
        .then(res => res.json())
        .then(data => {
            loadingBox.style.display = 'none';
            btnExecute.disabled = false;

            if (data.success) {
                generatedResultText = data.generated_text;
                combinedResultText = data.combined_text;
                previewText.innerText = generatedResultText;
                previewBox.style.display = 'block';
                btnApply.style.display = 'inline-block';
            } else {
                alert(data.message || 'Gagal menyusun teks.');
            }
        })
        .catch(err => {
            loadingBox.style.display = 'none';
            btnExecute.disabled = false;
            alert('Terjadi kesalahan jaringan atau waktu habis.');
        });
    });

    // Terapkan Hasil ke Input Form
    btnApply.addEventListener('click', function() {
        const currentTargetField = document.getElementById(currentTargetId);
        if (currentTargetField) {
            const actionMode = document.querySelector('input[name="agentActionMode"]:checked').value;
            if (actionMode === 'append') {
                currentTargetField.value = combinedResultText;
            } else {
                currentTargetField.value = generatedResultText;
            }

            // Highlight animasi sebentar
            currentTargetField.style.transition = 'all 0.5s ease';
            currentTargetField.style.backgroundColor = '#dcfce7';
            setTimeout(() => {
                currentTargetField.style.backgroundColor = '';
            }, 1200);

            modal.hide();
        }
    });
});
</script>
@endpush
