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

<header class="topbar" style="background: #f7fafc; border-bottom: 1px solid #e2e8f0; padding: 16px 32px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; align-items: center; gap: 32px;">
        <h2 style="margin: 0; color: #2d3748; font-size: 1.25rem; font-weight: 600;">{{ $title }}</h2>
        <nav style="display: flex; gap: 24px;">
            <a href="{{ url('/resources') }}" style="text-decoration: none; color: #4a5568; font-weight: 500;">Ressources</a>
            <a href="{{ url('/categories') }}" style="text-decoration: none; color: #4a5568; font-weight: 500;">Catégories</a>
            <a href="{{ url('/reservations') }}" style="text-decoration: none; color: #4a5568; font-weight: 500;">Réservations</a>
            <a href="{{ url('/incidents') }}" style="text-decoration: none; color: #4a5568; font-weight: 500;">Incidents</a>
            <a href="{{ url('/maintenances') }}" style="text-decoration: none; color: #4a5568; font-weight: 500;">Maintenances</a>
            <a href="{{ route('notifications.index') }}" style="text-decoration: none; color: #4a5568; font-weight: 500; display: flex; align-items: center; gap: 6px;">
                Notifications
                @if($unreadCount > 0)
                    <span style="background: #fc8181; color: white; border-radius: 10px; padding: 2px 6px; font-size: 11px; font-weight: 600; min-width: 18px; text-align: center;">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </a>
            @can('view-statistics')
                <a href="{{ url('/statistics') }}" style="text-decoration: none; color: #4a5568; font-weight: 500;">Statistiques</a>
            @endcan
            <a href="{{ url('/dashboard') }}" style="text-decoration: none; color: #4a5568; font-weight: 500;">Dashboard</a>
        </nav>
    </div>

    <div class="user-menu">
        @if (Route::has('login'))
            @guest
                <a href="{{ route('login') }}" class="btn" style="background: #edf2f7; color: #4a5568; border: 1px solid #cbd5e0; padding: 8px 16px; border-radius: 6px; font-weight: 500;">Connexion</a>
                <a href="{{ route('register') }}" class="btn" style="background: #edf2f7; color: #4a5568; border: 1px solid #cbd5e0; padding: 8px 16px; border-radius: 6px; font-weight: 500;">Inscription</a>
            @else
                <div class="user-info" style="display: flex; align-items: center; gap: 16px;">
                    <span style="color: #4a5568; font-weight: 500;">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm" style="background: #edf2f7; color: #4a5568; border: 1px solid #cbd5e0; padding: 6px 12px; border-radius: 6px; font-weight: 500;">Déconnexion</button>
                    </form>
                </div>
            @endguest
        @else
            <div class="user-info">
                <span style="color: #4a5568; font-weight: 500;">Mode Test</span>
                <span class="badge" style="background: #edf2f7; color: #4a5568; margin-left: 12px; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Connecté</span>
                <a href="{{ route('login') }}" class="btn btn-sm" style="background: #edf2f7; color: #4a5568; border: 1px solid #cbd5e0; padding: 6px 12px; border-radius: 6px; font-weight: 500;">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-sm" style="background: #edf2f7; color: #4a5568; border: 1px solid #cbd5e0; padding: 6px 12px; border-radius: 6px; font-weight: 500;">Inscription</a>
            </div>
        @endif
    </div>
</header>