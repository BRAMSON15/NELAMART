<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/login-pelanggan.css') }}?v={{ time() }}" rel="stylesheet">
</head>

<body>

    <div class="login-wrapper">

        <!-- LEFT: Form Panel -->
        <div class="login-form-panel">
            <h2>Login Pelanggan</h2>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="error-message" style="border-left-color:#26b99a;background:#f0fdf4;color:#166534;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('pelanggan.login.submit') }}">
                @csrf

                <div class="form-group">
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Username" required
                        autofocus>
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div style="text-align: right; margin-bottom: 20px;">
                    <a href="{{ route('pelanggan.password.request') }}"
                        style="color: #4a90e2; text-decoration: none; font-size: 0.9rem;">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-signin">Masuk</button>
            </form>

            <div class="or-divider">atau login sebagai</div>

            <div class="other-logins">
                <!-- <a href="/admin/login" class="other-login-btn">Admin</a> -->
                <a href="/user/login" class="other-login-btn">Penjual</a>
            </div>
        </div>

        <!-- RIGHT: Info Panel -->
        <div class="login-info-panel">
            <div class="brand-icon"><i class="bi bi-bag"></i></div>
            <h3>Selamat Datang Kembali!</h3>
            <p>Temukan ribuan produk UMKM berkualitas dari seluruh Indonesia. Dukung pengrajin lokal, belanja lebih
                bermakna.</p>
            <a href="{{ route('pelanggan.register') }}" class="btn-register">Belum punya akun? Daftar</a>
            <div class="back-link">
                <a href="/">← Kembali ke Beranda</a>
            </div>
        </div>

    </div>

</body>

</html>
