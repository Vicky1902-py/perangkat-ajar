<header class="top-navbar d-flex align-items-center justify-content-between">
    <!-- Left: Mobile Toggle & Context Info -->
    <div class="d-flex align-items-center gap-2 gap-md-3 min-w-0">
        <button class="btn btn-sm btn-light border shadow-sm d-lg-none" type="button" id="sidebarToggle" aria-label="Buka Menu">
            <i class="bi bi-list fs-5"></i>
        </button>

        <div class="d-md-none text-truncate fw-bold text-dark small" style="max-width: 150px;">
            {{ auth()->check() ? (auth()->user()->satuanPendidikan->nama ?? 'Perangkat Ajar') : 'Perangkat Ajar' }}
        </div>

        <div class="d-none d-md-block">
            <div class="fw-semibold text-dark fs-6 d-flex align-items-center gap-2">
                <i class="bi bi-building text-primary"></i>
                <span>{{ auth()->check() ? (auth()->user()->satuanPendidikan->nama ?? 'Sistem Perangkat Ajar SMK') : 'Sistem Perangkat Ajar SMK (Akses Tamu)' }}</span>
            </div>
            <div class="text-muted small" style="font-size: 0.75rem;">
                <span class="text-success"><i class="bi bi-dot"></i></span>
                @php
                    $navActiveTa = \App\Models\TahunAjaran::where('is_active', true)->first();
                @endphp
                Tahun Ajaran: <strong>{{ $navActiveTa ? $navActiveTa->nama . ' ' . ($navActiveTa->semester == 1 ? 'Ganjil' : 'Genap') : '2026/2027 Ganjil' }}</strong> &bull; BSKAP 046/H/KR/2025 (Deep Learning)
            </div>
        </div>
    </div>

    <!-- Right: User Dropdown or Guest Buttons -->
    <div class="d-flex align-items-center gap-2 gap-md-3">
        <!-- Quick Action button -->
        <a href="{{ route('generator.index') }}" class="btn btn-sm btn-gradient-primary rounded-pill px-3 d-none d-sm-inline-flex align-items-center gap-1 shadow-sm">
            <i class="bi bi-lightning-charge-fill text-warning"></i>
            <span>Generate 1-Klik</span>
        </a>

        @auth
            <!-- User Dropdown Menu -->
            <div class="dropdown">
                <button class="btn btn-light rounded-pill border d-flex align-items-center gap-2 px-3 py-1 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="rounded-circle bg-primary bg-gradient text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.8rem;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="fw-medium small d-none d-md-inline">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2 mt-2" style="min-width: 220px;">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-bold text-dark small">{{ auth()->user()->name }}</div>
                        <div class="text-muted text-xs" style="font-size: 0.72rem;">{{ auth()->user()->email }}</div>
                        <div class="mt-1">
                            @if(auth()->user()->isSuperAdmin())
                                <span class="badge badge-role-superadmin">Super Administrator</span>
                            @elseif(auth()->user()->isAdminSekolah())
                                <span class="badge badge-role-admin_sekolah">Admin Sekolah</span>
                            @else
                                <span class="badge badge-role-guru">Guru Pengampu</span>
                            @endif
                        </div>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 small d-flex align-items-center gap-2" href="{{ route('profile.setup') }}">
                            <i class="bi bi-person-badge-fill text-primary"></i> Profil & Kop Sekolah
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 small d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 text-secondary"></i> Dashboard
                        </a>
                    </li>
                    @if(auth()->user()->isSuperAdmin())
                    <li>
                        <a class="dropdown-item py-2 small d-flex align-items-center gap-2" href="{{ route('users.index') }}">
                            <i class="bi bi-people text-secondary"></i> Kelola Pengguna
                        </a>
                    </li>
                    @endif
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 small text-danger d-flex align-items-center gap-2">
                                <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <!-- Guest Action Buttons -->
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
            </a>
            <a href="{{ route('register') }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Daftar Akun
            </a>
        @endauth
    </div>
</header>
