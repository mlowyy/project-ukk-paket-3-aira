<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - Pengaduan Sarana Sekolah</title>
    
    <!-- Google Fonts: Source Sans 3 -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- AdminLTE v4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">
</head>
<body class="login-page bg-body-secondary d-flex align-items-center justify-content-center min-vh-100 p-3">
    <div class="login-box" style="width: 420px; max-width: 100%;">
        <div class="login-logo text-center mb-3">
            <a href="{{ route('siswa.form') }}" class="text-decoration-none fw-bold fs-2 text-dark d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-tools text-primary"></i>
                <span><b>SARPRAS</b> <span class="badge text-bg-primary fs-6">LTE</span></span>
            </a>
            <div class="small text-muted">Aplikasi Pengaduan Sarana Sekolah</div>
        </div>

        <div class="card card-outline card-primary shadow">
            <div class="card-body login-card-body p-4">
                <p class="login-box-msg text-center text-muted mb-4">Silakan masuk dengan akun Administrator</p>

                <!-- Flash Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 small py-2 mb-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 small py-2 mb-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    
                    <!-- Username -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Username</label>
                        <div class="input-group">
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username admin" value="{{ old('username') }}" required autofocus>
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small" for="remember">Ingat Saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
                    </button>
                </form>

                <div class="alert alert-info border-0 mt-4 mb-2 p-2 small text-center">
                    <i class="bi bi-info-circle me-1"></i> Akun Pengujian UKK:<br>
                    Username: <strong>admin</strong> | Password: <strong>admin123</strong>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('siswa.form') }}" class="text-decoration-none small text-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Form Pengaduan Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js"></script>
</body>
</html>
