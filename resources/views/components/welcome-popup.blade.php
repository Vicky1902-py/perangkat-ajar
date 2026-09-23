<!-- ============================================================ -->
<!-- POP-UP INFORMATIF & PUSAT BANTUAN 2026                       -->
<!-- ============================================================ -->
<div class="modal fade welcome-modal-custom" id="welcomeGuideModal" tabindex="-1" aria-labelledby="welcomeGuideModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content welcome-modal-content">
            
            <!-- MODAL HEADER -->
            <div class="modal-header welcome-modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="welcome-header-icon">
                        <i class="bi bi-stars"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <span class="welcome-badge">
                                <i class="bi bi-patch-check-fill text-warning me-1"></i> PUSAT INFORMASI & BANTUAN 2026
                            </span>
                            <span class="text-white-50 small">&bull; Kurikulum Merdeka SMK</span>
                        </div>
                        <h4 class="modal-title fw-bold text-white mb-0" id="welcomeGuideModalLabel">
                            Selamat Datang di {{ app_setting('app_name', 'Sistem Perangkat Ajar SMK') }}
                        </h4>
                        <p class="text-white-50 small mb-0 mt-1">
                            {{ app_setting('app_tagline', 'Kurikulum Merdeka • Pendekatan Pembelajaran Mendalam (Deep Learning)') }}
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" onclick="closeWelcomePopup()"></button>
            </div>

            <!-- MODAL NAV PILLS (3 MENU UTAMA) -->
            <div class="px-4 pt-3 pb-2">
                <div class="row g-2">
                    <!-- BUTTON 1: PANDUAN -->
                    <div class="col-md-4">
                        <button class="welcome-menu-btn active w-100 text-start" id="btnMenuPanduan" onclick="switchWelcomeTab('panduan')">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="menu-icon-box bg-primary-subtle text-primary">
                                    <i class="bi bi-compass-fill"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="menu-title">1. Panduan Penggunaan</div>
                                    <div class="menu-subtitle">Alur & fungsi tiap menu</div>
                                </div>
                            </div>
                        </button>
                    </div>
                    <!-- BUTTON 2: USUL & SARAN -->
                    <div class="col-md-4">
                        <button class="welcome-menu-btn w-100 text-start" id="btnMenuSaran" onclick="switchWelcomeTab('saran')">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="menu-icon-box bg-warning-subtle text-warning">
                                    <i class="bi bi-chat-heart-fill"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="menu-title">2. Usul & Saran</div>
                                    <div class="menu-subtitle">Kirim masukan ke Admin</div>
                                </div>
                            </div>
                        </button>
                    </div>
                    <!-- BUTTON 3: PROFIL PEMBUAT -->
                    <div class="col-md-4">
                        <button class="welcome-menu-btn w-100 text-start" id="btnMenuProfil" onclick="switchWelcomeTab('profil')">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="menu-icon-box bg-info-subtle text-info">
                                    <i class="bi bi-person-badge-fill"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="menu-title">3. Profil Pembuat</div>
                                    <div class="menu-subtitle">{{ app_setting('landing_creator_name', 'Vicky Koroh') }}</div>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- MODAL BODY -->
            <div class="modal-body welcome-modal-body p-4">

                <!-- ============================================== -->
                <!-- SECTION 1: PANDUAN PENGGUNAAN LENGKAP          -->
                <!-- ============================================== -->
                <div id="welcomeSectionPanduan" class="welcome-section active">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold mb-1 d-flex align-items-center gap-2" style="color: #0b3b60;">
                                <i class="bi bi-journal-richtext text-primary"></i> Panduan Lengkap Penggunaan Aplikasi
                            </h5>
                            <p class="text-secondary small mb-0">Pelajari cara memanfaatkan seluruh fitur otomatisasi perangkat ajar langkah demi langkah.</p>
                        </div>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 fw-semibold">
                            <i class="bi bi-info-circle me-1"></i> 6 Menu Utama
                        </span>
                    </div>

                    <!-- SPECIAL CALLOUT: STANDAR SISTEM PAKAR RESMI KEMENDIKDASMEN -->
                    <div class="p-3 rounded-4 mb-3 d-flex align-items-start gap-3 shadow-xs" 
                         style="background: #fffbeb; border: 1.5px solid #fde68a;">
                        <div class="p-2 rounded-3 bg-warning text-dark fs-5 flex-shrink-0 shadow-sm">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <div>
                            <div class="fw-bold small d-flex align-items-center gap-2 flex-wrap mb-1" style="color: #92400e;">
                                <span>100% Murni Sistem Pakar Edukasi &bull; Berbasis Database Resmi</span>
                                <span class="badge bg-warning text-dark fw-bold" style="font-size: 0.68rem;">BSKAP No. 046/2025</span>
                            </div>
                            <p class="small mb-0" style="font-size: 0.82rem; line-height: 1.6; color: #78350f !important;">
                                Berbeda dari AI generatif umum yang membutuhkan API Key berbayar dan rentan halusinasi, sistem ini menggunakan <strong style="color: #451a03;">Knowledge-Based Expert System</strong> deterministik. Seluruh referensi Capaian Pembelajaran tersimpan di database internal berdasarkan <strong style="color: #451a03;">Keputusan Kepala BSKAP No. 046/H/KR/2025</strong> dan <strong style="color: #451a03;">Permendikdasmen No. 13/2025</strong>. Dijamin <strong style="color: #451a03;">Nol Halusinasi</strong>, bebas biaya token, dan menjaga kedaulatan data sekolah.
                            </p>
                        </div>
                    </div>

                    <!-- ACCORDION PANDUAN -->
                    <div class="accordion accordion-flush welcome-accordion" id="accordionPanduan">
                        
                        <!-- 1. GENERATOR 1-KLIK -->
                        <div class="accordion-item welcome-acc-item mb-2">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button welcome-acc-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="acc-num-badge">1</span>
                                        <strong>Alur Cepat: Generator Sistem Pakar 1-Klik</strong>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionPanduan">
                                <div class="accordion-body welcome-acc-body">
                                    <p class="mb-2">Fitur ini merupakan keunggulan utama sistem yang memungkinkan Anda menghasilkan <strong>seluruh dokumen perangkat ajar sekaligus</strong> hanya dalam hitungan detik:</p>
                                    <ul class="mb-2 ps-3">
                                        <li><strong>Langkah 1:</strong> Buka halaman Generator melalui tombol <span class="badge bg-primary">Coba Generator Gratis</span> di beranda atau menu navigasi.</li>
                                        <li><strong>Langkah 2:</strong> Pilih <em>Mata Pelajaran</em>, <em>Fase / Kelas</em> (Fase E untuk Kelas X, Fase F untuk Kelas XI & XII), serta <em>Tahun Ajaran</em>.</li>
                                        <li><strong>Langkah 3:</strong> Tentukan <em>Materi Pokok</em> dan centang dokumen apa saja yang ingin dibuat (Modul Ajar, ATP, Prota, Promes, LKPD, Asesmen).</li>
                                        <li><strong>Langkah 4:</strong> Klik tombol <strong>Generate Perangkat Ajar</strong>. Sistem secara otomatis menyusun narasi pembelajaran mendalam dan siap Anda unduh.</li>
                                    </ul>
                                    <div class="alert alert-info border border-info-subtle bg-info-subtle py-2 px-3 small rounded-3 mb-0" style="color: #0c4a6e !important;">
                                        <i class="bi bi-lightning-charge-fill text-warning me-1"></i> <strong style="color: #0c4a6e;">Trial Tamu (Guest):</strong> Pengunjung tanpa login dapat mencoba generator gratis maksimal 2 kali. Untuk akses tanpa batas, silakan <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-underline">Daftar Akun Guru</a>.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. MODUL AJAR DEEP LEARNING -->
                        <div class="accordion-item welcome-acc-item mb-2">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button welcome-acc-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="acc-num-badge">2</span>
                                        <strong>Modul Ajar Deep Learning (3 Pilar: Mindful, Meaningful, Joyful)</strong>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionPanduan">
                                <div class="accordion-body welcome-acc-body">
                                    <p class="mb-2">Modul ajar yang disusun menerapkan kerangka kerja pembelajaran bermakna (Deep Learning) sesuai standar terbaru:</p>
                                    <div class="row g-2 mb-2">
                                        <div class="col-md-4">
                                            <div class="p-2.5 rounded-3 bg-light border h-100" style="border-color: #e2e8f0 !important;">
                                                <div class="text-primary fw-bold small"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Mindful (Sadar)</div>
                                                <p class="text-secondary small mb-0 mt-1" style="font-size: 0.78rem;">Siswa menyadari tujuan belajarnya, fokus, dan merefleksikan proses berpikir secara mendalam.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-2.5 rounded-3 bg-light border h-100" style="border-color: #e2e8f0 !important;">
                                                <div class="fw-bold small" style="color: #b45309 !important;"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Meaningful (Bermakna)</div>
                                                <p class="text-secondary small mb-0 mt-1" style="font-size: 0.78rem;">Materi dikaitkan langsung dengan kebutuhan Dunia Usaha/Dunia Industri (DUDI) dan kasus nyata kejuruan.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-2.5 rounded-3 bg-light border h-100" style="border-color: #e2e8f0 !important;">
                                                <div class="text-success fw-bold small"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Joyful (Gembira)</div>
                                                <p class="text-secondary small mb-0 mt-1" style="font-size: 0.78rem;">Aktivitas belajar berbasis proyek kolaboratif, menyenangkan, dan membakar antusiasme siswa.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mb-0 small text-secondary">Sintaks pembelajaran juga mengadopsi alur <strong class="text-dark">PEDATTI</strong> (Pahami, Eksplorasi, Diskusi, Aplikasi, Tindak Lanjut, Terintegrasi Inovasi).</p>
                                </div>
                            </div>
                        </div>

                        <!-- 3. CP & ATP BSKAP 046/2025 -->
                        <div class="accordion-item welcome-acc-item mb-2">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button welcome-acc-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="acc-num-badge">3</span>
                                        <strong>Capaian Pembelajaran (CP) & Alur Tujuan Pembelajaran (ATP)</strong>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionPanduan">
                                <div class="accordion-body welcome-acc-body">
                                    <ul class="mb-0 ps-3">
                                        <li><strong>Standar Resmi:</strong> Mengacu 100% pada <em>Keputusan Kepala BSKAP Kemendikdasmen Nomor 046/H/KR/2025</em> (terbaru merevisi No. 032/H/KR/2024).</li>
                                        <li><strong>Elemen Kompetensi:</strong> Setiap CP telah dipetakan otomatis ke dalam elemen keterampilan dan pengetahuan yang relevan.</li>
                                        <li><strong>Penyusunan ATP:</strong> ATP disusun secara terstruktur berdasarkan alokasi Jam Pelajaran (JP), indikator ketercapaian asesmen, dan sumber belajar.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 4. PROTA & PROMES -->
                        <div class="accordion-item welcome-acc-item mb-2">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button welcome-acc-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="acc-num-badge">4</span>
                                        <strong>Program Tahunan (Prota) & Program Semester (Promes)</strong>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionPanduan">
                                <div class="accordion-body welcome-acc-body">
                                    <p class="mb-1">Sistem menghitung otomatis minggu efektif dan total Jam Pelajaran (JP) dalam satu semester/tahun ajaran:</p>
                                    <ul class="mb-0 ps-3">
                                        <li>Distribusi jam per elemen materi merata tanpa kalkulasi manual yang rumit.</li>
                                        <li>Dapat diedit dan disesuaikan langsung dengan kalender akademik satuan pendidikan Anda.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 5. EKSPOR PDF & DOCX -->
                        <div class="accordion-item welcome-acc-item mb-2">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button welcome-acc-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="acc-num-badge">5</span>
                                        <strong>Cetak & Ekspor Dokumen Resmi (PDF & Microsoft Word)</strong>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionPanduan">
                                <div class="accordion-body welcome-acc-body">
                                    <p class="mb-0">Semua dokumen yang dihasilkan dapat langsung diunduh dalam format <strong>PDF berstandar resmi</strong> (siap cetak dengan tanda tangan Kepala Sekolah & Guru) atau format <strong>DOCX (Word)</strong> yang dapat Anda sunting lebih lanjut.</p>
                                </div>
                            </div>
                        </div>

                        <!-- 6. AKUN GURU & DATA PRIBADI -->
                        <div class="accordion-item welcome-acc-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button welcome-acc-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="acc-num-badge">6</span>
                                        <strong>Manajemen Akun Guru & Satuan Pendidikan</strong>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionPanduan">
                                <div class="accordion-body welcome-acc-body">
                                    <p class="mb-0">Setelah mendaftar dan masuk, Anda dapat mengatur identitas sekolah (Nama SMK, NPSN, Kepala Sekolah, NIP), sehingga setiap dokumen yang diekspor otomatis mencantumkan identitas resmi sekolah Anda.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ============================================== -->
                <!-- SECTION 2: FORMULIR USUL & SARAN               -->
                <!-- ============================================== -->
                <div id="welcomeSectionSaran" class="welcome-section">
                    <div class="mb-3">
                        <h5 class="fw-bold mb-1 d-flex align-items-center gap-2" style="color: #0b3b60;">
                            <i class="bi bi-chat-quote text-warning"></i> Kotak Usul, Saran & Masukan Pengguna
                        </h5>
                        <p class="text-secondary small mb-0">
                            Punya ide fitur baru, menemukan hal yang masih kurang, atau ingin menyampaikan kendala? Masukan Anda langsung masuk ke layar Superadmin!
                        </p>
                    </div>

                    <!-- ALERT RESPONSE AJAX -->
                    <div id="feedbackAlertBox" class="d-none"></div>

                    <form id="welcomeFeedbackForm" onsubmit="submitWelcomeFeedback(event)">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label-popup">Nama Pengirim <span class="text-danger">*</span></label>
                                <div class="input-glass-popup">
                                    <i class="bi bi-person text-secondary"></i>
                                    <input type="text" name="nama" id="feedbackNama" required 
                                           value="{{ auth()->check() ? auth()->user()->name : '' }}" 
                                           placeholder="Nama lengkap atau panggilan Anda" class="form-control-popup">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-popup">Email Pengirim <span class="text-muted fw-normal">(Opsional)</span></label>
                                <div class="input-glass-popup">
                                    <i class="bi bi-envelope text-secondary"></i>
                                    <input type="email" name="email" id="feedbackEmail" 
                                           value="{{ auth()->check() ? auth()->user()->email : '' }}" 
                                           placeholder="email@sekolah.sch.id" class="form-control-popup">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label-popup">Kategori Masukan <span class="text-danger">*</span></label>
                                <div class="input-glass-popup select-wrap">
                                    <i class="bi bi-tag text-secondary"></i>
                                    <select name="kategori" id="feedbackKategori" required class="form-control-popup select-popup">
                                        <option value="usul_fitur">💡 Usul Fitur Baru</option>
                                        <option value="perbaikan_kekurangan" selected>🛠️ Masukan / Hal yang Masih Kurang</option>
                                        <option value="laporan_bug">⚠️ Laporan Kendala / Bug</option>
                                        <option value="pertanyaan">❓ Pertanyaan Penggunaan</option>
                                        <option value="apresiasi">⭐ Apresiasi & Testimoni</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-popup">Rating Kepuasan Sistem <span class="text-danger">*</span></label>
                                <div class="rating-stars-group d-flex align-items-center gap-2 pt-1">
                                    <input type="hidden" name="rating" id="feedbackRating" value="5">
                                    <div class="stars-container d-flex gap-1" id="starContainer">
                                        <i class="bi bi-star-fill text-warning fs-5 star-item cursor-pointer" data-val="1" onclick="setFeedbackRating(1)"></i>
                                        <i class="bi bi-star-fill text-warning fs-5 star-item cursor-pointer" data-val="2" onclick="setFeedbackRating(2)"></i>
                                        <i class="bi bi-star-fill text-warning fs-5 star-item cursor-pointer" data-val="3" onclick="setFeedbackRating(3)"></i>
                                        <i class="bi bi-star-fill text-warning fs-5 star-item cursor-pointer" data-val="4" onclick="setFeedbackRating(4)"></i>
                                        <i class="bi bi-star-fill text-warning fs-5 star-item cursor-pointer" data-val="5" onclick="setFeedbackRating(5)"></i>
                                    </div>
                                    <span class="badge bg-warning bg-opacity-20 text-warning ms-2" id="ratingTextLabel">5 / 5 (Sangat Puas)</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-popup">Judul Usulan / Saran <span class="text-danger">*</span></label>
                            <div class="input-glass-popup">
                                <i class="bi bi-type-h1 text-secondary"></i>
                                <input type="text" name="judul" id="feedbackJudul" required 
                                       placeholder="Contoh: Tambahkan ekspor format Excel untuk Prota & Promes" class="form-control-popup">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-popup">Detail Usulan, Saran, atau Apa yang Dirasa Kurang <span class="text-danger">*</span></label>
                            <textarea name="pesan" id="feedbackPesan" rows="4" required class="form-control-popup-textarea" 
                                      placeholder="Tuliskan secara bebas masukan, kritik konstruktif, atau usulan fitur yang Anda harapkan agar sistem ini makin sempurna..."></textarea>
                        </div>

                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <span class="text-secondary small">
                                <i class="bi bi-shield-check text-success me-1"></i> Data Anda aman dan hanya terlihat oleh Superadmin.
                            </span>
                            <button type="submit" id="btnSubmitFeedback" class="btn btn-luxury-submit rounded-pill px-4 py-2">
                                <i class="bi bi-send-fill me-1.5"></i> Kirim Usul & Saran Sekarang
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ============================================== -->
                <!-- SECTION 3: PROFIL PEMBUAT APLIKASI             -->
                <!-- ============================================== -->
                <div id="welcomeSectionProfil" class="welcome-section">
                    <div class="creator-preview-card p-4 rounded-4 mb-3">
                        <div class="row align-items-center g-4">
                            <div class="col-md-4 text-center">
                                <div class="creator-avatar-wrap mx-auto">
                                    <img src="{{ app_setting('creator_avatar', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80') }}" 
                                         alt="{{ app_setting('landing_creator_name', 'Vicky Koroh') }}" class="img-fluid creator-avatar-img">
                                </div>
                                <div class="mt-3">
                                    <span class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-30 px-3 py-1 rounded-pill small fw-bold">
                                        <i class="bi bi-award-fill me-1"></i> ARSITEK & KREATOR SISTEM
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill small fw-bold mb-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> DEDIKASI PENDIDIKAN VOKASI 2026
                                </div>
                                <h3 class="fw-bold mb-1" style="color: #0b3b60;">
                                    {{ app_setting('landing_creator_name', 'Vicky Koroh') }}
                                </h3>
                                <div class="fw-semibold small mb-3" style="color: #0284c7;">
                                    {{ app_setting('creator_headline', 'Software Engineer & Educational Technology Architect') }}
                                </div>
                                <p class="small mb-3" style="line-height: 1.6; color: #475569 !important;">
                                    {{ Str::limit(app_setting('creator_bio', 'Vicky Koroh adalah pengembang teknologi pendidikan dan arsitek perangkat lunak yang berdedikasi menciptakan inovasi kecerdasan digital untuk memberdayakan para pendidik kejuruan (SMK) di seluruh nusantara.'), 260) }}
                                </p>
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    <span class="skill-pill-sm"><i class="bi bi-cpu text-warning me-1"></i> AI System</span>
                                    <span class="skill-pill-sm"><i class="bi bi-diagram-3 text-info me-1"></i> Kurikulum Merdeka</span>
                                    <span class="skill-pill-sm"><i class="bi bi-code-slash text-success me-1"></i> Fullstack Web</span>
                                    <span class="skill-pill-sm"><i class="bi bi-shield-lock text-danger me-1"></i> Cloud Architecture</span>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('creator.profile') }}" class="btn btn-luxury-profile rounded-pill px-4 py-2">
                                        <i class="bi bi-box-arrow-up-right me-1.5"></i> Buka Halaman Profil Lengkap & Kontak
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- MODAL FOOTER -->
            <div class="modal-footer welcome-modal-footer d-flex align-items-center justify-content-between border-0 pt-0 px-4 pb-3">
                <div class="form-check text-secondary small">
                    <input class="form-check-input" type="checkbox" id="chkDoNotShowToday" onchange="toggleDoNotShow(this)">
                    <label class="form-check-label cursor-pointer fw-medium" for="chkDoNotShowToday" style="font-size: 0.82rem; color: #475569 !important;">
                        Jangan tampilkan pop-up ini lagi hari ini
                    </label>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3.5 py-1.5 small fw-semibold" data-bs-dismiss="modal" onclick="closeWelcomePopup()">
                        Tutup
                    </button>
                    <a href="{{ route('generator.index') }}" class="btn btn-primary rounded-pill px-3 py-1.5 small fw-semibold shadow-sm">
                        <i class="bi bi-lightning-charge-fill text-warning me-1"></i> Mulai Buat Perangkat Ajar
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- FLOATING ACTION BUTTON UNTUK MEMBUKA KEMBALI POP-UP          -->
<!-- ============================================================ -->
<button type="button" class="floating-guide-btn" id="openWelcomeGuideFab" onclick="openWelcomePopup()" title="Pusat Informasi, Panduan & Saran">
    <div class="fab-pulse"></div>
    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-stars fs-5 text-warning"></i>
        <span class="fab-text fw-bold">Panduan & Saran</span>
    </div>
</button>

<!-- ============================================================ -->
<!-- STYLE POP-UP & FLOATING BUTTON                               -->
<!-- ============================================================ -->
<style>
    /* Modal Backdrop & Glass Container - Kemendikdasmen White & Sky Blue */
    .welcome-modal-custom .modal-content {
        background: #ffffff !important;
        border: 1.5px solid #bae6fd !important;
        border-radius: 20px !important;
        box-shadow: 0 25px 60px rgba(11, 59, 96, 0.25) !important;
        color: #1e293b;
        overflow: hidden;
    }

    .welcome-modal-header {
        background: linear-gradient(135deg, #0b3b60 0%, #0284c7 100%) !important;
        padding: 22px 24px !important;
        color: #ffffff !important;
    }

    .welcome-modal-custom .menu-subtitle {
        color: #0284c7 !important;
    }
    .welcome-modal-custom .form-label-popup {
        color: #0b3b60 !important;
        font-weight: 700;
    }
    .welcome-modal-custom .form-control-popup::placeholder,
    .welcome-modal-custom .form-control-popup-textarea::placeholder {
        color: #94a3b8 !important;
    }
    .welcome-modal-custom .welcome-acc-body {
        color: #334155 !important;
    }
    .welcome-modal-custom .welcome-acc-body p,
    .welcome-modal-custom .welcome-acc-body li,
    .welcome-modal-custom .welcome-acc-body div {
        color: #334155;
    }
    .welcome-acc-button {
        cursor: pointer !important;
    }

    .welcome-header-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.15);
        border: 1.5px solid rgba(255, 255, 255, 0.4);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #fbbf24;
    }

    .welcome-badge {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 30px;
        padding: 3px 12px;
        font-size: 0.72rem;
        font-weight: 700;
        color: #ffffff;
    }

    /* 3 Action Menu Buttons */
    .welcome-menu-btn {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 14px;
        transition: all 0.25s ease;
        color: #1e293b;
    }

    .welcome-menu-btn:hover {
        background: #f0f9ff;
        border-color: #7dd3fc;
        transform: translateY(-2px);
    }

    .welcome-menu-btn.active {
        background: #e0f2fe;
        border-color: #0284c7;
        box-shadow: 0 4px 14px rgba(2, 132, 199, 0.2);
    }

    .menu-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .menu-title {
        font-weight: 700;
        font-size: 0.88rem;
        color: #0b3b60;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-subtitle {
        font-size: 0.75rem;
        color: #0284c7;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Sections */
    .welcome-section {
        display: none;
    }

    .welcome-section.active {
        display: block;
        animation: fadeInWelcome 0.3s ease;
    }

    @keyframes fadeInWelcome {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Accordion Customization */
    .welcome-acc-item {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        overflow: hidden;
    }

    .welcome-acc-button {
        background: #f8fafc !important;
        color: #0b3b60 !important;
        font-weight: 700;
        font-size: 0.88rem;
        padding: 12px 16px;
        box-shadow: none !important;
    }

    .welcome-acc-button:not(.collapsed) {
        background: #e0f2fe !important;
        color: #0284c7 !important;
        border-bottom: 1px solid #bae6fd;
    }

    .acc-num-badge {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background: #e0f2fe;
        border: 1px solid #bae6fd;
        color: #0284c7;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .welcome-acc-body {
        color: #334155;
        font-size: 0.84rem;
        line-height: 1.6;
        padding: 14px 16px;
        background: #ffffff;
    }

    /* Feedback Form Controls */
    .form-label-popup {
        font-size: 0.78rem;
        font-weight: 700;
        color: #0b3b60;
        margin-bottom: 4px;
    }

    .input-glass-popup {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 6px 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .input-glass-popup:focus-within {
        background: #ffffff;
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }

    .form-control-popup {
        background: transparent !important;
        border: none !important;
        color: #1e293b !important;
        font-size: 0.85rem;
        width: 100%;
        outline: none;
    }

    .form-control-popup::placeholder {
        color: #94a3b8;
    }

    .select-popup {
        background-color: #f8fafc !important;
        color: #1e293b !important;
        cursor: pointer;
    }

    .select-popup option {
        background-color: #ffffff;
        color: #1e293b;
    }

    .form-control-popup-textarea {
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 12px;
        width: 100%;
        color: #1e293b;
        font-size: 0.85rem;
        outline: none;
        transition: all 0.2s;
    }

    .form-control-popup-textarea:focus {
        background: #ffffff;
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }

    .btn-luxury-submit {
        background: linear-gradient(135deg, #0284c7, #0369a1);
        color: #ffffff;
        border: none;
        font-weight: 700;
        font-size: 0.88rem;
        box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        transition: all 0.25s ease;
    }

    .btn-luxury-submit:hover {
        background: linear-gradient(135deg, #0369a1, #0b3b60);
        transform: translateY(-1.5px);
        box-shadow: 0 6px 18px rgba(2, 132, 199, 0.5);
        color: #ffffff;
    }

    /* Creator Preview Card */
    .creator-preview-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .creator-avatar-wrap {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        padding: 3px;
        background: linear-gradient(135deg, #0284c7, #38bdf8);
        box-shadow: 0 4px 14px rgba(2, 132, 199, 0.25);
    }

    .creator-avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .skill-pill-sm {
        background: #ffffff;
        border: 1px solid #bae6fd;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 0.72rem;
        color: #0369a1;
        font-weight: 600;
    }

    .btn-luxury-profile {
        background: linear-gradient(135deg, #0284c7, #0369a1);
        color: #ffffff;
        border: none;
        font-weight: 600;
        font-size: 0.84rem;
        box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35);
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-luxury-profile:hover {
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(2, 132, 199, 0.5);
    }

    /* Floating Action Button */
    .floating-guide-btn {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 1060;
        background: #0b3b60;
        border: 1.5px solid #0284c7;
        color: #ffffff;
        border-radius: 50px;
        padding: 10px 20px;
        box-shadow: 0 8px 24px rgba(11, 59, 96, 0.35);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .floating-guide-btn:hover {
        transform: translateY(-4px) scale(1.04);
        border-color: #38bdf8;
        background: #07253d;
        box-shadow: 0 12px 30px rgba(11, 59, 96, 0.45);
    }

    .fab-pulse {
        position: absolute;
        top: -3px;
        right: -3px;
        width: 12px;
        height: 12px;
        background-color: #38bdf8;
        border-radius: 50%;
        animation: fabPulseAnim 2s infinite;
    }

    @keyframes fabPulseAnim {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(56, 189, 248, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(56, 189, 248, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(56, 189, 248, 0); }
    }

    @media (max-width: 575.98px) {
        .floating-guide-btn {
            bottom: 16px;
            right: 16px;
            padding: 8px 14px;
        }
        .floating-guide-btn .fab-text {
            font-size: 0.8rem;
        }
        .creator-avatar-wrap {
            width: 100px;
            height: 100px;
        }
    }
</style>

<!-- ============================================================ -->
<!-- JAVASCRIPT POP-UP MANAGEMENT                                 -->
<!-- ============================================================ -->
<script>
    function switchWelcomeTab(tabName) {
        // Update menu buttons
        document.querySelectorAll('.welcome-menu-btn').forEach(btn => btn.classList.remove('active'));
        if (tabName === 'panduan') document.getElementById('btnMenuPanduan').classList.add('active');
        if (tabName === 'saran') document.getElementById('btnMenuSaran').classList.add('active');
        if (tabName === 'profil') document.getElementById('btnMenuProfil').classList.add('active');

        // Update sections
        document.querySelectorAll('.welcome-section').forEach(sec => sec.classList.remove('active'));
        if (tabName === 'panduan') document.getElementById('welcomeSectionPanduan').classList.add('active');
        if (tabName === 'saran') document.getElementById('welcomeSectionSaran').classList.add('active');
        if (tabName === 'profil') document.getElementById('welcomeSectionProfil').classList.add('active');
    }

    function setFeedbackRating(val) {
        document.getElementById('feedbackRating').value = val;
        const stars = document.querySelectorAll('#starContainer .star-item');
        stars.forEach((star, idx) => {
            if (idx < val) {
                star.className = 'bi bi-star-fill text-warning fs-5 star-item cursor-pointer';
            } else {
                star.className = 'bi bi-star text-secondary fs-5 star-item cursor-pointer';
            }
        });

        const labels = {
            1: '1 / 5 (Kurang Sekali)',
            2: '2 / 5 (Kurang Puas)',
            3: '3 / 5 (Cukup Baik)',
            4: '4 / 5 (Puas & Bermanfaat)',
            5: '5 / 5 (Sangat Puas & Luar Biasa)'
        };
        document.getElementById('ratingTextLabel').innerText = labels[val] || (val + ' / 5');
    }

    function openWelcomePopup(tab = 'panduan') {
        switchWelcomeTab(tab);
        const modalEl = document.getElementById('welcomeGuideModal');
        if (!modalEl) return;

        try {
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                modalInstance.show();
                return;
            }
        } catch (err) {
            console.warn('Bootstrap modal show fallback:', err);
        }

        // Pure JS fallback jika bootstrap belum siap
        modalEl.classList.add('show');
        modalEl.style.display = 'block';
        modalEl.removeAttribute('aria-hidden');
        modalEl.setAttribute('aria-modal', 'true');
        document.body.classList.add('modal-open');

        let backdrop = document.getElementById('welcomeModalBackdropFallback');
        if (!backdrop) {
            backdrop = document.createElement('div');
            backdrop.id = 'welcomeModalBackdropFallback';
            backdrop.className = 'modal-backdrop fade show';
            backdrop.onclick = closeWelcomePopup;
            document.body.appendChild(backdrop);
        }
    }

    function closeWelcomePopup() {
        const modalEl = document.getElementById('welcomeGuideModal');
        if (modalEl) {
            try {
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const instance = bootstrap.Modal.getInstance(modalEl);
                    if (instance) {
                        instance.hide();
                    }
                }
            } catch (err) {}
            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            modalEl.setAttribute('aria-hidden', 'true');
            modalEl.removeAttribute('aria-modal');
        }
        document.body.classList.remove('modal-open');
        const fallbackBackdrop = document.getElementById('welcomeModalBackdropFallback');
        if (fallbackBackdrop) fallbackBackdrop.remove();
        document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
    }

    function toggleDoNotShow(chk) {
        if (chk.checked) {
            const todayStr = new Date().toISOString().slice(0, 10);
            localStorage.setItem('hide_welcome_popup_date', todayStr);
        } else {
            localStorage.removeItem('hide_welcome_popup_date');
        }
    }

    // Manual Accordion Fallback
    function manualToggleAccordion(btn, targetEl) {
        const isShown = targetEl.classList.contains('show');
        const parentSelector = targetEl.getAttribute('data-bs-parent');
        if (parentSelector) {
            const parent = document.querySelector(parentSelector);
            if (parent) {
                parent.querySelectorAll('.accordion-collapse').forEach(item => item.classList.remove('show'));
                parent.querySelectorAll('.welcome-acc-button').forEach(b => {
                    b.classList.add('collapsed');
                    b.setAttribute('aria-expanded', 'false');
                });
            }
        }
        if (isShown) {
            targetEl.classList.remove('show');
            btn.classList.add('collapsed');
            btn.setAttribute('aria-expanded', 'false');
        } else {
            targetEl.classList.add('show');
            btn.classList.remove('collapsed');
            btn.setAttribute('aria-expanded', 'true');
        }
    }

    function initWelcomeAccordion() {
        document.querySelectorAll('.welcome-acc-button').forEach(btn => {
            btn.addEventListener('click', function (e) {
                const targetSelector = this.getAttribute('data-bs-target');
                if (!targetSelector) return;
                const targetEl = document.querySelector(targetSelector);
                if (!targetEl) return;

                if (typeof bootstrap === 'undefined' || !bootstrap.Collapse) {
                    e.preventDefault();
                    manualToggleAccordion(this, targetEl);
                }
            });
        });
    }

    async function submitWelcomeFeedback(e) {
        e.preventDefault();
        const form = document.getElementById('welcomeFeedbackForm');
        const submitBtn = document.getElementById('btnSubmitFeedback');
        const alertBox = document.getElementById('feedbackAlertBox');

        const originalBtnHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengirim masukan...';
        alertBox.className = 'd-none';

        const formData = new FormData(form);

        try {
            const response = await fetch("{{ route('feedback.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.success) {
                alertBox.className = 'alert alert-success border border-success-subtle bg-success-subtle text-dark py-2.5 px-3 rounded-3 mb-3 d-flex align-items-center gap-2';
                alertBox.innerHTML = '<i class="bi bi-check-circle-fill text-success fs-5"></i> <div>' + data.message + '</div>';
                form.reset();
                setFeedbackRating(5);
            } else {
                let errMsg = data.message || 'Terjadi kesalahan saat mengirim masukan.';
                if (data.errors) {
                    errMsg = Object.values(data.errors).flat().join('<br>');
                }
                alertBox.className = 'alert alert-danger border border-danger-subtle bg-danger-subtle text-dark py-2.5 px-3 rounded-3 mb-3 d-flex align-items-center gap-2';
                alertBox.innerHTML = '<i class="bi bi-x-circle-fill text-danger fs-5"></i> <div>' + errMsg + '</div>';
            }
        } catch (err) {
            alertBox.className = 'alert alert-danger border border-danger-subtle bg-danger-subtle text-dark py-2.5 px-3 rounded-3 mb-3 d-flex align-items-center gap-2';
            alertBox.innerHTML = '<i class="bi bi-wifi-off text-danger fs-5"></i> <div>Koneksi gagal. Silakan coba kembali sesaat lagi.</div>';
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnHtml;
        }
    }

    // Auto-open modal on visit & init bindings
    document.addEventListener('DOMContentLoaded', function () {
        initWelcomeAccordion();

        // Bind escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeWelcomePopup();
        });

        // Bind FAB click explicitly
        const fab = document.getElementById('openWelcomeGuideFab');
        if (fab) {
            fab.addEventListener('click', function() {
                openWelcomePopup('panduan');
            });
        }

        const todayStr = new Date().toISOString().slice(0, 10);
        const hideDate = localStorage.getItem('hide_welcome_popup_date');
        const chk = document.getElementById('chkDoNotShowToday');
        if (chk) {
            chk.checked = (hideDate === todayStr);
        }

        const urlParams = new URLSearchParams(window.location.search);
        const forceOpen = urlParams.has('popup') || urlParams.has('panduan') || urlParams.has('guide');

        if (forceOpen || hideDate !== todayStr) {
            setTimeout(function () {
                openWelcomePopup('panduan');
            }, 600);
        }
    });
</script>
