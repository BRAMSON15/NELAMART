<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/login-pelanggan.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body>

    <div class="login-wrapper">

        <!-- LEFT: Form Panel -->
        <div class="login-form-panel">
            <h2>Daftar Pelanggan</h2>

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

            <form method="POST" action="{{ route('pelanggan.register.submit') }}">
                @csrf

                <div class="form-group">
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Nama Lengkap"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="Username"
                        required
                    >
                </div>

                <div class="form-group">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email"
                        required
                    >
                </div>

                <div class="form-group">
                    <input
                        type="password"
                        name="password"
                        placeholder="Password (min. 8 karakter)"
                        required
                    >
                </div>

                <div class="form-group">
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Konfirmasi Password"
                        required
                    >
                </div>

                <button type="submit" class="btn-signin">Daftar Sekarang</button>
            </form>

            <div class="or-divider">sudah punya akun?</div>

            <div class="other-logins">
                <a href="{{ route('pelanggan.login') }}" class="other-login-btn">Login Pelanggan</a>
            </div>
        </div>

        <!-- RIGHT: Info Panel -->
        <div class="login-info-panel">
            <div class="brand-icon">🛍️</div>
            <h3>Bergabung Sekarang!</h3>
            <p>Daftar gratis dan nikmati kemudahan berbelanja produk UMKM berkualitas dari seluruh Indonesia.</p>
            <a href="{{ route('pelanggan.login') }}" class="btn-register">Sudah punya akun? Login</a>
            <div class="back-link">
                <a href="/">← Kembali ke Beranda</a>
            </div>
        </div>

    </div>

</body>
</html>

