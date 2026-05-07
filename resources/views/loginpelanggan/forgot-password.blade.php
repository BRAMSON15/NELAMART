<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('css/login-pelanggan.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body>

    <div class="login-wrapper">

        <!-- LEFT: Form Panel -->
        <div class="login-form-panel">
            <h2>Lupa Password</h2>
            <p style="text-align: center; color: #6b7280; margin-bottom: 24px; font-size: 0.95rem; line-height: 1.5;">
                Masukkan email Anda dan kami akan mengirimkan link untuk mereset password Anda.
            </p>

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

            <form method="POST" action="{{ route('pelanggan.password.email') }}">
                @csrf

                <div class="form-group">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Email Terdaftar"
                        required
                        autofocus
                    >
                </div>

                <button type="submit" class="btn-signin">Kirim Link Reset</button>
            </form>

            <div class="back-link" style="text-align: center; margin-top: 24px;">
                <a href="{{ route('pelanggan.login') }}" style="color: #4a90e2; text-decoration: none; font-size: 0.9rem;">← Kembali ke Login</a>
            </div>
        </div>

        <!-- RIGHT: Info Panel -->
        <div class="login-info-panel">
             <div class="brand-icon"><i class="bi bi-bag"></i></div>
            <h3>Keamanan Akun</h3>
            <p>Kami menjaga keamanan data Anda. Pastikan menggunakan email yang valid untuk proses pemulihan akun.</p>
        </div>

    </div>

</body>
</html>

