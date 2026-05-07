<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Daftar Chat - NELA MART</title>
    <link href="{{asset('mentahan1/css/styles.css')}}" rel="stylesheet" />
    <link href="{{asset('css/admin-dashboard.css')}}?v={{ time() }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .chat-list-card { border-radius: 15px; border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .user-item { transition: all 0.2s; border-radius: 10px; border: 1px solid transparent; text-decoration: none !important; }
        .user-item:hover { background-color: #f1f5f9; border-color: #e2e8f0; transform: translateX(5px); }
        .user-avatar { width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px; }
        .last-message { font-size: 13px; color: #64748b; margin-bottom: 0; }
        .unread-badge { width: 10px; height: 10px; background-color: #ef4444; border-radius: 50%; display: inline-block; }
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
                    <h1 class="mt-4">Chat Pelanggan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Chat Pelanggan</li>
                    </ol>

                    <div class="card chat-list-card">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Daftar Percakapan</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @forelse($users as $user)
                                    <a href="{{ route('admin.chat.show', $user->id) }}" class="list-group-item list-group-item-action user-item p-3 border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <h6 class="mb-0 fw-bold text-dark">{{ $user->name }}</h6>
                                                    @php
                                                        $lastMessage = \App\Models\Chat::where(function($q) use ($user) {
                                                                $q->where('pengirim_id', Auth::id())->where('penerima_id', $user->id);
                                                            })->orWhere(function($q) use ($user) {
                                                                $q->where('pengirim_id', $user->id)->where('penerima_id', Auth::id());
                                                            })->latest()->first();
                                                        
                                                        $unreadCount = \App\Models\Chat::where('pengirim_id', $user->id)
                                                            ->where('penerima_id', Auth::id())
                                                            ->where('is_read', false)
                                                            ->count();
                                                    @endphp
                                                    <small class="text-muted">{{ $lastMessage ? $lastMessage->created_at->diffForHumans() : '' }}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="last-message text-truncate" style="max-width: 400px;">
                                                        {{ $lastMessage ? $lastMessage->pesan : 'Mulai percakapan...' }}
                                                    </p>
                                                    @if($unreadCount > 0)
                                                        <span class="badge rounded-pill bg-danger">{{ $unreadCount }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="fas fa-comments-slash fa-4x text-muted opacity-25 mb-3 d-block"></i>
                                        <h5 class="text-muted">Belum ada chat masuk</h5>
                                        <p class="text-muted small">Pesan dari pelanggan akan muncul di sini</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('mentahan1/js/scripts.js')}}"></script>
</body>
</html>
