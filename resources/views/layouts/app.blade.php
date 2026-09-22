<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Perangkat Ajar Kurikulum Merdeka (Deep Learning)</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --bs-font-sans-serif: 'Plus Jakarta Sans', sans-serif;
            --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #2563eb;
            --accent-color: #38bdf8;
        }

        body {
            font-family: var(--bs-font-sans-serif);
            background-color: #f8fafc;
            color: #334155;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        #sidebar {
            width: 270px;
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            transition: all 0.3s;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1040;
            overflow-y: auto;
        }

        #sidebar::-webkit-scrollbar {
            width: 5px;
        }
        #sidebar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        #sidebar .brand-box {
            padding: 20px;
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        #sidebar .nav-header {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            padding: 16px 20px 6px;
            font-weight: 700;
        }

        #sidebar .nav-link {
            color: #94a3b8;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            font-size: 0.88rem;
            font-weight: 500;
            border-radius: 8px;
            margin: 2px 12px;
            transition: all 0.2s;
        }

        #sidebar .nav-link i {
            font-size: 1.15rem;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        #sidebar .nav-link:hover {
            color: #ffffff;
            background-color: var(--sidebar-hover);
        }

        #sidebar .nav-link.active {
            color: #ffffff;
            background: var(--sidebar-active);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        /* Content Area */
        #main-wrapper {
            margin-left: 270px;
            transition: all 0.3s;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 28px;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        /* Card Styles */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            transition: all 0.2s;
        }

        .card:hover {
            box-shadow: 0 6px 16px rgba(0,0,0,0.05);
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
            padding: 14px 20px;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
        }

        /* Hero Banner Dashboard */
        .hero-banner-card {
            background-color: #0f172a !important;
            background-image: linear-gradient(135deg, #0f172a 0%, #1e3c72 50%, #2563eb 100%) !important;
            color: #ffffff !important;
            border-radius: 16px !important;
        }

        .badge-role-superadmin { background-color: #dc2626; color: white; }
        .badge-role-admin_sekolah { background-color: #2563eb; color: white; }
        .badge-role-guru { background-color: #059669; color: white; }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            border: none;
        }
        .btn-gradient-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            color: white;
        }

        .btn-gradient-success {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            border: none;
        }
        .btn-gradient-success:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: white;
        }

        /* Sidebar Backdrop for Mobile/Tablet */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            z-index: 1040;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }

        /* Mobile & Tablet Responsiveness */
        @media (max-width: 991.98px) {
            #sidebar {
                transform: translateX(-100%);
                box-shadow: none;
            }
            #sidebar.active {
                transform: translateX(0);
                box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
            }
            #main-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                min-width: 0 !important;
            }
            .top-navbar {
                padding: 10px 16px;
            }
            main.container-fluid {
                padding-left: 12px !important;
                padding-right: 12px !important;
                padding-top: 16px !important;
            }
            body.overflow-hidden-mobile {
                overflow: hidden !important;
            }
        }

        @media (min-width: 992px) {
            #sidebar {
                transform: translateX(0) !important;
            }
            .sidebar-backdrop {
                display: none !important;
            }
        }

        /* Table Responsive Horizontal Smooth Scroll */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
        }
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- BACKDROP FOR MOBILE SIDEBAR -->
    <div id="sidebarBackdrop" class="sidebar-backdrop"></div>

    <!-- SIDEBAR -->
    @include('layouts.sidebar')

    <!-- MAIN WRAPPER -->
    <div id="main-wrapper">
        <!-- TOP NAVBAR -->
        @include('layouts.navbar')

        <!-- MAIN CONTENT CONTAINER -->
        <main class="container-fluid px-4 py-4 flex-grow-1">
            <!-- FLASH MESSAGES -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
                    <div>{{ session('warning') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-x-circle me-1"></i> Terjadi beberapa kesalahan:</div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="bg-white border-top py-3 px-4 text-muted small mt-auto">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <strong>Perangkat Ajar SMK</strong> &copy; {{ date('Y') }} — Kurikulum Merdeka (Pendekatan Pembelajaran Mendalam / Deep Learning).
                    <span class="ms-2 text-primary fw-semibold d-inline-flex align-items-center">
                        <i class="bi bi-c-circle me-1"></i> Hak Cipta : Desain by. Vicky Koroh
                    </span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-secondary border">Permendikdasmen No. 13/2025</span>
                    <span class="badge bg-light text-secondary border">BSKAP 046/H/KR/2025</span>
                </div>
            </div>
        </footer>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        function openSidebar() {
            $('#sidebar').addClass('active');
            $('#sidebarBackdrop').addClass('show');
            $('body').addClass('overflow-hidden-mobile');
        }

        function closeSidebar() {
            $('#sidebar').removeClass('active');
            $('#sidebarBackdrop').removeClass('show');
            $('body').removeClass('overflow-hidden-mobile');
        }

        // Toggle Sidebar on mobile
        $('#sidebarToggle').on('click', function(e) {
            e.stopPropagation();
            if ($('#sidebar').hasClass('active')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        // Close sidebar button inside sidebar header
        $(document).on('click', '#sidebarCloseBtn', function() {
            closeSidebar();
        });

        // Close sidebar when clicking backdrop
        $('#sidebarBackdrop').on('click', function() {
            closeSidebar();
        });

        // Close sidebar when clicking any menu link on mobile screens
        $(document).on('click', '#sidebar .nav-link', function() {
            if ($(window).width() < 992) {
                closeSidebar();
            }
        });

        // Setup CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Initialize tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        // SweetAlert helper for delete confirmation
        function confirmDelete(formId, itemName = 'data ini') {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus ${itemName}? Tindakan ini tidak dapat dibatalkan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
