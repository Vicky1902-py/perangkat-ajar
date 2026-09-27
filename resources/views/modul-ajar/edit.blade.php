@extends('layouts.app')

@section('title', 'Edit Modul Ajar: ' . $modulAjar->judul)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-11">
        <!-- HEADER -->
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-warning bg-opacity-15 text-warning border border-warning border-opacity-25 px-2.5 py-1 rounded-pill small fw-bold">
                        <i class="bi bi-pencil-square me-1"></i> EDIT DOKUMEN RESMI
                    </span>
                    <span class="badge bg-success bg-opacity-15 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill small fw-bold">
                        <i class="bi bi-robot me-1"></i> Vx Agent Ready
                    </span>
                </div>
                <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-journal-richtext text-primary"></i> Edit Modul Ajar Deep Learning
                </h3>
                <p class="text-muted small mb-0">
                    Sesuaikan materi, langkah PEDATTI, dan asesmen. Anda dapat memanfaatkan <strong>Vx Agent</strong> untuk melengkapi narasi secara otomatis tanpa merusak format baku.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('modul-ajar.show', $modulAjar->id) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali ke Tampilan
                </a>
            </div>
        </div>

        <form action="{{ route('modul-ajar.update', $modulAjar->id) }}" method="POST" id="formEditModul">
            @csrf
            @method('PUT')

            <!-- Hidden input untuk konteks Mapel & Fase bagi Vx Agent -->
            <input type="hidden" id="agent_mapel_id" value="{{ $modulAjar->mata_pelajaran_id }}">
            <input type="hidden" id="agent_fase_id" value="{{ $modulAjar->fase_id }}">

            <!-- 1. IDENTITAS MODUL -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle text-primary"></i> I. Identitas & Informasi Umum
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-secondary">Judul Modul Ajar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" name="judul" value="{{ old('judul', $modulAjar->judul) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-secondary">Alokasi Waktu (JP)</label>
                            <input type="number" class="form-control rounded-3" name="alokasi_waktu_jp" value="{{ old('alokasi_waktu_jp', $modulAjar->alokasi_waktu_jp) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select class="form-select rounded-3" name="mata_pelajaran_id" required>
                                @foreach($mapels as $mapel)
                                    <option value="{{ $mapel->id }}" {{ $modulAjar->mata_pelajaran_id == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->nama }} ({{ ucfirst($mapel->kelompok) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-secondary">Fase <span class="text-danger">*</span></label>
                            <select class="form-select rounded-3" name="fase_id" required>
                                @foreach($fases as $fase)
                                    <option value="{{ $fase->id }}" {{ $modulAjar->fase_id == $fase->id ? 'selected' : '' }}>
                                        Fase {{ $fase->kode }} (Kelas {{ $fase->tingkat_kelas }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-secondary">Tahun Ajaran</label>
                            <select class="form-select rounded-3" name="tahun_ajaran_id">
                                <option value="">-- Pilih --</option>
                                @foreach($tahunAjarans as $ta)
                                    <option value="{{ $ta->id }}" {{ $modulAjar->tahun_ajaran_id == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun }} - {{ ucfirst($ta->semester) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Target Murid</label>
                            <input type="text" class="form-control rounded-3" name="target_peserta_didik" value="{{ old('target_peserta_didik', $modulAjar->target_peserta_didik) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Jumlah Pertemuan</label>
                            <input type="number" class="form-control rounded-3" name="jumlah_pertemuan" value="{{ old('jumlah_pertemuan', $modulAjar->jumlah_pertemuan ?? 3) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Kompetensi Awal (Prasyarat Murid)</label>
                            <textarea class="form-control rounded-3" name="kompetensi_awal" rows="2">{{ old('kompetensi_awal', $modulAjar->kompetensi_awal) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-secondary">Sarana & Prasarana</label>
                            <textarea class="form-control rounded-3" name="sarana_prasarana" rows="2">{{ old('sarana_prasarana', $modulAjar->sarana_prasarana) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. TUJUAN, PEMAHAMAN BERMAKNA & PERTANYAAN PEMANTIK -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-lightbulb text-warning"></i> II. Komponen Inti & Deep Learning
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <!-- Pemahaman Bermakna -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1 flex-wrap gap-2">
                            <label class="form-label small fw-bold text-secondary mb-0">Pemahaman Bermakna (Meaningful Learning)</label>
                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-2.5 py-0.5 btn-vx-assist" 
                                    data-target="pemahaman_bermakna" data-type="pemahaman_bermakna" data-label="Pemahaman Bermakna">
                                <i class="bi bi-robot me-1"></i> ✨ Lengkapi via Vx Agent
                            </button>
                        </div>
                        <textarea class="form-control rounded-3" id="pemahaman_bermakna" name="pemahaman_bermakna" rows="3">{{ old('pemahaman_bermakna', $modulAjar->pemahaman_bermakna) }}</textarea>
                    </div>

                    <!-- Pertanyaan Pemantik -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-1 flex-wrap gap-2">
                            <label class="form-label small fw-bold text-secondary mb-0">Pertanyaan Pemantik (Mindful & Critical Thinking)</label>
                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-2.5 py-0.5 btn-vx-assist" 
                                    data-target="pertanyaan_pemantik" data-type="pertanyaan_pemantik" data-label="Pertanyaan Pemantik">
                                <i class="bi bi-robot me-1"></i> ✨ Lengkapi via Vx Agent
                            </button>
                        </div>
                        <textarea class="form-control rounded-3" id="pertanyaan_pemantik" name="pertanyaan_pemantik" rows="3">{{ old('pertanyaan_pemantik', $modulAjar->pertanyaan_pemantik) }}</textarea>
                    </div>

                    <!-- 8 Dimensi Profil Lulusan -->
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-secondary d-block mb-1">
                            8 Dimensi Profil Lulusan yang Dikembangkan (Permendikdasmen No. 10/2025):
                        </label>
                        <div class="row g-2">
                            @php
                                $selectedProfilIds = $modulAjar->profilLulusans->pluck('id')->toArray();
                            @endphp
                            @foreach($profilLulusans as $profil)
                                <div class="col-md-6 col-lg-3">
                                    <div class="form-check p-2 rounded-3 border bg-light">
                                        <input class="form-check-input ms-1" type="checkbox" name="profil_lulusan_ids[]" value="{{ $profil->id }}" id="profil_{{ $profil->id }}"
                                            {{ in_array($profil->id, $selectedProfilIds) ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-semibold ms-1" for="profil_{{ $profil->id }}">
                                            {{ $profil->dimensi }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. BAHAN AJAR / RANGKUMAN MATERI -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-book text-success"></i> III. Bahan Ajar & Rangkuman Materi Pembelajaran
                    </h6>
                    <button type="button" class="btn btn-sm text-white rounded-pill px-3 py-1 shadow-sm d-flex align-items-center gap-1.5 btn-vx-assist" 
                            style="background-color: #059669;"
                            data-target="bahan_ajar" data-type="bahan_ajar" data-label="Bahan Ajar / Rangkuman Materi">
                        <i class="bi bi-robot"></i> ✨ Tambah / Perkaya Materi via Vx Agent
                    </button>
                </div>
                <div class="card-body pt-0">
                    <p class="small text-muted mb-2">
                        Rangkuman materi esensial yang menjadi bahan ajar bagi murid. Anda bisa mengetik langsung atau meminta Vx Agent menambahkan sub-materi baru.
                    </p>
                    <textarea class="form-control rounded-3" id="bahan_ajar" name="bahan_ajar" rows="8">{{ old('bahan_ajar', $modulAjar->bahan_ajar) }}</textarea>
                </div>
            </div>

            <!-- 4. KEGIATAN PEMBELAJARAN PEDATTI -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-diagram-2 text-info"></i> IV. Sintaks Kegiatan Belajar PEDATTI (5 Tahapan)
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="accordion" id="accordionPedatti">
                        @foreach($modulAjar->kegiatans->sortBy('urutan') as $keg)
                            <div class="accordion-item border rounded-3 mb-3 overflow-hidden shadow-none">
                                <h2 class="accordion-header" id="heading_{{ $keg->id }}">
                                    <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $keg->id }}" aria-expanded="false">
                                        <span class="badge bg-primary me-2 px-2.5 py-1">Tahap {{ $keg->urutan }}: {{ strtoupper($keg->tahap_pedatti) }}</span>
                                        <span>{{ ucfirst($keg->tahap_pedatti) }} ({{ $keg->durasi_menit }} Menit &bull; {{ $keg->prinsip_deep_learning }})</span>
                                    </button>
                                </h2>
                                <div id="collapse_{{ $keg->id }}" class="accordion-collapse collapse show">
                                    <div class="accordion-body bg-light pt-2 pb-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                                            <span class="small text-secondary fw-semibold">
                                                Fokus Olah: <strong>{{ $keg->olah }}</strong> | Prinsip: <strong>{{ $keg->prinsip_deep_learning }}</strong>
                                            </span>
                                            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-2.5 py-0.5 btn-vx-assist" 
                                                    data-target="kegiatan_{{ $keg->id }}" data-type="kegiatan_pedatti" data-label="Kegiatan Tahap {{ ucfirst($keg->tahap_pedatti) }}">
                                                <i class="bi bi-robot me-1"></i> ✨ Kembangkan via Vx Agent
                                            </button>
                                        </div>
                                        <textarea class="form-control rounded-3" id="kegiatan_{{ $keg->id }}" name="kegiatans[{{ $keg->id }}][deskripsi]" rows="4">{{ old("kegiatans.{$keg->id}.deskripsi", $keg->deskripsi_kegiatan) }}</textarea>
                                        <div class="row g-2 mt-1">
                                            <div class="col-md-3">
                                                <label class="form-label small text-muted mb-0">Durasi (Menit):</label>
                                                <input type="number" class="form-control form-control-sm rounded-3" name="kegiatans[{{ $keg->id }}][durasi]" value="{{ $keg->durasi_menit }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 5. ASESMEN & EVALUASI -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-check2-circle text-primary"></i> V. Rancangan Asesmen & Evaluasi Murid
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-secondary">Asesmen Awal (Diagnostik)</label>
                            <textarea class="form-control rounded-3" name="asesmen_awal" rows="3">{{ old('asesmen_awal', $modulAjar->asesmen_awal) }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-between mb-1 flex-wrap gap-1">
                                <label class="form-label small fw-bold text-secondary mb-0">Asesmen Formatif (Proses)</label>
                                <button type="button" class="btn btn-xs btn-outline-success rounded-pill px-2 py-0 btn-vx-assist" style="font-size: 0.72rem;"
                                        data-target="asesmen_formatif" data-type="rubrik" data-label="Asesmen Formatif">
                                    <i class="bi bi-robot"></i> ✨ Vx Agent
                                </button>
                            </div>
                            <textarea class="form-control rounded-3" id="asesmen_formatif" name="asesmen_formatif" rows="3">{{ old('asesmen_formatif', $modulAjar->asesmen_formatif) }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-secondary">Asesmen Sumatif (Akhir)</label>
                            <textarea class="form-control rounded-3" name="asesmen_sumatif" rows="3">{{ old('asesmen_sumatif', $modulAjar->asesmen_sumatif) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. PENGAYAAN, REMEDIAL & REFLEKSI -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-repeat text-secondary"></i> VI. Refleksi, Remedial, &amp; Glosarium
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Refleksi Guru</label>
                            <textarea class="form-control rounded-3" name="refleksi_guru" rows="3">{{ old('refleksi_guru', $modulAjar->refleksi_guru) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Refleksi Murid</label>
                            <textarea class="form-control rounded-3" name="refleksi_siswa" rows="3">{{ old('refleksi_siswa', $modulAjar->refleksi_siswa) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Program Remedial</label>
                            <textarea class="form-control rounded-3" name="remedial" rows="2">{{ old('remedial', $modulAjar->remedial) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Program Pengayaan (HOTS)</label>
                            <textarea class="form-control rounded-3" name="pengayaan" rows="2">{{ old('pengayaan', $modulAjar->pengayaan) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Glosarium (Istilah Kunci)</label>
                            <textarea class="form-control rounded-3" name="glosarium" rows="2">{{ old('glosarium', $modulAjar->glosarium) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">Daftar Pustaka</label>
                            <textarea class="form-control rounded-3" name="daftar_pustaka" rows="2">{{ old('daftar_pustaka', $modulAjar->daftar_pustaka) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOMBOL SIMPAN -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-body p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <a href="{{ route('modul-ajar.show', $modulAjar->id) }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                        <i class="bi bi-check-circle-fill me-1"></i> Simpan Perubahan Modul Ajar
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
                        <h6 class="modal-title fw-bold text-dark mb-0" id="modalVxAgentLabel">Vx Agent &bull; Asisten Pelengkap Kurikulum</h6>
                        <small class="text-muted" id="modalTargetLabel">Melengkapi seksi...</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-3">
                <!-- FORM PERINTAH DARI GURU -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">
                        Apa yang ingin Anda tambahkan atau sesuaikan pada bagian ini?
                    </label>
                    <textarea class="form-control rounded-3" id="agentPromptInput" rows="3" 
                              placeholder="Contoh: Tambahkan materi praktis tentang keamanan siber dan cloud computing untuk murid SMK..."></textarea>
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
                    <div class="small fw-bold text-dark">Vx Agent sedang menyusun teks berdasar regulasi BSKAP 046/2025...</div>
                    <small class="text-muted">Bebas halusinasi &bull; Terikat Capaian Pembelajaran &bull; Berorientasi Murid</small>
                </div>

                <!-- PREVIEW HASIL DARI AGENT -->
                <div id="agentPreviewContainer" style="display: none;">
                    <label class="form-label small fw-bold text-success d-flex align-items-center gap-1.5">
                        <i class="bi bi-check2-circle fs-6"></i> Pratinjau Teks Hasil Vx Agent:
                    </label>
                    <div class="p-3 bg-light rounded-3 border text-dark mb-3" id="agentPreviewText" style="font-size: 0.9rem; line-height: 1.6; white-space: pre-line; max-height: 250px; overflow-y: auto;">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" id="btnApplyAgentText" style="display: none;">
                    <i class="bi bi-check2-all me-1"></i> Terapkan ke Dokumen
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
            const label = this.getAttribute('data-label') || 'Seksi Dokumen';

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
            alert('Mohon tuliskan arahan atau materi apa yang ingin Anda tambahkan.');
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
