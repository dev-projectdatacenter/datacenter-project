@props(['title' => 'Tableau de bord'])

<header class="topbar" style="background: white; border-bottom: 1px solid #ddd; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; align-items: center; gap: 20px;">
        <h2 style="margin: 0;">{{ $title }}</h2>
        <nav style="display: flex; gap: 15px;">
            <a href="{{ url('/resources') }}" style="text-decoration: none; color: #333;">Ressources</a>
            <a href="{{ url('/categories') }}" style="text-decoration: none; color: #333;">Catégories</a>
            <a href="{{ url('/incidents') }}" style="text-decoration: none; color: #333;">Incidents</a>
            <a href="{{ url('/maintenances') }}" style="text-decoration: none; color: #333;">Maintenances</a>
            <a href="{{ url('/statistics') }}" style="text-decoration: none; color: #333;">Statistiques</a>
        </nav>
    </div>

    <div class="user-menu">
        @if (Route::has('login'))
            @guest
                <a href="{{ route('login') }}" class="btn">Connexion</a>
            @else
                <div class="user-info" style="display: flex; align-items: center; gap: 10px;">
                    <span>{{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" 
                       class="btn btn-sm"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Déconnexion
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            @endguest
        @else
            <div class="user-info">
                <span>Mode Test</span>
                <span class="badge" style="background: #e2e8f0; color: #333; margin-left: 10px;">Connecté</span>
            </div>
        @endif
    </div>
</header>