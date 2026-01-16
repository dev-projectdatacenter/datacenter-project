@props(['title' => 'Tableau de bord'])

<header class="topbar">
    <div class="page-title">
        <h1>{{ $title }}</h1>
    </div>

    <div class="user-menu">
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
    </div>
</header>