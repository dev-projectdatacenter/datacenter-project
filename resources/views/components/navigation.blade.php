@props(['title' => 'Data Center'])

@php
    // Compter les notifications non lues
    $unreadCount = 0;
    if (Auth::check()) {
        $unreadCount = \App\Models\Notification::where('user_id', Auth::id())
            ->where('read', false)
            ->count();
    }
@endphp

<header class="topbar" style="background: white; border-bottom: 1px solid #ddd; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; align-items: center; gap: 20px;">
        <h2 style="margin: 0;">{{ $title }}</h2>
        <nav style="display: flex; gap: 15px;">
            <a href="{{ url('/resources') }}" style="text-decoration: none; color: #333;">Ressources</a>
            <a href="{{ url('/categories') }}" style="text-decoration: none; color: #333;">Catégories</a>
            <a href="{{ url('/reservations') }}" style="text-decoration: none; color: #333;">Réservations</a>
            <a href="{{ url('/incidents') }}" style="text-decoration: none; color: #333;">Incidents</a>
            <a href="{{ url('/maintenances') }}" style="text-decoration: none; color: #333;">Maintenances</a>
            <a href="{{ route('notifications.index') }}" style="text-decoration: none; color: #333; display: flex; align-items: center; gap: 5px;">
                Notifications
                @if($unreadCount > 0)
                    <span style="background: #dc3545; color: white; border-radius: 10px; padding: 2px 6px; font-size: 11px; font-weight: bold; min-width: 18px; text-align: center;">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </a>
            <a href="{{ url('/dashboard') }}" style="text-decoration: none; color: #333;">Dashboard</a>
        </nav>
    </div>

    <div class="user-menu">
        @if (Route::has('login'))
            @guest
                <a href="{{ route('login') }}" class="btn">Connexion</a>
                <a href="{{ route('register') }}" class="btn">Inscription</a>
            @else
                <div class="user-info" style="display: flex; align-items: center; gap: 10px;">
                    <span>{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm">Déconnexion</button>
                    </form>
                </div>
            @endguest
        @else
            <div class="user-info">
                <span>Mode Test</span>
                <span class="badge" style="background: #e2e8f0; color: #333; margin-left: 10px;">Connecté</span>
                <a href="{{ route('login') }}" class="btn btn-sm">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-sm">Inscription</a>
            </div>
        @endif
    </div>
</header>