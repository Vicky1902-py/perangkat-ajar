<nav id="sidebar">
    <!-- Brand Box -->
    <div class="brand-box d-flex align-items-center justify-content-between">
        <a href="{{ auth()->check() ? route('dashboard') : route('generator.index') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <div class="rounded-3 bg-primary bg-gradient text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                <i class="bi bi-journal-bookmark-fill fs-5"></i>
            </div>
            <div>
                <div class="fw-bold text-white lh-1 fs-6">PerangkatAjar</div>
                <div class="text-xs text-info fw-semibold" style="font-size: 0.68rem;">BSKAP 046/H/KR/2025</div>
            </div>
        </a>
        <button type="button" class="btn btn-sm text-secondary p-1 d-lg-none" id="sidebarCloseBtn" aria-label="Tutup Menu">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>

    @auth
        <!-- User Profile Snippet in Sidebar -->
        <div class="px-3 py-3 mx-3 my-2 rounded-3 bg-dark bg-opacity-50 border border-secondary border-opacity-25 d-flex align-items-center gap-2">
            <div class="rounded-circle bg-secondary bg-opacity-50 text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="overflow-hidden">
                <div class="text-white text-truncate fw-semibold small" title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</div>
                <div>
                    @if(auth()->user()->isSuperAdmin())
                        <span class="badge badge-role-superadmin" style="font-size: 0.65rem;">SUPERADMIN</span>
                    @elseif(auth()->user()->isAdminSekolah())
                        <span class="badge badge-role-admin_sekolah" style="font-size: 0.65rem;">ADMIN SEKOLAH</span>
                    @else
                        <span class="badge badge-role-guru" style="font-size: 0.65rem;">GURU SMK</span>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- Guest Banner in Sidebar -->
        <div class="px-3 py-3 mx-3 my-2 rounded-3 bg-dark bg-opacity-50 border border-warning border-opacity-50">
            <div class="d-flex align-items-center gap-2 text-warning mb-1">
                <i class="bi bi-gift-fill"></i>
                <span class="fw-bold small">Akses Tamu (Publik)</span>
            </div>
            <div class="text-white text-opacity-75 small mb-2" style="font-size: 0.72rem;">
                Coba gratis pembuatan perangkat ajar maksimal 2 kali.
            </div>
            <div class="d-grid gap-1">
                <a href="{{ route('register') }}" class="btn btn-warning btn-sm fw-bold text-dark py-1" style="font-size: 0.75rem;">
                    <i class="bi bi-person-plus-fill me-1"></i> Daftar Akun Guru
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm py-1" style="font-size: 0.75rem;">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk (Login)
                </a>
            </div>
        </div>
    @endauth

    <div class="py-2">
        <!-- MENU UTAMA -->
        <div class="nav-header">Menu Utama</div>
        <ul class="nav flex-column mb-2">
            @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.setup') ? 'active' : '' }} text-info" href="{{ route('profile.setup') }}">
                        <i class="bi bi-person-badge-fill text-info"></i> Profil & Kop Sekolah
                    </a>
                </li>
            @endauth
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('generator.*') ? 'active' : '' }} text-warning fw-bold" href="{{ route('generator.index') }}">
                    <i class="bi bi-lightning-charge-fill text-warning"></i> Generator 1-Klik
                </a>
            </li>
        </ul>

        @auth
            <!-- PERANGKAT AJAR -->
            <div class="nav-header">Perangkat Ajar</div>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tp.*') ? 'active' : '' }}" href="{{ route('tp.index') }}">
                        <i class="bi bi-bullseye"></i> Tujuan Pembelajaran (TP)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('atp.*') ? 'active' : '' }}" href="{{ route('atp.index') }}">
                        <i class="bi bi-diagram-3"></i> Alur TP (ATP)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('modul-ajar.*') ? 'active' : '' }}" href="{{ route('modul-ajar.index') }}">
                        <i class="bi bi-journal-richtext"></i> Modul Ajar (PEDATTI)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lkpd.*') ? 'active' : '' }}" href="{{ route('lkpd.index') }}">
                        <i class="bi bi-file-earmark-text"></i> Lembar Kerja (LKPD)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('prota-promes.*') ? 'active' : '' }}" href="{{ route('prota-promes.index') }}">
                        <i class="bi bi-calendar-range"></i> Prota & Promes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('asesmen.*') ? 'active' : '' }}" href="{{ route('asesmen.index') }}">
                        <i class="bi bi-check2-square"></i> Instrumen Asesmen
                    </a>
                </li>
            </ul>

            <!-- CMS DATA MASTER (SUPERADMIN & ADMIN SEKOLAH) -->
            @if(auth()->user()->isSuperAdmin() || auth()->user()->isAdminSekolah())
                <div class="nav-header">CMS Data Master</div>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cms.cp.*') ? 'active' : '' }}" href="{{ route('cms.cp.index') }}">
                            <i class="bi bi-award"></i> Capaian Pembelajaran (CP)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cms.mapel.*') ? 'active' : '' }}" href="{{ route('cms.mapel.index') }}">
                            <i class="bi bi-book"></i> Mata Pelajaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cms.kejuruan.*') ? 'active' : '' }}" href="{{ route('cms.kejuruan.index') }}">
                            <i class="bi bi-gear-wide-connected"></i> Bidang & Program SMK
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cms.profil-lulusan.*') ? 'active' : '' }}" href="{{ route('cms.profil-lulusan.index') }}">
                            <i class="bi bi-stars"></i> Profil Lulusan (8 Dimensi)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cms.template-pedatti.*') ? 'active' : '' }}" href="{{ route('cms.template-pedatti.index') }}">
                            <i class="bi bi-layout-text-window-reverse"></i> Template PEDATTI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cms.tahun-ajaran.*') ? 'active' : '' }}" href="{{ route('cms.tahun-ajaran.index') }}">
                            <i class="bi bi-calendar3"></i> Tahun Ajaran
                        </a>
                    </li>
                    @if(auth()->user()->isSuperAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cms.sekolah.*') ? 'active' : '' }}" href="{{ route('cms.sekolah.index') }}">
                            <i class="bi bi-building"></i> Data Satuan Pendidikan
                        </a>
                    </li>
                    @endif
                </ul>
            @endif

            <!-- MANAJEMEN PENGGUNA & PANTAU TRAFFIC (SUPERADMIN ONLY) -->
            @if(auth()->user()->isSuperAdmin())
                <div class="nav-header">Kontrol Sistem</div>
                <ul class="nav flex-column mb-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cms.traffic.*') ? 'active' : '' }} d-flex align-items-center justify-content-between" href="{{ route('cms.traffic.index') }}">
                            <div>
                                <i class="bi bi-activity text-danger"></i> Pantau Traffic Realtime
                            </div>
                            <span class="badge bg-danger rounded-pill px-2 py-0.5" style="font-size: 0.65rem; letter-spacing: 0.5px;">LIVE</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="bi bi-people-fill"></i> Manajemen Pengguna
                        </a>
                    </li>
                </ul>
            @endif
        @endauth
    </div>
</nav>
