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
</script>
@endpush
@endsection
