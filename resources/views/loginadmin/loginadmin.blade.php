<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - NELA MART</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body class="bg-admin">
    <div class="login-container">

        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-user-shield" style="color:#26b99a;font-size:32px;"></i>
            </div>
            <h2>Login Admin</h2>
            <p>Masuk ke panel administrator</p>
        </div>

        @if($errors->any())
            <div class="error-message">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username"
                           value="{{ old('username') }}"
                           placeholder="Masukkan username Anda"
                           required autofocus>
                    <span class="input-icon">👤</span>
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
                <i class="fas fa-sign-in-alt me-2"></i> Masuk sebagai Admin
            </button>
        </form>

        <!-- <div class="divider"><span>atau login sebagai</span></div>

        <div class="other-logins">
            <a href="/user/login" class="other-login-btn">
                <i class="fas fa-store me-1"></i> Penjual
            </a>
            <a href="/pelanggan/login" class="other-login-btn">
                <i class="fas fa-shopping-bag me-1"></i> Pelanggan
            </a> 
        </div> -->

        <div class="back-link">
            <a href="/"><span>←</span> Kembali ke Beranda</a>
        </div>
    </div>

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</body>
</html>

