<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SMARTMINI AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-dark d-flex align-items-center min-vh-100">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-robot fs-1 text-primary"></i>
                        <h4 class="fw-bold mt-2">SMARTMINI AI</h4>
                        <p class="text-muted small mb-0">Sistem Kasir Minimarket dengan AI Prediksi Restok</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                    </form>

                    <div class="text-center my-3 text-muted small">atau</div>

                    <a href="{{ route('auth.google') }}" class="btn btn-outline-danger w-100">
                        <i class="bi bi-google"></i> Masuk dengan Google
                    </a>

                    <p class="text-center small mt-4 mb-0">
                        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                    </p>

                    <hr>
                    <p class="text-center text-muted" style="font-size: 12px;">
                        Akun demo — Admin: admin@smartmini.test / password<br>
                        Kasir: kasir1@smartmini.test / password
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
