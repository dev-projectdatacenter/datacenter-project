@props(['title' => 'Tableau de bord'])

<header class="topbar">
    <div class="page-title">
        <h1>{{ $title }}</h1>
        <nav style="margin-left: 20px; display: flex; gap: 15px;">
            <a href="{{ url('/resources') }}" style="text-decoration: none; color: #34495e; font-weight: 500;">Ressources</a>
            <a href="{{ url('/categories') }}" style="text-decoration: none; color: #34495e; font-weight: 500;">Catégories</a>
            <a href="{{ url('/incidents') }}" style="text-decoration: none; color: #34495e; font-weight: 500;">Incidents</a>
            <a href="{{ url('/maintenances') }}" style="text-decoration: none; color: #34495e; font-weight: 500;">Maintenances</a>
            <a href="{{ url('/statistics') }}" style="text-decoration: none; color: #34495e; font-weight: 500;">Statistiques</a>
        </nav>
    </div>

    <div class="user-menu">
        @if (Route::has('login'))
            @guest
                <a href="{{ route('login') }}" class="btn btn-primary">Connexion</a>
            @else
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    @if(Auth::user()->role === 'admin')
                        <span class="badge badge-danger" style="margin: 0 10px;">Admin</span>
                    @endif
                    <a href="{{ route('logout') }}" 
                       class="btn btn-danger btn-sm"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       title="Se déconnecter">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @endguest
        @else
            <div class="user-info">
                <span class="user-name">Mode Test (Ouarda)</span>
                <span class="badge badge-success" style="margin: 0 10px;">Connecté</span>
            </div>
        @endif
    </div>
</header>