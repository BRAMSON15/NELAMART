<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Penjual - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body class="bg-user">
    <div class="login-container">

        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-store" style="color:#26b99a;font-size:32px;"></i>
            </div>
            <h2>Login Penjual</h2>
            <p>Masuk ke panel UMKM Anda</p>
        </div>

        @if(session('success'))
            <div class="success-message">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="error-message">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('user.login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="Masukkan email Anda"
                           required autofocus>
                    <span class="input-icon">✉️</span>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password Anda"
                           required>
                    <span class="input-icon">🔒</span>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Login
            </button>
        </form>

        <div class="divider"><span>belum punya akun?</span></div>

        <div class="register-link">
            <p>Daftarkan toko UMKM Anda sekarang</p>
            <a href="{{ route('user.register') }}">
                <i class="fas fa-store me-2"></i> Daftar Sebagai Pelaku UMKM
            </a>
        </div>

        <!-- <div class="divider"><span>atau login sebagai</span></div>

        <div class="other-logins">
            <a href="/admin/login" class="other-login-btn">
                <i class="fas fa-user-shield me-1"></i> Admin
            </a>
            <a href="/pelanggan/login" class="other-login-btn">
                <i class="fas fa-shopping-bag me-1"></i> Pelanggan
            </a> 
        </div> 

        <div class="back-link">
            <a href="/"><span>←</span> Kembali ke Beranda</a>
        </div>
    </div>-->

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>

