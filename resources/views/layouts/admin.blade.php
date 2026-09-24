<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Pengaduan Sarana Sekolah</title>
    
    <!-- Google Fonts: Source Sans 3 -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Overlayscrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css">
    <!-- AdminLTE v4 CSS (Latest Bootstrap 5) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">

    <style>
        .badge-status {
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .badge-menunggu { background-color: #ffc107; color: #212529; }
        .badge-proses { background-color: #0dcaf0; color: #212529; }
        .badge-selesai { background-color: #198754; color: #ffffff; }
    </style>
    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header / Navbar -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <!-- Start Navbar Links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list fs-4"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link fw-semibold">Dashboard</a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a href="{{ route('siswa.form') }}" target="_blank" class="nav-link text-primary">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Buka Portal Siswa
                        </a>
                    </li>
                </ul>

                <!-- End Navbar Links -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <!-- User Dropdown Menu -->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <span class="d-none d-md-inline fw-semibold">{{ Auth::user()->username ?? 'Administrator' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow">
                            <li class="user-header bg-primary text-white text-center p-3">
                                <i class="bi bi-person-badge-fill display-4 mb-2"></i>
                                <p class="mb-0 fw-bold">{{ Auth::user()->username ?? 'Administrator' }}</p>
                                <small>Petugas Sarana & Prasarana</small>
                            </li>
                            <li class="user-footer d-flex justify-content-between p-2">
                                <a href="{{ route('siswa.form') }}" class="btn btn-default btn-flat btn-sm">Lihat Web</a>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-flat btn-sm">
                                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Sidebar -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!-- Sidebar Brand -->
            <div class="sidebar-brand">
                <a href="{{ route('admin.dashboard') }}" class="brand-link d-flex align-items-center gap-2 px-3 py-2 text-decoration-none">
                    <i class="bi bi-tools text-warning fs-4"></i>
                    <span class="brand-text fw-bold">SARPRAS <span class="badge text-bg-warning text-dark">v4</span></span>
                </a>
            </div>

            <!-- Sidebar Content -->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-header text-uppercase text-secondary small px-3 mt-2">Menu Utama</li>
                        
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-chat-left-text-fill"></i>
                                <p>Umpan Balik Aspirasi</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-tags-fill"></i>
                                <p>Kategori Sarana</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.cetak') }}" target="_blank" class="nav-link">
                                <i class="nav-icon bi bi-printer-fill"></i>
                                <p>Cetak Laporan Rekap</p>
                            </a>
                        </li>

                        <li class="nav-header text-uppercase text-secondary small px-3 mt-3">Lainnya</li>

                        <li class="nav-item">
                            <a href="{{ route('siswa.form') }}" target="_blank" class="nav-link">
                                <i class="nav-icon bi bi-laptop"></i>
                                <p>Halaman Form Siswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('siswa.histori') }}" target="_blank" class="nav-link">
                                <i class="nav-icon bi bi-clock-history"></i>
                                <p>Histori Siswa</p>
                            </a>
                        </li>

                        <li class="nav-item mt-3">
                            <form action="{{ route('logout') }}" method="POST" class="px-3">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 btn-sm text-start">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="app-main">
            <!-- Breadcrumbs & Content Header -->
            <div class="app-content-header py-3">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="mb-0 fw-bold">@yield('page_title', 'Dashboard')</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb', 'Dashboard')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Body -->
            <div class="app-content">
                <div class="container-fluid">
                    <!-- Flash Notifications -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-3" role="alert">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-x-circle-fill fs-5"></i>
                            <strong>Terdapat kesalahan:</strong>
                        </div>
                        <ul class="mb-0 ps-4">
                            @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">UKK RPL 2025/2026 - Paket 3</div>
            <strong>Aplikasi Pengaduan Sarana Sekolah</strong> &copy; AdminLTE v4.
        </footer>
    </div>

    <!-- Overlayscrollbars JS -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>
    <!-- Popper.js & Bootstrap 5 Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE v4 JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js"></script>

    @stack('scripts')
</body>
</html>
