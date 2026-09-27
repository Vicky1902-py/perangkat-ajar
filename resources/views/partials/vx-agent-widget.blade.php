<!-- ===================================================================== -->
<!-- FLOATING VX AGENT: CURRICULUM CONSULTANT & AI COPILOT WIDGET           -->
<!-- Grounded strictly on BSKAP 046/H/KR/2025 & Deep Learning Framework      -->
<!-- ===================================================================== -->

<!-- FLOATING CALLOUT BUBBLE (AUTO-POPUP) -->
<div id="vxAgentCalloutToast" class="card border-0 shadow-lg rounded-4 position-fixed" 
     style="bottom: 145px; right: 24px; width: 330px; max-width: calc(100vw - 32px); z-index: 1045; display: none; border-left: 5px solid #0284c7 !important; box-shadow: 0 12px 35px rgba(2, 132, 199, 0.22) !important; animation: vxSlideUp 0.4s ease-out;">
    <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary text-white fw-bold px-2 py-1" style="font-size: 0.72rem;">
                    <i class="bi bi-stars"></i> Vx Agent
                </span>
                <span class="small text-muted fw-semibold" style="font-size: 0.75rem;">Sistem Pakar Kurikulum</span>
            </div>
            <button type="button" class="btn-close btn-close-sm" style="font-size: 0.65rem;" onclick="dismissVxCalloutToast()" title="Tutup notifikasi"></button>
        </div>
        <p class="small text-dark mb-2" style="font-size: 0.85rem; line-height: 1.45;">
            👋 <em>"Jika hasil kurang sesuai bisa konsultasi dengan <strong>Vx Agent</strong> dan minta saran."</em>
        </p>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold flex-grow-1 shadow-sm" onclick="openVxAgentModal()" style="font-size: 0.8rem;">
                <i class="bi bi-chat-dots-fill me-1"></i> Tanya Vx Agent
            </button>
            <button type="button" class="btn btn-light btn-sm rounded-pill px-2.5 text-muted border" onclick="dismissVxCalloutToast()" style="font-size: 0.78rem;">
                Nanti
            </button>
        </div>
    </div>
</div>

<!-- FLOATING TRIGGER BUTTON -->
<div id="vxAgentFloatingContainer" class="position-fixed" style="bottom: 80px; right: 24px; z-index: 1045;">
    <button id="btnFloatingVxAgent" type="button" class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center position-relative"
            style="width: 54px; height: 54px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); border: 2.5px solid #ffffff; box-shadow: 0 8px 24px rgba(2, 132, 199, 0.45) !important; transition: transform 0.2s ease, box-shadow 0.2s ease;"
            onclick="toggleVxCalloutOrOpenModal()" title="Konsultasi Kurikulum & Edit Perangkat (Vx Agent)">
        <i class="bi bi-robot fs-3 text-white"></i>
        <span class="position-absolute top-0 start-100 translate-middle p-1.5 bg-success border border-light rounded-circle" style="width: 13px; height: 13px;">
            <span class="visually-hidden">Vx Agent Online</span>
        </span>
    </button>
</div>

<!-- ===================================================================== -->
<!-- POP-UP KEREN PANDUAN & PEMBERITAHUAN: VX AGENT (SISTEM PAKAR AI)     -->
<!-- ===================================================================== -->
<div class="modal fade" id="modalVxAgentWelcomeGuide" tabindex="-1" aria-labelledby="modalVxAgentWelcomeGuideLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-2xl overflow-hidden">
            <!-- HEADER MODAL KEREN -->
            <div class="modal-header border-0 py-3.5 px-4 text-white d-flex align-items-center justify-content-between" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-2 text-white shadow-sm d-flex align-items-center justify-content-center" 
                         style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); width: 48px; height: 48px; box-shadow: 0 0 20px rgba(2, 132, 199, 0.5) !important;">
                        <i class="bi bi-robot fs-3"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="modal-title fw-bold text-white mb-0" id="modalVxAgentWelcomeGuideLabel">Vx Agent</h5>
                            <span class="badge rounded-pill bg-primary text-white px-2 py-0.5" style="font-size: 0.7rem;">
                                <i class="bi bi-stars"></i> Asisten Pakar Kurikulum
                            </span>
                        </div>
                        <div class="text-white text-opacity-75 small" style="font-size: 0.78rem;">
                            Sistem Pendamping Cerdas Guru SMK & SMA &bull; BSKAP No. 046/H/KR/2025
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4" style="background-color: #f8fafc;">
                <!-- NOTICE HERO BANNER -->
                <div class="card border-0 rounded-4 shadow-sm mb-4 text-white overflow-hidden" 
                     style="background: linear-gradient(135deg, #0284c7 0%, #0f172a 100%); border-left: 5px solid #38bdf8 !important;">
                    <div class="card-body p-3.5 p-md-4">
                        <div class="d-flex align-items-start gap-3">
                            <div class="p-2 rounded-circle bg-white text-primary shadow-sm flex-shrink-0 mt-1">
                                <i class="bi bi-info-circle-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-white fs-6">
                                    Hasil Perangkat Kurang Sesuai atau Butuh Tambahan Materi? Gunakan Vx Agent!
                                </h6>
                                <p class="mb-0 text-white text-opacity-90 small" style="line-height: 1.55;">
                                    Bapak/Ibu Guru, jika ada bagian dokumen (Modul Ajar, LKPD, ATP, dll.) yang dirasa kurang pas dengan kondisi nyata di sekolah, atau ingin menambahkan materi kejuruan baru, <strong>gunakan Vx Agent</strong> untuk berkonsultasi atau melengkapi teks dokumen secara otomatis tanpa merusak format baku Kurikulum Merdeka.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3 FITUR UTAMA KEREN -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-3 bg-white">
                            <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-2.5 d-inline-flex align-items-center justify-content-center mb-2" style="width: 42px; height: 42px;">
                                <i class="bi bi-chat-dots-fill fs-5"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">1. Konsultasi & Saran</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.78rem; line-height: 1.45;">
                                Minta rekomendasi kegiatan pembelajaran Deep Learning (Mindful, Meaningful, Joyful), alur PEDATTI, atau diferensiasi murid.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-3 bg-white">
                            <div class="rounded-3 bg-warning bg-opacity-15 text-warning p-2.5 d-inline-flex align-items-center justify-content-center mb-2" style="width: 42px; height: 42px;">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">2. Edit Otomatis</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.78rem; line-height: 1.45;">
                                Di formulir edit Modul & LKPD, klik tombol <em>"Lengkapi via Vx Agent"</em> untuk memperluas materi dan kegiatan secara aman tanpa merusak format tabel.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 p-3 bg-white">
                            <div class="rounded-3 bg-success bg-opacity-10 text-success p-2.5 d-inline-flex align-items-center justify-content-center mb-2" style="width: 42px; height: 42px;">
                                <i class="bi bi-shield-check fs-5"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">3. Terstandar Murid</h6>
                            <p class="text-muted small mb-0" style="font-size: 0.78rem; line-height: 1.45;">
                                Bebas halusinasi karena terikat 100% pada database Capaian Pembelajaran resmi dan wajib memakai terminologi resmi <strong>murid</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CALL TO ACTIONS -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2 border-top">
                    <div class="text-muted small" style="font-size: 0.75rem;">
                        <i class="bi bi-lightbulb-fill text-warning me-1"></i> Tersedia juga tombol mengambang di pojok kanan bawah setiap halaman.
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('pakar-ai.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                            <i class="bi bi-cpu me-1"></i> Studio Konsultasi
                        </a>
                        <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm" 
                                onclick="const gModal = bootstrap.Modal.getInstance(document.getElementById('modalVxAgentWelcomeGuide')); if(gModal) gModal.hide(); openVxAgentModal();">
                            <i class="bi bi-chat-dots-fill me-1"></i> Buka Obrolan Vx Agent
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================================================================== -->
<!-- MODAL INTERAKTIF OBROLAN VX AGENT                                     -->
<!-- ===================================================================== -->
<div class="modal fade" id="modalVxAgentChat" tabindex="-1" aria-labelledby="modalVxAgentChatLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-2xl overflow-hidden" style="max-height: 90vh;">
            
            <!-- MODAL HEADER -->
            <div class="modal-header border-0 py-3 px-4 text-white d-flex align-items-center justify-content-between" 
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle p-2 text-white shadow-sm d-flex align-items-center justify-content-center" 
                         style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); width: 44px; height: 44px;">
                        <i class="bi bi-robot fs-4"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="modal-title fw-bold text-white mb-0" id="modalVxAgentChatLabel">Vx Agent</h6>
                            <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                <i class="bi bi-record-fill text-success"></i> Online (Vx Agent)
                            </span>
                        </div>
                        <div class="text-white text-opacity-75 small" style="font-size: 0.75rem;">
                            Sistem Pakar Kurikulum Merdeka & Pendekatan Deep Learning (BSKAP 046/2025)
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- MODAL BODY -->
            <div class="modal-body p-3 p-md-4 d-flex flex-column" style="background-color: #f8fafc; min-height: 420px;">
                
                <!-- CONTEXT BANNER -->
                <div id="vxDocContextBar" class="p-2.5 px-3 rounded-3 mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2 border" 
                     style="background-color: #e0f2fe; border-color: #bae6fd !important;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-text text-primary fs-5"></i>
                        <div>
                            <div class="small fw-bold text-dark" id="vxContextTitle">Perangkat Ajar Kurikulum Merdeka</div>
                            <div class="text-muted" style="font-size: 0.72rem;" id="vxContextSubtitle">Mata Pelajaran &bull; Fase E/F</div>
                        </div>
                    </div>
                    <div id="vxContextEditAction" style="display: none;">
                        <a href="#" id="vxContextEditLink" class="btn btn-warning btn-sm text-dark fw-bold rounded-pill px-3 shadow-sm" style="font-size: 0.75rem;">
                            <i class="bi bi-pencil-square me-1"></i> Buka Form Edit
                        </a>
                    </div>
                </div>

                <!-- QUICK PROMPT PILLS -->
                <div class="mb-3">
                    <div class="text-muted small fw-semibold mb-1" style="font-size: 0.72rem;">💡 Rekomendasi Pertanyaan Cepat:</div>
                    <div class="d-flex flex-wrap gap-1.5" id="vxQuickPills">
                        <button type="button" class="btn btn-xs btn-outline-primary bg-white rounded-pill px-2.5 py-1 vx-pill-btn" style="font-size: 0.75rem;">
                            Saran kegiatan interaktif Deep Learning
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-primary bg-white rounded-pill px-2.5 py-1 vx-pill-btn" style="font-size: 0.75rem;">
                            Bagaimana diferensiasi untuk murid remedial?
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-primary bg-white rounded-pill px-2.5 py-1 vx-pill-btn" style="font-size: 0.75rem;">
                            Hubungkan materi dengan standar dunia industri
                        </button>
                        <button type="button" class="btn btn-xs btn-outline-primary bg-white rounded-pill px-2.5 py-1 vx-pill-btn" style="font-size: 0.75rem;">
                            Cek keselarasan alur TP dan CP
                        </button>
                    </div>
                </div>

                <!-- CHAT MESSAGES STREAM CONTAINER -->
                <div id="vxChatStream" class="flex-grow-1 overflow-auto rounded-3 p-3 bg-white border mb-3 d-flex flex-column gap-3" 
                     style="max-height: 380px; min-height: 240px;">
                    <!-- DEFAULT ASSISTANT GREETING -->
                    <div class="d-flex align-items-start gap-2.5">
                        <div class="rounded-circle p-1.5 bg-primary text-white d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 32px; height: 32px;">
                            <i class="bi bi-robot fs-6"></i>
                        </div>
                        <div class="p-3 rounded-4 rounded-top-0 text-dark small" style="background-color: #f1f5f9; max-width: 85%; line-height: 1.55;">
                            👋 <strong>Halo Bapak/Ibu Guru!</strong> Saya <strong>Vx Agent</strong>, asisten pakar kurikulum siap mendampingi Anda.<br><br>
                            Jika ada alur materi, kegiatan murid, atau stimulus LKPD yang dirasa kurang pas, sampaikan saja di sini. Anda juga bisa mengklik tombol <strong>Edit</strong> pada dokumen untuk melengkapi materi secara otomatis tanpa merusak format baku.
                        </div>
                    </div>
                </div>

                <!-- CHAT INPUT FORM -->
                <div class="position-relative">
                    <div class="input-group shadow-sm rounded-4 overflow-hidden border">
                        <textarea id="vxChatInput" class="form-control border-0 p-2.5 ps-3" rows="2" 
                                  placeholder="Tuliskan pertanyaan atau arahan penyesuaian materi ke Vx Agent... (Tekan Shift+Enter untuk baris baru)" 
                                  style="resize: none; font-size: 0.88rem;"></textarea>
                        <button type="button" id="btnVxChatSend" class="btn btn-primary px-3 d-flex align-items-center justify-content-center" 
                                style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                            <i class="bi bi-send-fill fs-5"></i>
                        </button>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-1 px-1">
                        <span class="text-muted" style="font-size: 0.68rem;">
                            <i class="bi bi-shield-check text-success me-1"></i> Standar BSKAP 046/2025 &bull; Menggunakan istilah resmi <strong>murid</strong>
                        </span>
                        <button type="button" class="btn btn-link text-muted p-0 text-decoration-none" style="font-size: 0.72rem;" onclick="clearVxChat()">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Obrolan
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
@keyframes vxSlideUp {
    from {
        transform: translateY(40px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
#btnFloatingVxAgent:hover {
    transform: scale(1.08);
    box-shadow: 0 12px 28px rgba(2, 132, 199, 0.6) !important;
}
.vx-user-bubble {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    align-self: flex-end;
    border-radius: 16px 16px 2px 16px;
    padding: 10px 14px;
    max-width: 82%;
    font-size: 0.85rem;
    line-height: 1.5;
    box-shadow: 0 2px 8px rgba(2, 132, 199, 0.2);
}
.vx-agent-bubble {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #1e293b;
    align-self: flex-start;
    border-radius: 16px 16px 16px 2px;
    padding: 12px 16px;
    max-width: 88%;
    font-size: 0.86rem;
    line-height: 1.6;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
</style>

<script>
(function() {
    let currentDocContext = {
        type: 'general',
        id: null,
        title: 'Perangkat Ajar Kurikulum Merdeka',
        mapel: 'Mata Pelajaran Umum/Kejuruan',
        fase: 'E/F',
        editUrl: null
    };

    // Deteksi konteks dokumen aktif dari halaman saat ini
    function detectPageContext() {
        const path = window.location.pathname;
        const pageTitle = document.title ? document.title.replace(' - Perangkat Ajar Kurikulum Merdeka (Deep Learning)', '') : '';
        
        const h4Title = document.querySelector('h4.fw-bold');
        if (h4Title) {
            currentDocContext.title = h4Title.innerText.trim();
        } else if (pageTitle) {
            currentDocContext.title = pageTitle;
        }

        if (path.includes('/modul-ajar/')) {
            currentDocContext.type = 'modul_ajar';
            const parts = path.split('/');
            const id = parts[parts.length - 1];
            if (!isNaN(id)) {
                currentDocContext.id = id;
                currentDocContext.editUrl = `/modul-ajar/${id}/edit`;
            }
        } else if (path.includes('/lkpd/')) {
            currentDocContext.type = 'lkpd';
            const parts = path.split('/');
            const id = parts[parts.length - 1];
            if (!isNaN(id)) {
                currentDocContext.id = id;
                currentDocContext.editUrl = `/lkpd/${id}/edit`;
            }
        } else if (path.includes('/atp/')) {
            currentDocContext.type = 'atp';
        } else if (path.includes('/generator/result')) {
            currentDocContext.type = 'result_package';
            currentDocContext.title = 'Hasil Generate Paket Perangkat Ajar 1-Klik';
        }

        // Cari informasi Mapel & Fase di halaman jika ada
        const textContent = document.body.innerText;
        const mapelMatch = textContent.match(/Mata Pelajaran\s*\n*\s*([^\n\t]+)/i);
        if (mapelMatch && mapelMatch[1] && mapelMatch[1].trim() !== '-') {
            currentDocContext.mapel = mapelMatch[1].trim();
        }
        const faseMatch = textContent.match(/Fase\s*([A-F])/i);
        if (faseMatch && faseMatch[1]) {
            currentDocContext.fase = faseMatch[1].toUpperCase();
        }

        updateContextUI();
    }

    function updateContextUI() {
        const titleEl = document.getElementById('vxContextTitle');
        const subEl = document.getElementById('vxContextSubtitle');
        const editContainer = document.getElementById('vxContextEditAction');
        const editLink = document.getElementById('vxContextEditLink');

        if (titleEl) titleEl.innerText = currentDocContext.title;
        if (subEl) subEl.innerText = `${currentDocContext.mapel} • Fase ${currentDocContext.fase} • Standar BSKAP 046/2025`;

        if (editContainer && editLink) {
            if (currentDocContext.editUrl) {
                editLink.href = currentDocContext.editUrl;
                editContainer.style.display = 'block';
            } else {
                editContainer.style.display = 'none';
            }
        }
    }

    // Tampilkan Toast Callout otomatis setelah jeda
    window.addEventListener('load', function() {
        detectPageContext();

        // Cek apakah di halaman perangkat ajar atau hasil generate
        const path = window.location.pathname;
        const isDevicePage = path.includes('/modul-ajar') || path.includes('/lkpd') || path.includes('/atp') || path.includes('/generator/result') || path.includes('/asesmen') || path.includes('/prota') || path.includes('/promes');

        if (isDevicePage) {
            setTimeout(function() {
                const callout = document.getElementById('vxAgentCalloutToast');
                if (callout && !sessionStorage.getItem('vx_callout_dismissed_page_' + path)) {
                    callout.style.display = 'block';
                }
            }, 1200);
        }
    });

    window.dismissVxCalloutToast = function() {
        const callout = document.getElementById('vxAgentCalloutToast');
        if (callout) {
            callout.style.display = 'none';
            sessionStorage.setItem('vx_callout_dismissed_page_' + window.location.pathname, 'true');
        }
    };

    window.toggleVxCalloutOrOpenModal = function() {
        const callout = document.getElementById('vxAgentCalloutToast');
        if (callout && callout.style.display === 'block') {
            callout.style.display = 'none';
        }
        openVxAgentModal();
    };

    window.showVxAgentWelcomeModal = function() {
        dismissVxCalloutToast();
        const modalEl = document.getElementById('modalVxAgentWelcomeGuide');
        if (modalEl) {
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        } else {
            window.location.href = "{{ route('pakar-ai.index') }}";
        }
    };

    window.openVxAgentModal = function() {
        dismissVxCalloutToast();
        const modalEl = document.getElementById('modalVxAgentChat');
        if (modalEl) {
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
            setTimeout(() => {
                const input = document.getElementById('vxChatInput');
                if (input) input.focus();
            }, 350);
        }
    };

    window.openVxAgentWithDocContext = function(type, id, title, mapel, fase) {
        currentDocContext.type = type || currentDocContext.type;
        currentDocContext.id = id || currentDocContext.id;
        if (title) currentDocContext.title = title;
        if (mapel) currentDocContext.mapel = mapel;
        if (fase) currentDocContext.fase = fase;

        if (type === 'modul_ajar' && id) {
            currentDocContext.editUrl = `/modul-ajar/${id}/edit`;
        } else if (type === 'lkpd' && id) {
            currentDocContext.editUrl = `/lkpd/${id}/edit`;
        }

        updateContextUI();
        openVxAgentModal();
    };

    // Chat handling
    document.addEventListener('DOMContentLoaded', function() {
        const chatInput = document.getElementById('vxChatInput');
        const btnSend = document.getElementById('btnVxChatSend');
        const chatStream = document.getElementById('vxChatStream');

        if (!chatInput || !btnSend || !chatStream) return;

        // Pills Click
        document.querySelectorAll('.vx-pill-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                chatInput.value = this.innerText.trim();
                sendMessage();
            });
        });

        // Keypress (Enter sends, Shift+Enter new line)
        chatInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        btnSend.addEventListener('click', function() {
            sendMessage();
        });

        function sendMessage() {
            const text = chatInput.value.trim();
            if (!text) return;

            // Render User Bubble
            appendUserMessage(text);
            chatInput.value = '';
            chatInput.disabled = true;
            btnSend.disabled = true;

            // Render Loading Bubble
            const loadingBubble = appendLoadingBubble();

            // Request ke endpoint /vx-agent/chat
            fetch("{{ route('vx-agent.chat') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    message: text,
                    document_type: currentDocContext.type,
                    document_id: currentDocContext.id,
                    document_title: currentDocContext.title,
                    mata_pelajaran: currentDocContext.mapel,
                    fase: currentDocContext.fase
                })
            })
            .then(res => res.json())
            .then(data => {
                loadingBubble.remove();
                chatInput.disabled = false;
                btnSend.disabled = false;
                chatInput.focus();

                if (data.success && data.reply) {
                    appendAgentMessage(data.reply);
                } else {
                    appendAgentMessage(data.message || 'Mohon maaf, terjadi kendala saat memproses jawaban. Silakan ulangi.');
                }
            })
            .catch(err => {
                loadingBubble.remove();
                chatInput.disabled = false;
                btnSend.disabled = false;
                appendAgentMessage('Koneksi terputus atau batas waktu habis. Silakan periksa jaringan dan coba lagi.');
            });
        }

        function appendUserMessage(text) {
            const wrap = document.createElement('div');
            wrap.className = 'd-flex justify-content-end mb-1';
            wrap.innerHTML = `<div class="vx-user-bubble">${escapeHtml(text)}</div>`;
            chatStream.appendChild(wrap);
            chatStream.scrollTop = chatStream.scrollHeight;
        }

        function appendLoadingBubble() {
            const wrap = document.createElement('div');
            wrap.className = 'd-flex align-items-start gap-2.5 mb-1';
            wrap.innerHTML = `
                <div class="rounded-circle p-1.5 bg-primary text-white d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 32px; height: 32px;">
                    <i class="bi bi-robot fs-6"></i>
                </div>
                <div class="vx-agent-bubble d-flex align-items-center gap-2">
                    <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                    <span class="text-muted" style="font-size: 0.8rem;">Vx Agent sedang menelaah kurikulum...</span>
                </div>
            `;
            chatStream.appendChild(wrap);
            chatStream.scrollTop = chatStream.scrollHeight;
            return wrap;
        }

        function appendAgentMessage(text) {
            const wrap = document.createElement('div');
            wrap.className = 'd-flex align-items-start gap-2.5 mb-2';
            
            // Format markdown bold and line breaks
            let formatted = escapeHtml(text)
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.*?)\*/g, '<em>$1</em>')
                .replace(/\n/g, '<br>');

            wrap.innerHTML = `
                <div class="rounded-circle p-1.5 bg-primary text-white d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 32px; height: 32px;">
                    <i class="bi bi-robot fs-6"></i>
                </div>
                <div class="vx-agent-bubble position-relative">
                    <div class="d-flex align-items-center justify-content-between mb-1 pb-1 border-bottom border-light">
                        <span class="fw-bold text-primary small" style="font-size: 0.75rem;"><i class="bi bi-patch-check-fill me-1"></i> Saran Vx Agent:</span>
                        <button type="button" class="btn btn-xs btn-link text-muted p-0 text-decoration-none copy-btn" title="Salin saran">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    <div class="agent-text">${formatted}</div>
                </div>
            `;

            const copyBtn = wrap.querySelector('.copy-btn');
            copyBtn.addEventListener('click', function() {
                navigator.clipboard.writeText(text).then(() => {
                    copyBtn.innerHTML = '<i class="bi bi-check2 text-success"></i>';
                    setTimeout(() => copyBtn.innerHTML = '<i class="bi bi-clipboard"></i>', 2000);
                });
            });

            chatStream.appendChild(wrap);
            chatStream.scrollTop = chatStream.scrollHeight;
        }

        window.clearVxChat = function() {
            chatStream.innerHTML = `
                <div class="d-flex align-items-start gap-2.5">
                    <div class="rounded-circle p-1.5 bg-primary text-white d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 32px; height: 32px;">
                        <i class="bi bi-robot fs-6"></i>
                    </div>
                    <div class="p-3 rounded-4 rounded-top-0 text-dark small" style="background-color: #f1f5f9; max-width: 85%; line-height: 1.55;">
                        👋 Obrolan telah direset. Silakan tanyakan hal lain terkait perangkat ajar, materi, atau asesmen murid.
                    </div>
                </div>
            `;
        };

        function escapeHtml(string) {
            const entityMap = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            };
            return String(string).replace(/[&<>"']/g, function (s) {
                return entityMap[s];
            });
        }
    });
})();
</script>
