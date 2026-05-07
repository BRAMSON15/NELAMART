<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Chat dengan {{ $user->name }} - NELA MART</title>
    <link href="{{asset('mentahan1/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('css/admin-dashboard.css')}}?v={{ time() }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .chat-container { height: 600px; display: flex; flex-direction: column; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
        .chat-header { padding: 20px 30px; border-bottom: 1px solid rgba(0,0,0,0.05); background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; }
        .chat-messages { flex: 1; padding: 30px; overflow-y: auto; background: #fdfdfd; }
        .chat-input { padding: 25px 30px; background: white; border-top: 1px solid rgba(0,0,0,0.05); }
        .message { margin-bottom: 20px; display: flex; }
        .message.sent { justify-content: flex-end; }
        .message-bubble { max-width: 70%; padding: 12px 20px; border-radius: 18px; font-size: 15px; position: relative; }
        .message.received .message-bubble { background: #f1f5f9; color: #1e293b; border-bottom-left-radius: 4px; }
        .message.sent .message-bubble { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border-bottom-right-radius: 4px; }
        .message-time { font-size: 11px; opacity: 0.7; margin-top: 5px; display: block; }
        .user-avatar-small { width: 40px; height: 40px; border-radius: 10px; background: white; color: #6366f1; display: flex; align-items: center; justify-content: center; font-weight: bold; }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="/">NELA MART</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu Utama</div>
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Manajemen</div>
                        <a class="nav-link" href="{{ route('admin.kelola-toko') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
                            Kelola Toko
                        </a>
                        <a class="nav-link" href="{{ route('admin.kelola-user') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Kelola User
                        </a>
                        <a class="nav-link active" href="{{ route('admin.chat.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-comments"></i></div>
                            Terima Chat
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="mt-4">Chat: {{ $user->name }}</h1>
                        <a href="{{ route('admin.chat.index') }}" class="btn btn-outline-secondary mt-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.chat.index') }}">Chat Pelanggan</a></li>
                        <li class="breadcrumb-item active">{{ $user->name }}</li>
                    </ol>

                    <div class="chat-container">
                        <div class="chat-header d-flex align-items-center">
                            <div class="user-avatar-small me-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $user->name }}</h5>
                                <small class="opacity-75">Pelanggan</small>
                            </div>
                        </div>

                        <div class="chat-messages" id="chatMessages">
                            @forelse($chats as $chat)
                                <div class="message {{ $chat->pengirim_id == Auth::id() ? 'sent' : 'received' }}">
                                    <div class="message-bubble">
                                        {{ $chat->pesan }}
                                        <span class="message-time">{{ $chat->created_at->format('H:i') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-comments fa-3x mb-3 opacity-25"></i>
                                    <p>Belum ada pesan. Mulai percakapan sekarang!</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="chat-input">
                            <form action="{{ route('chat.kirim') }}" method="POST">
                                @csrf
                                <input type="hidden" name="penerima_id" value="{{ $user->id }}">
                                <div class="input-group">
                                    <input type="text" name="pesan" class="form-control" placeholder="Tulis pesan..." required style="border-radius: 12px 0 0 12px; padding: 12px 20px;">
                                    <button class="btn btn-primary px-4" type="submit" style="border-radius: 0 12px 12px 0; background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('mentahan1/js/scripts.js')}}"></script>
    <script>
        // Auto scroll to bottom
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    </script>
</body>
</html>
