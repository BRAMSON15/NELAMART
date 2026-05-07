<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/pelanggan.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/"><i class="fas fa-store me-2"></i>NELA MART</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="chat-container">
            <div class="chat-header admin-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-shield"></i> Chat dengan Admin
                </h5>
                <small>{{ $admin->name }}</small>
            </div>

            <div class="chat-messages" id="chatMessages">
                @forelse($chats as $chat)
                <div class="message {{ $chat->pengirim_id == Auth::id() ? 'sent' : 'received' }}">
                    <div class="message-bubble">
                        <p class="mb-1">{{ $chat->pesan }}</p>
                        <small style="opacity: 0.7;">{{ $chat->created_at->format('H:i') }}</small>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted">
                    <i class="fas fa-comments fa-3x mb-3"></i>
                    <p>Belum ada pesan. Mulai percakapan dengan admin!</p>
                </div>
                @endforelse
            </div>

            <div class="chat-input">
                <form method="POST" action="{{ route('chat.kirim') }}">
                    @csrf
                    <input type="hidden" name="penerima_id" value="{{ $admin->id }}">
                    <div class="input-group">
                        <input type="text" name="pesan" class="form-control" placeholder="Ketik pesan..." required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/chat-utils.js') }}"></script>
</body>
</html>

