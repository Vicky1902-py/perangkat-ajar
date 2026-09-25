@extends('layouts.app')

@section('title', 'Pengaturan Aplikasi & CMS')

@section('content')
<div class="container-fluid px-0">
    <!-- HEADER -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1 rounded-pill small fw-bold">
                    <i class="bi bi-shield-lock-fill me-1"></i> SUPERADMIN CONTROL
                </span>
                <span class="text-muted small">Konfigurasi Sistem Terpadu</span>
            </div>
            <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-sliders2 text-primary"></i> Pengaturan Aplikasi & CMS
            </h3>
            <p class="text-muted small mb-0">
                Kelola identitas visual (Logo, Favicon), Full CMS Landing Page, tema warna sistem, pencadangan database mandiri (Pure PHP), dan sinkronisasi regulasi kurikulum.
            </p>
        </div>
        <div>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Pratinjau Landing Page
            </a>
        </div>
    </div>

    @php
        $activeTab = request('tab', 'branding');
    @endphp

    <!-- NAVIGATION TABS -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-2">
            <ul class="nav nav-pills nav-fill flex-column flex-md-row gap-1" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-start text-md-center rounded-3 py-2.5 px-3 {{ $activeTab === 'branding' ? 'active shadow-sm' : '' }}" 
                            id="tab-branding" data-bs-toggle="tab" data-bs-target="#pane-branding" type="button" role="tab">
                        <i class="bi bi-palette2 me-1.5"></i> Identitas & Logo
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-start text-md-center rounded-3 py-2.5 px-3 {{ $activeTab === 'theme' ? 'active shadow-sm' : '' }}" 
                            id="tab-theme" data-bs-toggle="tab" data-bs-target="#pane-theme" type="button" role="tab">
                        <i class="bi bi-brush me-1.5"></i> Tema & Warna
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-start text-md-center rounded-3 py-2.5 px-3 {{ $activeTab === 'landing' ? 'active shadow-sm' : '' }}" 
                            id="tab-landing" data-bs-toggle="tab" data-bs-target="#pane-landing" type="button" role="tab">
                        <i class="bi bi-layout-text-sidebar-reverse me-1.5"></i> Full CMS Landing Page
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-start text-md-center rounded-3 py-2.5 px-3 {{ $activeTab === 'backup' ? 'active shadow-sm' : '' }}" 
                            id="tab-backup" data-bs-toggle="tab" data-bs-target="#pane-backup" type="button" role="tab">
                        <i class="bi bi-database-down me-1.5"></i> Backup Database
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-start text-md-center rounded-3 py-2.5 px-3 {{ $activeTab === 'regulation' ? 'active shadow-sm' : '' }}" 
                            id="tab-regulation" data-bs-toggle="tab" data-bs-target="#pane-regulation" type="button" role="tab">
                        <i class="bi bi-journal-check me-1.5"></i> Regulasi Kurikulum
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-start text-md-center rounded-3 py-2.5 px-3 {{ $activeTab === 'creator' ? 'active shadow-sm' : '' }}" 
                            id="tab-creator" data-bs-toggle="tab" data-bs-target="#pane-creator" type="button" role="tab">
                        <i class="bi bi-person-bounding-box me-1.5"></i> Profil Pembuat
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-start text-md-center rounded-3 py-2.5 px-3 {{ $activeTab === 'adsense' ? 'active shadow-sm' : '' }}" 
                            id="tab-adsense" data-bs-toggle="tab" data-bs-target="#pane-adsense" type="button" role="tab">
                        <i class="bi bi-google me-1.5 text-warning"></i> Iklan & AdSense
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-start text-md-center rounded-3 py-2.5 px-3 {{ $activeTab === 'seo' ? 'active shadow-sm' : '' }}" 
                            id="tab-seo" data-bs-toggle="tab" data-bs-target="#pane-seo" type="button" role="tab">
                        <i class="bi bi-search me-1.5 text-success"></i> Search Console &amp; SEO
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-start text-md-center rounded-3 py-2.5 px-3 {{ $activeTab === 'system' ? 'active shadow-sm' : '' }}" 
                            id="tab-system" data-bs-toggle="tab" data-bs-target="#pane-system" type="button" role="tab">
                        <i class="bi bi-gear-fill me-1.5 text-danger"></i> Sistem & Maintenance
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- TAB CONTENTS -->
    <div class="tab-content" id="settingsTabsContent">

        <!-- ========================================== -->
        <!-- TAB 1: IDENTITAS & LOGO -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab === 'branding' ? 'show active' : '' }}" id="pane-branding" role="tabpanel">
            <form action="{{ route('cms.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="active_tab" value="branding">

                <div class="row g-4">
                    <!-- INFORMASI UMUM SITUS -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-info-circle text-primary"></i> Nama & Slogan Platform
                                </h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">Nama Aplikasi / Platform</label>
                                    <input type="text" name="app_name" class="form-control" value="{{ app_setting('app_name', 'Sistem Perangkat Ajar SMK 2026') }}" required>
                                    <div class="form-text small">Tampil di judul navbar, header dokumen, dan tab peramban.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">Tagline / Slogan Kurikulum</label>
                                    <textarea name="app_tagline" class="form-control" rows="3">{{ app_setting('app_tagline', 'Kurikulum Merdeka (Pendekatan Pembelajaran Mendalam / Deep Learning)') }}</textarea>
                                    <div class="form-text small">Subjudul pendukung yang menjelaskan fungsi platform.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- UPLOAD LOGO & FAVICON -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white py-3 border-bottom">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-image text-primary"></i> Unggah Logo & Favicon
                                </h6>
                            </div>
                            <div class="card-body p-4">
                                <!-- LOGO APLIKASI -->
                                <div class="mb-4 pb-3 border-bottom">
                                    <label class="form-label small fw-bold text-dark">Logo Aplikasi Utama</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="p-2 border rounded-3 bg-light text-center" style="min-width: 80px; min-height: 80px; display: flex; align-items: center; justify-content: center;">
                                            @if(app_logo_url())
                                                <img src="{{ app_logo_url() }}" alt="Logo" style="max-height: 60px; max-width: 140px; object-fit: contain;">
                                            @else
                                                <div class="rounded-3 bg-primary p-2 text-white shadow-sm d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                    <i class="bi bi-journal-bookmark-fill fs-4"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="app_logo" class="form-control form-control-sm mb-1" accept="image/png,image/jpeg,image/svg+xml,image/webp">
                                            <span class="text-muted small" style="font-size: 0.74rem;">Format: PNG, SVG, JPG, WebP. Maks 3 MB. Transparan disarankan.</span>
                                            @if(app_logo_url())
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" name="remove_app_logo" value="1" id="removeLogo">
                                                    <label class="form-check-label text-danger small" for="removeLogo">
                                                        Kembalikan ke logo bawaan (Default SVG)
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- FAVICON -->
                                <div>
                                    <label class="form-label small fw-bold text-dark">Favicon Browser</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="p-2 border rounded-3 bg-light text-center" style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                                            @if(app_favicon_url())
                                                <img src="{{ app_favicon_url() }}" alt="Favicon" style="max-height: 32px; max-width: 32px;">
                                            @else
                                                <i class="bi bi-globe2 fs-4 text-secondary"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="app_favicon" class="form-control form-control-sm mb-1" accept=".ico,image/png,image/svg+xml">
                                            <span class="text-muted small" style="font-size: 0.74rem;">Format: ICO, PNG, SVG (Ukuran ideal: 32x32 atau 64x64 px).</span>
                                            @if(app_favicon_url())
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" name="remove_app_favicon" value="1" id="removeFav">
                                                    <label class="form-check-label text-danger small" for="removeFav">
                                                        Kembalikan ke favicon default
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> Simpan Pengaturan Identitas
                    </button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: TEMA & WARNA VISUAL -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab === 'theme' ? 'show active' : '' }}" id="pane-theme" role="tabpanel">
            <form action="{{ route('cms.settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="active_tab" value="theme">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-palette text-primary"></i> Pilihan Palet Tema Visual Sistem
                        </h6>
                        <form action="{{ route('cms.settings.reset-theme') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="return confirm('Kembalikan tema ke pengaturan bawaan?')">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset ke Tema Bawaan 2026
                            </button>
                        </form>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted small mb-4">
                            Pilih salah satu palet tema siap pakai di bawah ini, atau sesuaikan kode warna primer dan aksen secara spesifik sesuai selera visual institusi Anda.
                        </p>

                        <!-- PILIHAN PRESET KARTU -->
                        @php
                            $currentPreset = app_setting('theme_preset', 'cosmic_sapphire');
                        @endphp
                        <div class="row g-3 mb-4">
                            @foreach($themePresets as $pKey => $preset)
                                <div class="col-md-6 col-lg-4">
                                    <label class="card h-100 p-3 border-2 cursor-pointer transition-all position-relative rounded-4 {{ $currentPreset === $pKey ? 'border-primary shadow' : 'border-light-subtle' }}" style="cursor: pointer;">
                                        <div class="d-flex align-items-start gap-2 mb-2">
                                            <input type="radio" name="theme_preset" value="{{ $pKey }}" class="form-check-input mt-1" {{ $currentPreset === $pKey ? 'checked' : '' }} onchange="applyPresetColors('{{ $preset['primary'] }}', '{{ $preset['cyan'] }}', '{{ $preset['indigo'] }}')">
                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">{{ $preset['name'] }}</h6>
                                                <p class="text-muted small mb-2" style="font-size: 0.78rem;">{{ $preset['desc'] }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 mt-auto pt-2 border-top">
                                            <span class="d-inline-block rounded-circle border" style="width: 24px; height: 24px; background: {{ $preset['primary'] }};" title="Primary"></span>
                                            <span class="d-inline-block rounded-circle border" style="width: 24px; height: 24px; background: {{ $preset['cyan'] }};" title="Cyan / Light"></span>
                                            <span class="d-inline-block rounded-circle border" style="width: 24px; height: 24px; background: {{ $preset['indigo'] }};" title="Indigo / Glow"></span>
                                            <span class="ms-auto badge bg-light text-secondary border small">{{ $pKey }}</span>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <hr class="opacity-10 my-4">

                        <!-- CUSTOM COLOR PICKERS -->
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-eyedropper text-primary me-1"></i> Kustomisasi Warna Spesifik (HEX Color)</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-dark">Warna Utama (Primary Glow)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" id="primaryColorPicker" name="theme_primary_color" value="{{ app_setting('theme_primary_color', '#2563eb') }}" title="Pilih warna utama" onchange="document.getElementById('primaryColorText').value = this.value">
                                    <input type="text" class="form-control font-monospace" id="primaryColorText" value="{{ app_setting('theme_primary_color', '#2563eb') }}" oninput="document.getElementById('primaryColorPicker').value = this.value">
                                </div>
                                <div class="form-text small">Warna tombol utama, kartu aktif, dan navigasi.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-dark">Warna Aksen 1 (Cyan / Highlight)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" id="cyanColorPicker" name="theme_accent_cyan" value="{{ app_setting('theme_accent_cyan', '#38bdf8') }}" title="Pilih aksen 1" onchange="document.getElementById('cyanColorText').value = this.value">
                                    <input type="text" class="form-control font-monospace" id="cyanColorText" value="{{ app_setting('theme_accent_cyan', '#38bdf8') }}" oninput="document.getElementById('cyanColorPicker').value = this.value">
                                </div>
                                <div class="form-text small">Warna pendaran teks, ikon penanda, dan hover border.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-semibold text-dark">Warna Aksen 2 (Indigo / Glow)</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color" id="indigoColorPicker" name="theme_accent_indigo" value="{{ app_setting('theme_accent_indigo', '#6366f1') }}" title="Pilih aksen 2" onchange="document.getElementById('indigoColorText').value = this.value">
                                    <input type="text" class="form-control font-monospace" id="indigoColorText" value="{{ app_setting('theme_accent_indigo', '#6366f1') }}" oninput="document.getElementById('indigoColorPicker').value = this.value">
                                </div>
                                <div class="form-text small">Warna pendaran latar orb ambient & gradien tombol.</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light p-3 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                            <i class="bi bi-brush-fill me-1"></i> Terapkan Tema Visual
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- TAB 3: FULL CMS LANDING / WELCOME PAGE -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab === 'landing' ? 'show active' : '' }}" id="pane-landing" role="tabpanel">
            <form action="{{ route('cms.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="active_tab" value="landing">

                <!-- SECTION 1: HERO LANDING PAGE -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-star-fill text-warning"></i> Bagian 1: Hero & Judul Utama Landing Page
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-dark">Teks Lencana Hero (Top Badge)</label>
                                <input type="text" name="landing_hero_badge" class="form-control" value="{{ app_setting('landing_hero_badge', 'STANDAR RESMI KURIKULUM MERDEKA 2026 • BSKAP 046/2025') }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-dark">Judul Utama Halaman Depan (Hero Title)</label>
                                <input type="text" name="landing_hero_title" class="form-control" value="{{ app_setting('landing_hero_title', 'Revolusi Penyusunan Perangkat Ajar SMK 2026 Berbasis Deep Learning') }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-dark">Deskripsi / Subjudul Hero</label>
                                <textarea name="landing_hero_subtitle" class="form-control" rows="3">{{ app_setting('landing_hero_subtitle', 'Platform komputasi cerdas yang mengotomatisasi penyusunan TP, ATP, Modul Ajar PEDATTI, LKPD, Prota, Promes, dan Asesmen ber-Kop Surat Resmi Kedinasan sesuai Keputusan Kepala BSKAP Nomor 046/H/KR/2025 & Permendikdasmen No. 13/2025.') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">Teks Tombol Aksi Utama (CTA 1)</label>
                                <input type="text" name="landing_hero_cta_primary" class="form-control" value="{{ app_setting('landing_hero_cta_primary', 'Coba Generator Gratis (Maks. 2x)') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">Foto Mockup Hero (Sisi Kanan)</label>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ app_setting('landing_hero_image') }}" alt="Hero Img" class="rounded-3 border object-fit-cover shadow-sm" style="width: 80px; height: 50px;">
                                    <div class="flex-grow-1">
                                        <input type="file" name="landing_hero_image_file" class="form-control form-control-sm mb-1" accept="image/*">
                                        <input type="text" name="landing_hero_image_url" class="form-control form-control-sm" placeholder="Atau tempel URL gambar (https://...)" value="{{ app_setting('landing_hero_image') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: 3 PILAR DEEP LEARNING (MINDFUL, MEANINGFUL, JOYFUL) -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-grid-3x3-gap-fill text-primary"></i> Bagian 2: Tiga Pilar Pembelajaran Mendalam (Deep Learning)
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- PILAR 1: MINDFUL -->
                            <div class="col-lg-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="badge bg-info text-dark fw-bold mb-2">Pilar 1: Mindful</div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-0">Judul Pilar</label>
                                        <input type="text" name="landing_pilar_mindful_title" class="form-control form-control-sm" value="{{ app_setting('landing_pilar_mindful_title', 'Mindful') }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-0">Subjudul Pilar</label>
                                        <input type="text" name="landing_pilar_mindful_subtitle" class="form-control form-control-sm" value="{{ app_setting('landing_pilar_mindful_subtitle', 'Pembelajaran Berkesadaran') }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-0">Deskripsi</label>
                                        <textarea name="landing_pilar_mindful_desc" class="form-control form-control-sm" rows="3">{{ app_setting('landing_pilar_mindful_desc') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-semibold mb-0">Foto Pilar (Upload / URL)</label>
                                        <img src="{{ app_setting('landing_pilar_mindful_img') }}" class="rounded-2 w-100 mb-1 border" style="height: 100px; object-fit: cover;">
                                        <input type="file" name="landing_pilar_mindful_img_file" class="form-control form-control-sm mb-1" accept="image/*">
                                        <input type="text" name="landing_pilar_mindful_img_url" class="form-control form-control-sm" placeholder="URL Foto..." value="{{ app_setting('landing_pilar_mindful_img') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- PILAR 2: MEANINGFUL -->
                            <div class="col-lg-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="badge bg-warning text-dark fw-bold mb-2">Pilar 2: Meaningful</div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-0">Judul Pilar</label>
                                        <input type="text" name="landing_pilar_meaningful_title" class="form-control form-control-sm" value="{{ app_setting('landing_pilar_meaningful_title', 'Meaningful') }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-0">Subjudul Pilar</label>
                                        <input type="text" name="landing_pilar_meaningful_subtitle" class="form-control form-control-sm" value="{{ app_setting('landing_pilar_meaningful_subtitle', 'Pembelajaran Bermakna') }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-0">Deskripsi</label>
                                        <textarea name="landing_pilar_meaningful_desc" class="form-control form-control-sm" rows="3">{{ app_setting('landing_pilar_meaningful_desc') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-semibold mb-0">Foto Pilar (Upload / URL)</label>
                                        <img src="{{ app_setting('landing_pilar_meaningful_img') }}" class="rounded-2 w-100 mb-1 border" style="height: 100px; object-fit: cover;">
                                        <input type="file" name="landing_pilar_meaningful_img_file" class="form-control form-control-sm mb-1" accept="image/*">
                                        <input type="text" name="landing_pilar_meaningful_img_url" class="form-control form-control-sm" placeholder="URL Foto..." value="{{ app_setting('landing_pilar_meaningful_img') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- PILAR 3: JOYFUL -->
                            <div class="col-lg-4">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <div class="badge bg-success text-white fw-bold mb-2">Pilar 3: Joyful</div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-0">Judul Pilar</label>
                                        <input type="text" name="landing_pilar_joyful_title" class="form-control form-control-sm" value="{{ app_setting('landing_pilar_joyful_title', 'Joyful') }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-0">Subjudul Pilar</label>
                                        <input type="text" name="landing_pilar_joyful_subtitle" class="form-control form-control-sm" value="{{ app_setting('landing_pilar_joyful_subtitle', 'Pembelajaran Menggembirakan') }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold mb-0">Deskripsi</label>
                                        <textarea name="landing_pilar_joyful_desc" class="form-control form-control-sm" rows="3">{{ app_setting('landing_pilar_joyful_desc') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-semibold mb-0">Foto Pilar (Upload / URL)</label>
                                        <img src="{{ app_setting('landing_pilar_joyful_img') }}" class="rounded-2 w-100 mb-1 border" style="height: 100px; object-fit: cover;">
                                        <input type="file" name="landing_pilar_joyful_img_file" class="form-control form-control-sm mb-1" accept="image/*">
                                        <input type="text" name="landing_pilar_joyful_img_url" class="form-control form-control-sm" placeholder="URL Foto..." value="{{ app_setting('landing_pilar_joyful_img') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: HAK CIPTA & KARYA PENGEMBANG -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-award-fill text-warning"></i> Bagian 3: Identitas Karya & Hak Cipta
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">Nama Pembuat / Arsitek Utama</label>
                                <input type="text" name="landing_creator_name" class="form-control" value="{{ app_setting('landing_creator_name', 'Vicky Koroh') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">Jabatan / Gelar Arsitek</label>
                                <input type="text" name="landing_creator_role" class="form-control" value="{{ app_setting('landing_creator_role', 'Super Administrator & Lead Architect') }}">
                            </div>
                            <div class="col-md-9">
                                <label class="form-label small fw-bold text-dark">Keterangan / Pernyataan Karya</label>
                                <textarea name="landing_creator_desc" class="form-control" rows="2">{{ app_setting('landing_creator_desc', 'Karya inovasi teknologi pendidikan kejuruan yang didesain dan dikembangkan secara khusus untuk mendukung guru SMK di seluruh Indonesia.') }}</textarea>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold text-dark">Tahun Hak Cipta</label>
                                <input type="text" name="landing_copyright_year" class="form-control" value="{{ app_setting('landing_copyright_year', '2026') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light p-3 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                            <i class="bi bi-check-circle-fill me-1"></i> Simpan Perubahan CMS Landing Page
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- TAB 4: BACKUP DATABASE MANDIRI -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab === 'backup' ? 'show active' : '' }}" id="pane-backup" role="tabpanel">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                            <i class="bi bi-database-down text-success"></i> Pencadangan Database Mandiri (Pure PHP Engine)
                        </h6>
                        <span class="text-muted small">Mencadangkan seluruh tabel, skema, master data, dan file transaksi ke file SQL standar.</span>
                    </div>
                    <form action="{{ route('cms.settings.backup.create') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm fw-bold">
                            <i class="bi bi-download me-1"></i> Buat Backup Baru Sekarang (.sql)
                        </button>
                    </form>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 bg-primary bg-opacity-10 text-dark p-3 rounded-3 mb-4 d-flex align-items-start gap-3">
                        <i class="bi bi-shield-check fs-3 text-primary"></i>
                        <div class="small">
                            <strong>100% Kompatibel dengan cPanel Shared Hosting (Rumahweb):</strong><br>
                            Sistem backup ini menggunakan koneksi <em>Pure PHP PDO Streaming</em> bawaan aplikasi. Anda tidak perlu khawatir hosting memblokir perintah <code>mysqldump</code> atau mematikan fungsi <code>exec()</code>, karena seluruh proses dijalankan langsung oleh mesin PHP.
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-clock-history me-1 text-secondary"></i> Riwayat File Backup Tersimpan ({{ count($backups) }})</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border mb-0">
                            <thead class="table-light">
                                <tr class="text-secondary small text-uppercase">
                                    <th width="5%">No</th>
                                    <th>Nama File Backup (.sql)</th>
                                    <th>Ukuran File</th>
                                    <th>Waktu Dibuat</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($backups as $bIdx => $b)
                                    <tr>
                                        <td>{{ $bIdx + 1 }}</td>
                                        <td>
                                            <i class="bi bi-filetype-sql text-primary me-1 fs-5"></i>
                                            <strong class="text-dark font-monospace small">{{ $b['filename'] }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">
                                                {{ $b['size'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $b['created_at'] }}</small>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1.5">
                                                <a href="{{ route('cms.settings.backup.download', $b['filename']) }}" class="btn btn-sm btn-primary rounded-pill px-2.5 py-1" title="Unduh ke komputer">
                                                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Unduh
                                                </a>
                                                <form action="{{ route('cms.settings.backup.delete', $b['filename']) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus file backup {{ $b['filename'] }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" title="Hapus file">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-2 d-block mb-1 opacity-50"></i>
                                            Belum ada file cadangan database. Klik tombol "Buat Backup Baru Sekarang" untuk membuat cadangan pertama Anda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 5: REGULASI KURIKULUM & SINKRONISASI -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab === 'regulation' ? 'show active' : '' }}" id="pane-regulation" role="tabpanel">
            <div class="row g-4">
                <!-- STATUS REGULASI AKTIF -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-check2-circle text-success"></i> Standar Regulasi Kurikulum Aktif
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="p-3.5 rounded-3 mb-4 border" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left: 5px solid #16a34a !important;">
                                <div class="small text-muted fw-semibold text-uppercase">Regulasi yang Saat Ini Digunakan Generator</div>
                                <h5 class="fw-bold text-dark mt-1 mb-2">{{ $regulationInfo['active_regulation'] }}</h5>
                                <div class="small text-secondary">
                                    Setiap dokumen yang dibuat di generator (TP, ATP, Modul Ajar PEDATTI, LKPD, Prota, Promes) otomatis menyematkan nomor regulasi resmi ini.
                                </div>
                            </div>

                            <h6 class="fw-bold text-dark mb-2">Daftar Regulasi Terdaftar di Database</h6>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle border mb-3">
                                    <thead class="table-light">
                                        <tr class="small text-secondary">
                                            <th>Nama Dokumen Regulasi</th>
                                            <th class="text-center">Total CP</th>
                                            <th class="text-center">Mata Pelajaran</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($regulationInfo['list'] as $reg)
                                            <tr>
                                                <td>
                                                    <strong>{{ $reg->regulasi }}</strong>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary border">{{ $reg->total_cp }} CP</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border">{{ $reg->total_mapel }} Mapel</span>
                                                </td>
                                                <td class="text-center">
                                                    @if($reg->regulasi === $regulationInfo['active_regulation'])
                                                        <span class="badge bg-success px-2.5 py-1 rounded-pill">AKTIF</span>
                                                    @else
                                                        <form action="{{ route('cms.settings.sync-regulation') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="active_regulation" value="{{ $reg->regulasi }}">
                                                            <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-0.5" style="font-size: 0.76rem;">
                                                                Aktifkan
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- IMPORT PAKET REGULASI BARU -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-cloud-arrow-up text-primary"></i> Impor Regulasi Baru (JSON Package)
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-3">
                                Jika pemerintah merilis aturan Capaian Pembelajaran baru (misal BSKAP 2026/2027), unggah file paket JSON regulasi di sini. Sistem akan memperbarui database secara aman tanpa menghapus dokumen lama guru (*Safe-Upsert*).
                            </p>

                            <form action="{{ route('cms.settings.sync-regulation') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">Nama Resmi Regulasi Baru</label>
                                    <input type="text" name="regulation_name" class="form-control" placeholder="Contoh: Keputusan Kepala BSKAP Nomor ... Tahun 2027" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">File Paket Regulasi (.json)</label>
                                    <input type="file" name="regulation_package_file" class="form-control" accept=".json" required>
                                    <div class="form-text small">File JSON memuat array: mapel_kode, fase, deskripsi_cp, elemen_cp.</div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold shadow-sm">
                                    <i class="bi bi-file-earmark-arrow-up-fill me-1"></i> Proses Impor Regulasi Baru
                                </button>
                            </form>

                            <hr class="opacity-10 my-4">

                            <div class="p-3 bg-light rounded-3 border">
                                <h6 class="fw-bold text-dark small mb-1"><i class="bi bi-terminal me-1"></i> Atau Lewat Terminal cPanel:</h6>
                                <p class="text-muted small mb-2" style="font-size: 0.78rem;">
                                    Anda juga dapat menjalankan perintah terminal setelah <code>git pull</code>:
                                </p>
                                <code class="d-block p-2 bg-dark text-warning rounded-2 small font-monospace" style="font-size: 0.76rem;">
                                    php artisan curriculum:sync --regulation="BSKAP-2027"
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 6: PROFIL PEMBUAT APLIKASI (CMS)       -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab === 'creator' ? 'show active' : '' }}" id="pane-creator" role="tabpanel">
            <form action="{{ route('cms.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="active_tab" value="creator">

                <div class="row g-4">
                    <!-- FOTO AVATAR & AKSI CEPAT -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                            <div class="avatar-preview-wrapper mx-auto mb-3" style="width: 140px; height: 140px; border-radius: 50%; padding: 4px; background: linear-gradient(135deg, #38bdf8, #6366f1); box-shadow: 0 0 25px rgba(56, 189, 248, 0.3);">
                                <img src="{{ app_setting('creator_avatar', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80') }}" 
                                     alt="{{ app_setting('landing_creator_name', 'Vicky Koroh') }}" 
                                     id="creatorAvatarPreview"
                                     style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid #ffffff;">
                            </div>

                            <h5 class="fw-bold text-dark mb-1">{{ app_setting('landing_creator_name', 'Vicky Koroh') }}</h5>
                            <p class="text-muted small mb-3">{{ app_setting('creator_headline', 'Software Engineer & Educational Technology Architect') }}</p>

                            <div class="mb-3 text-start">
                                <label class="form-label small fw-bold text-dark">Unggah Foto Profil Baru</label>
                                <input type="file" name="creator_avatar_file" class="form-control form-control-sm" accept="image/*"
                                       onchange="document.getElementById('creatorAvatarPreview').src = window.URL.createObjectURL(this.files[0])">
                                <div class="form-text small" style="font-size: 0.75rem;">Format JPG/PNG/WebP, maks. 4MB.</div>
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label small fw-bold text-dark">Atau URL Foto Eksternal</label>
                                <input type="url" name="creator_avatar_url" value="{{ app_setting('creator_avatar') }}" class="form-control form-control-sm" placeholder="https://...">
                            </div>

                            <hr class="my-3 opacity-10">

                            <a href="{{ route('creator.profile') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-semibold">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Publik Profil
                            </a>
                        </div>
                    </div>

                    <!-- FORM RINCIAN PROFIL & SOSIAL MEDIA -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-4">
                            <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                                <i class="bi bi-person-lines-fill text-primary"></i> Data Pribadi & Portofolio Arsitek Sistem
                            </h5>
                            <p class="text-muted small mb-4">Informasi ini ditampilkan di halaman publik <code>/profil-pembuat</code>, pop-up panduan, dan footer landing page.</p>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Nama Lengkap & Gelar</label>
                                    <input type="text" name="landing_creator_name" value="{{ app_setting('landing_creator_name', 'Vicky Koroh') }}" required class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Headline Profesi / Jabatan</label>
                                    <input type="text" name="creator_headline" value="{{ app_setting('creator_headline', 'Software Engineer & Educational Technology Architect') }}" required class="form-control">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Peran di Sistem</label>
                                    <input type="text" name="landing_creator_role" value="{{ app_setting('landing_creator_role', 'Super Administrator & Lead Architect') }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Tahun Hak Cipta</label>
                                    <input type="text" name="landing_copyright_year" value="{{ app_setting('landing_copyright_year', '2026') }}" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Biografi Lengkap & Visi Misi Dedikasi</label>
                                <textarea name="creator_bio" rows="4" class="form-control" placeholder="Tuliskan biografi dan latar belakang pengembangan sistem...">{{ app_setting('creator_bio', 'Vicky Koroh adalah pengembang teknologi pendidikan dan arsitek perangkat lunak yang berdedikasi menciptakan inovasi kecerdasan digital untuk memberdayakan para pendidik kejuruan (SMK) di seluruh nusantara.') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Latar Belakang Pendidikan & Spesialisasi</label>
                                <input type="text" name="creator_education" value="{{ app_setting('creator_education', 'Pakar Rekayasa Perangkat Lunak & Teknologi Pembelajaran Vokasi Modern') }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Keahlian & Pilar Teknologi (Pisahkan dengan koma)</label>
                                <input type="text" name="creator_skills" value="{{ app_setting('creator_skills', 'AI System Engineering, Deep Learning Pedagogy, Cloud Infrastructure, Laravel Architecture, Kurikulum Merdeka SMK, Clean Code & Security') }}" class="form-control">
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-dark">Narasi Dedikasi Singkat (Footer/Hero)</label>
                                <textarea name="landing_creator_desc" rows="2" class="form-control">{{ app_setting('landing_creator_desc', 'Karya inovasi teknologi pendidikan kejuruan yang didesain dan dikembangkan secara khusus untuk mendukung guru SMK di seluruh Indonesia.') }}</textarea>
                            </div>

                            <h6 class="fw-bold text-dark small mb-3 border-top pt-3">
                                <i class="bi bi-share me-1 text-primary"></i> Kontak Resmi & Tautan Jejaring Sosial:
                            </h6>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Nomor WhatsApp Resmi</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light"><i class="bi bi-whatsapp text-success"></i></span>
                                        <input type="text" name="creator_whatsapp" value="{{ app_setting('creator_whatsapp', '081234567890') }}" class="form-control" placeholder="0812...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Alamat Email Resmi</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light"><i class="bi bi-envelope text-primary"></i></span>
                                        <input type="email" name="creator_email" value="{{ app_setting('creator_email', 'vicky@vxai.online') }}" class="form-control" placeholder="email@domain.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Tautan GitHub</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light"><i class="bi bi-github"></i></span>
                                        <input type="url" name="creator_github" value="{{ app_setting('creator_github', 'https://github.com/Vicky1902-py') }}" class="form-control" placeholder="https://github.com/...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Tautan LinkedIn</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light"><i class="bi bi-linkedin text-info"></i></span>
                                        <input type="url" name="creator_linkedin" value="{{ app_setting('creator_linkedin', 'https://linkedin.com/in/vicky-koroh') }}" class="form-control" placeholder="https://linkedin.com/in/...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Tautan Instagram</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light"><i class="bi bi-instagram text-danger"></i></span>
                                        <input type="text" name="creator_instagram" value="{{ app_setting('creator_instagram', 'https://instagram.com/vicky_koroh') }}" class="form-control" placeholder="https://instagram.com/...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Situs Web / Portofolio</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-light"><i class="bi bi-globe text-success"></i></span>
                                        <input type="url" name="creator_website" value="{{ app_setting('creator_website', 'https://guru.vxai.online') }}" class="form-control" placeholder="https://...">
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                    <i class="bi bi-check-circle-fill me-1.5"></i> Simpan Profil Pembuat
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- TAB 7: INTEGRASI & VERIFIKASI GOOGLE ADSENSE -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab === 'adsense' ? 'show active' : '' }}" id="pane-adsense" role="tabpanel">
            <form action="{{ route('cms.settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="active_tab" value="adsense">

                <div class="row g-4">
                    <!-- SISI KIRI: STATUS & PENGATURAN KODE -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-shield-check text-success"></i> Status & Verifikasi AdSense
                                </h6>
                                <span class="badge {{ app_setting('adsense_enabled', '0') == '1' ? 'bg-success text-white' : 'bg-secondary text-white' }} px-3 py-1.5 rounded-pill">
                                    <i class="bi {{ app_setting('adsense_enabled', '0') == '1' ? 'bi-check-circle-fill' : 'bi-pause-circle' }} me-1"></i>
                                    {{ app_setting('adsense_enabled', '0') == '1' ? 'Iklan Aktif' : 'Iklan Nonaktif' }}
                                </span>
                            </div>
                            <div class="card-body p-4">
                                <div class="form-check form-switch p-3 bg-light rounded-3 mb-4 d-flex align-items-center justify-content-between">
                                    <div>
                                        <label class="form-check-label fw-bold text-dark mb-0 cursor-pointer" for="adsense_enabled">
                                            Aktifkan Google AdSense
                                        </label>
                                        <div class="text-muted small">Aktifkan untuk mulai menampilkan script iklan dan kode verifikasi di header publik.</div>
                                    </div>
                                    <input class="form-check-input ms-3" type="checkbox" role="switch" id="adsense_enabled" name="adsense_enabled" value="1" {{ app_setting('adsense_enabled', '0') == '1' ? 'checked' : '' }} style="width: 2.5em; height: 1.3em;">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">Google AdSense Publisher ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted font-monospace"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" name="adsense_publisher_id" class="form-control font-monospace" placeholder="ca-pub-1234567890123456" value="{{ app_setting('adsense_publisher_id', '') }}">
                                    </div>
                                    <div class="form-text small">Contoh: <code>ca-pub-1234567890123456</code>. Sistem otomatis menyematkan meta tag <code>&lt;meta name="google-adsense-account" content="..."&gt;</code> ke dalam tag <code>&lt;head&gt;</code>.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">Kode Script AdSense (&lt;head&gt; Auto Ads)</label>
                                    <textarea name="adsense_code" rows="4" class="form-control font-monospace small" placeholder="<script async src=&quot;https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-...&quot; crossorigin=&quot;anonymous&quot;></script>">{{ app_setting('adsense_code', '') }}</textarea>
                                    <div class="form-text small">Salin script langsung dari panel Google AdSense Anda (Menu <em>Situs &gt; Dapatkan Kode</em>).</div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-dark">Slot Iklan Banner Atas (Opsional)</label>
                                        <textarea name="ads_banner_top" rows="3" class="form-control font-monospace small" placeholder="<!-- Kode Iklan Responsive Banner Atas -->">{{ app_setting('ads_banner_top', '') }}</textarea>
                                        <div class="form-text small">Ditempatkan di atas konten modul/generator jika ingin menampilkan banner khusus.</div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-dark">Slot Iklan Banner Bawah (Opsional)</label>
                                        <textarea name="ads_banner_bottom" rows="3" class="form-control font-monospace small" placeholder="<!-- Kode Iklan Responsive Banner Bawah -->">{{ app_setting('ads_banner_bottom', '') }}</textarea>
                                        <div class="form-text small">Ditempatkan di bawah hasil unduhan generator atau footer.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SISI KANAN: ADS.TXT & PANDUAN CEPAT -->
                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-file-earmark-code text-primary"></i> Pengaturan ads.txt Server
                                </h6>
                                <a href="{{ url('/ads.txt') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka /ads.txt
                                </a>
                            </div>
                            <div class="card-body p-4">
                                <p class="text-muted small mb-3">
                                    Google mewajibkan file <code>ads.txt</code> terpasang di root domain (<code>domain.com/ads.txt</code>) untuk mencegah penipuan inventaris iklan.
                                </p>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">Isi File ads.txt</label>
                                    <textarea name="ads_txt_content" rows="6" class="form-control font-monospace small" placeholder="google.com, pub-XXXXXXXXXXXXXXXX, DIRECT, f08c47fec0942fa0">{{ app_setting('ads_txt_content', "google.com, pub-XXXXXXXXXXXXXXXX, DIRECT, f08c47fec0942fa0\n") }}</textarea>
                                    <div class="form-text small">Format standar: <code>google.com, pub-ID, DIRECT, f08c47fec0942fa0</code>. Menyimpan form ini akan otomatis memperbarui file <code>public/ads.txt</code> dan endpoint web.</div>
                                </div>

                                <div class="p-3 bg-light rounded-3 border">
                                    <h6 class="fw-bold text-dark small mb-2"><i class="bi bi-lightbulb text-warning me-1"></i> 3 Langkah Cepat Verifikasi:</h6>
                                    <ol class="small text-muted ps-3 mb-0" style="line-height: 1.6;">
                                        <li>Isi <strong>Publisher ID</strong> &amp; <strong>Kode Script</strong> di sebelah kiri.</li>
                                        <li>Ganti <code>pub-XXXXXXXXXXXXXXXX</code> pada <strong>ads.txt</strong> dengan nomor ID AdSense Anda.</li>
                                        <li>Buka Google AdSense, klik <strong>"Periksa File ads.txt"</strong> &amp; <strong>"Verifikasi Situs"</strong>.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2.5 fw-semibold shadow-sm w-100">
                                <i class="bi bi-check-circle-fill me-1.5"></i> Simpan Pengaturan AdSense & ads.txt
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- TAB 8: GOOGLE SEARCH CONSOLE & SEO SITEMAP -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab === 'seo' ? 'show active' : '' }}" id="pane-seo" role="tabpanel">
            <form action="{{ route('cms.settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="active_tab" value="seo">

                <div class="row g-4">
                    <!-- SISI KIRI: VERIFIKASI GOOGLE SEARCH CONSOLE -->
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-google text-primary"></i> Verifikasi Kepemilikan Google Search Console
                                </h6>
                                @if(app_setting('gsc_verification_code'))
                                    <span class="badge bg-success text-white px-3 py-1.5 rounded-pill">
                                        <i class="bi bi-patch-check-fill me-1"></i> Terpasang
                                    </span>
                                @else
                                    <span class="badge bg-secondary text-white px-3 py-1.5 rounded-pill">
                                        <i class="bi bi-exclamation-circle me-1"></i> Belum Dikonfigurasi
                                    </span>
                                @endif
                            </div>
                            <div class="card-body p-4">
                                <div class="alert alert-primary border border-primary-subtle bg-primary-subtle text-dark p-3 rounded-3 mb-4">
                                    <div class="fw-bold mb-1 d-flex align-items-center gap-1.5">
                                        <i class="bi bi-info-circle-fill text-primary"></i> Menghubungkan ke Google Search Console
                                    </div>
                                    <div class="small text-secondary" style="line-height: 1.5;">
                                        Google Search Console membantu mengindeks seluruh perangkat ajar, memantau kata kunci pencarian guru, mendeteksi halaman error, dan mengoptimalkan performa SEO di mesin pencari Google.
                                    </div>
                                </div>

                                <!-- METODE 1: META TAG HTML -->
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-dark d-flex align-items-center justify-content-between">
                                        <span>Metode 1: Kode / Meta Tag Verifikasi HTML (Paling Disukai)</span>
                                        <span class="badge bg-light text-primary border">Rekomendasi</span>
                                    </label>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text bg-light text-muted font-monospace"><i class="bi bi-code-slash"></i></span>
                                        <input type="text" name="gsc_verification_code" id="gscVerificationCode" class="form-control font-monospace" 
                                               placeholder="Contoh: abcdef1234567890 atau seluruh tag <meta name=&quot;google-site-verification&quot; content=&quot;...&quot; />" 
                                               value="{{ app_setting('gsc_verification_code', '') }}">
                                    </div>
                                    <div class="form-text small">
                                        Anda bisa menempelkan <strong>kode uniknya saja</strong> atau <strong>seluruh tag HTML</strong> dari Google Search Console. Sistem cerdas otomatis membersihkan dan menyematkannya ke dalam <code>&lt;head&gt;</code> di seluruh halaman publik tanpa merusak AdSense.
                                    </div>
                                </div>

                                <!-- METODE 2: FILE HTML GOOGLE -->
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-dark d-flex align-items-center justify-content-between">
                                        <span>Metode 2: File HTML Verifikasi Google (Opsional)</span>
                                        @if(app_setting('gsc_html_file_code'))
                                            @php
                                                $testFile = app_setting('gsc_html_file_code');
                                                if (!str_ends_with($testFile, '.html')) $testFile .= '.html';
                                                if (!str_starts_with($testFile, 'google')) $testFile = 'google' . $testFile;
                                            @endphp
                                            <a href="{{ url('/' . $testFile) }}" target="_blank" class="small text-primary text-decoration-none fw-semibold">
                                                <i class="bi bi-box-arrow-up-right me-0.5"></i> Uji Buka /{{ $testFile }}
                                            </a>
                                        @endif
                                    </label>
                                    <div class="input-group mb-1">
                                        <span class="input-group-text bg-light text-muted font-monospace"><i class="bi bi-file-earmark-code"></i></span>
                                        <input type="text" name="gsc_html_file_code" class="form-control font-monospace" 
                                               placeholder="Contoh: google4a7b9c1d2e.html atau 4a7b9c1d2e" 
                                               value="{{ app_setting('gsc_html_file_code', '') }}">
                                    </div>
                                    <div class="form-text small">
                                        Jika memilih metode unggah file HTML di Search Console, masukkan nama file di sini. Sistem akan otomatis menyajikan file verifikasi tersebut saat Google merayapinya.
                                    </div>
                                </div>

                                <!-- METODE 3: DNS / TXT RECORD GOOGLE SEARCH -->
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">Catatan Verifikasi TXT Google Search (Opsional)</label>
                                    <textarea name="gsc_txt_record" rows="2" class="form-control font-monospace small" 
                                              placeholder="google-site-verification=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX">{{ app_setting('gsc_txt_record', '') }}</textarea>
                                    <div class="form-text small">
                                        Simpan catatan kode TXT DNS Google Anda di sini sebagai arsip dan dokumentasi server.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SISI KANAN: SITEMAP XML & ROBOTS.TXT -->
                    <div class="col-lg-5">
                        <!-- KARTU SITEMAP XML -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-diagram-3-fill text-success"></i> Peta Situs Publik (Sitemap XML)
                                </h6>
                                <a href="{{ url('/sitemap.xml') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-semibold">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka /sitemap.xml
                                </a>
                            </div>
                            <div class="card-body p-4">
                                <p class="text-muted small mb-2.5">
                                    Google Search Console memerlukan URL peta situs (sitemap) untuk menemukan dan mengindeks seluruh halaman publik secara instan.
                                </p>

                                <div class="p-2.5 bg-light rounded-3 border mb-3">
                                    <div class="small text-muted mb-1" style="font-size: 0.72rem;">URL Resmi Sitemap Website Anda:</div>
                                    <div class="d-flex align-items-center justify-content-between gap-2">
                                        <code class="small text-dark text-break fw-bold" id="sitemapUrlText">{{ url('/sitemap.xml') }}</code>
                                        <button type="button" class="btn btn-light btn-sm rounded-pill border px-2.5 py-1 text-nowrap" onclick="copySitemapUrl()" id="btnCopySitemap">
                                            <i class="bi bi-clipboard me-1"></i> Salin URL
                                        </button>
                                    </div>
                                </div>

                                <div class="p-3 bg-light rounded-3 border">
                                    <div class="fw-bold text-dark small mb-1.5"><i class="bi bi-check2-circle text-success me-1"></i> Halaman yang Termasuk di Sitemap:</div>
                                    <ul class="small text-muted ps-3 mb-0" style="line-height: 1.6; font-size: 0.78rem;">
                                        <li>Beranda Utama / Landing Page (<code>/</code>)</li>
                                        <li>Generator Perangkat Ajar 1-Klik (<code>/generator</code>)</li>
                                        <li>Profil Pembuat / Dedikasi Vicky Koroh (<code>/profil-pembuat</code>)</li>
                                        <li>Portal Akses Masuk &amp; Daftar Guru (<code>/login</code>, <code>/register</code>)</li>
                                        <li>5 Halaman Standar Kepatuhan Hukum (Kebijakan Privasi, Syarat, Tentang, Kontak, Disclaimer)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- KARTU ROBOTS.TXT -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-robot text-primary"></i> File robots.txt Server
                                </h6>
                                <a href="{{ url('/robots.txt') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka /robots.txt
                                </a>
                            </div>
                            <div class="card-body p-4">
                                @php
                                    $defaultRobotsPreview = "User-agent: *\nAllow: /\nDisallow: /dashboard\nDisallow: /cms/\nDisallow: /profile/\nDisallow: /users/\nDisallow: /backup/\nDisallow: /export/\n\nSitemap: " . url('/sitemap.xml') . "\n";
                                @endphp
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-dark">Isi File robots.txt</label>
                                    <textarea name="robots_txt_content" rows="6" class="form-control font-monospace small">{{ app_setting('robots_txt_content', $defaultRobotsPreview) }}</textarea>
                                    <div class="form-text small">
                                        Mengatur halaman mana yang boleh dirayapi Googlebot dan mengarahkan crawler ke <code>{{ url('/sitemap.xml') }}</code>. Menyimpan form akan otomatis memperbarui file <code>public/robots.txt</code>.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TOMBOL SUBMIT -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 py-2.5 fw-semibold shadow-sm w-100">
                                <i class="bi bi-check-circle-fill me-1.5"></i> Simpan Pengaturan Search Console &amp; SEO
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- TAB 9: SISTEM & MAINTENANCE -->
        <!-- ========================================== -->
        <div class="tab-pane fade {{ $activeTab === 'system' ? 'show active' : '' }}" id="pane-system" role="tabpanel">
            <form action="{{ route('cms.settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="active_tab" value="system">
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-2">
                        <i class="bi bi-gear-fill text-danger fs-5"></i>
                        <h5 class="mb-0 fw-bold">Konfigurasi Sistem Utama</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-danger bg-opacity-10 border-danger border-opacity-25 d-flex align-items-start gap-3 mb-4">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
                            <div>
                                <h6 class="fw-bold text-danger mb-1">Peringatan Mode Pemeliharaan!</h6>
                                <p class="mb-0 small text-dark">
                                    Mengaktifkan Mode Pemeliharaan akan memblokir akses ke seluruh aplikasi (termasuk Landing Page) bagi pengunjung dan guru. Hanya Anda (Superadmin) yang dapat mengakses aplikasi. Gunakan fitur ini saat sedang melakukan sinkronisasi database, perbaikan sistem, atau integrasi AI Master.
                                </p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch fs-5 mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="maintenance_mode" name="maintenance_mode" value="1" {{ app_setting('maintenance_mode', '0') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-dark" for="maintenance_mode">Aktifkan Maintenance Mode</label>
                            </div>
                            <div class="form-text small">Tampilan "Sistem Dalam Pengembangan" akan langsung muncul bagi user selain superadmin.</div>
                        </div>

                        <div class="text-end border-top pt-4">
                            <button type="submit" class="btn btn-danger rounded-pill px-4 py-2.5 fw-semibold shadow-sm w-100">
                                <i class="bi bi-check-circle-fill me-1.5"></i> Simpan Konfigurasi Sistem
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function applyPresetColors(primary, cyan, indigo) {
        document.getElementById('primaryColorPicker').value = primary;
        document.getElementById('primaryColorText').value = primary;
        document.getElementById('cyanColorPicker').value = cyan;
        document.getElementById('cyanColorText').value = cyan;
        document.getElementById('indigoColorPicker').value = indigo;
        document.getElementById('indigoColorText').value = indigo;
    }

    function copySitemapUrl() {
        const urlText = document.getElementById('sitemapUrlText').innerText;
        navigator.clipboard.writeText(urlText).then(() => {
            const btn = document.getElementById('btnCopySitemap');
            const oldHtml = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg text-success me-1"></i> Tersalin!';
            btn.classList.add('btn-success', 'text-white');
            btn.classList.remove('btn-light');
            setTimeout(() => {
                btn.innerHTML = oldHtml;
                btn.classList.remove('btn-success', 'text-white');
                btn.classList.add('btn-light');
            }, 2000);
        }).catch(err => {
            alert('URL Sitemap: ' + urlText);
        });
    }
</script>
@endpush
@endsection
