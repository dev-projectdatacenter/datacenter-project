<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Data Center Manager') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: var(--radius);
            margin-bottom: 0.25rem;
            transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            background-color: var(--primary);
            color: white;
        }
        .nav-link span { margin-right: 0.75rem; }
    </style>
</head>
<body>

    <div class="dashboard-layout">
        
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>🔌 DataCenter</h3>
            </div>

            <nav class="sidebar-content">
                <a href="{{ url('/') }}" class="nav-link">
                    <span>📊</span> Dashboard
                </a>
                
                <a href="{{ url('/ressources') }}" class="nav-link">
                    <span>🖥️</span> Ressources
                </a>

                <a href="{{ url('/reservations') }}" class="nav-link">
                    <span>📅</span> Réservations
                </a>

                <a href="{{ url('/users') }}" class="nav-link">
                    <span>👥</span> Utilisateurs
                </a>
            </nav>

            <div class="p-3 border-t border-gray-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 text-small">
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            
            <header class="topbar">
                <button class="btn" id="sidebarToggle" style="padding: 0.25rem;">
                    ☰ Menu
                </button>

                <div class="d-flex items-center gap-2">
                    <span class="badge badge-success">En ligne</span>
                    <strong>{{ Auth::user()->name ?? 'Invité' }}</strong>
                </div>
            </header>

            <div class="container-fluid p-4">
                
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
                
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            if(toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>