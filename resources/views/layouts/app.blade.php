<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Pengaduan Sarana Sekolah') - UKK RPL 2025/2026</title>
    
    <!-- Google Fonts: Source Sans 3 -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- AdminLTE v4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">

    <style>
        body {
            font-family: 'Source Sans 3', sans-serif;
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1 0 auto;
        }
        .badge-status {
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .badge-menunggu { background-color: #ffc107; color: #212529; }
        .badge-proses { background-color: #0dcaf0; color: #212529; }
        .badge-selesai { background-color: #198754; color: #ffffff; }

        .timeline-step {
            display: flex;
            align-items: center;
            position: relative;
        }
        .step-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            z-index: 2;
        }
        .step-completed { background-color: #198754; color: #fff; }
        .step-inactive { background-color: #e9ecef; color: #6c757d; }
    </style>
    @stack('styles')
</head>
<body class="bg-body-tertiary">
    <!-- Navbar AdminLTE Top Nav -->
    <nav class="navbar navbar-expand-lg bg-body border-bottom sticky-top py-2 shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark text-decoration-none" href="{{ route('siswa.form') }}">
                <div class="rounded bg-primary text-white p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-tools fs-5"></i>
                </div>
                <span>SARPRAS <span class="badge text-bg-primary fs-6">LTE</span></span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('siswa.form') ? 'active fw-bold text-primary' : '' }}" href="{{ route('siswa.form') }}">
                            <i class="bi bi-pencil-square me-1"></i> Form Aspirasi Siswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('siswa.histori*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('siswa.histori') }}">
                            <i class="bi bi-clock-history me-1"></i> Histori & Status
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                    <li class="nav-item me-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm px-3 fw-semibold">
                            <i class="bi bi-speedometer2 me-1"></i> Panel Admin
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm px-3 fw-semibold">
                            <i class="bi bi-shield-lock me-1"></i> Login Admin
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content py-4">
        <div class="container">
            <!-- Flash Notifications -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-x-circle-fill fs-5"></i>
                    <strong>Terdapat beberapa kesalahan:</strong>
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
    </main>

    <!-- Footer -->
    <footer class="app-footer border-top bg-white py-3 mt-auto">
        <div class="container d-flex justify-content-between align-items-center small text-muted">
            <div>
                <strong>Aplikasi Pengaduan Sarana Sekolah</strong> &copy; AdminLTE v4.
            </div>
            <div>
                UKK Rekayasa Perangkat Lunak 2025/2026 &bull; Paket 3
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE v4 JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js"></script>
    @stack('scripts')
</body>
</html>
