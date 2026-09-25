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
            @php
                $navUnreadCount = \App\Models\UserNotification::where('user_id', auth()->id())->where('is_read', false)->count();
                $navNotifications = \App\Models\UserNotification::where('user_id', auth()->id())->where('is_read', false)->take(5)->get();
            @endphp
            <!-- Notification Bell Dropdown -->
            <div class="dropdown">
                <button class="btn btn-light rounded-circle border position-relative p-2 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 36px; height: 36px;" title="Pemberitahuan Sistem">
                    <i class="bi bi-bell-fill {{ $navUnreadCount > 0 ? 'text-warning' : 'text-secondary' }}"></i>
                    @if($navUnreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.65rem;">
                            {{ $navUnreadCount }}
                        </span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow border-0 py-0 mt-2" style="width: 320px; max-width: 90vw;">
                    <div class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between">
                        <div class="fw-bold small text-dark"><i class="bi bi-bell-fill text-warning me-1"></i> Notifikasi Sistem</div>
                        @if($navUnreadCount > 0)
                            <form action="{{ route('notifications.read-all') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 text-decoration-none small text-primary" style="font-size: 0.75rem;">
                                    Tandai semua dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="p-2" style="max-height: 280px; overflow-y: auto;">
                        @forelse($navNotifications as $n)
                            <div class="p-2 mb-1.5 rounded bg-warning bg-opacity-10 border border-warning border-opacity-25">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold small text-dark">{{ $n->title }}</span>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $n->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 text-secondary small" style="font-size: 0.8rem; line-height: 1.35;">{{ $n->message }}</p>
                                <div class="text-end">
                                    <form action="{{ route('notifications.read', $n->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none text-success small fw-bold" style="font-size: 0.72rem;">
                                            <i class="bi bi-check-lg"></i> Tandai Dibaca
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-3 text-muted small">
                                <i class="bi bi-check2-circle fs-4 d-block mb-1 text-success"></i>
                                Tidak ada notifikasi baru
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

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
