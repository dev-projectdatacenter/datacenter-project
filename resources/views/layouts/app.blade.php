<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Data Center') }}</title>

    <!-- Vanilla CSS -->
    {{-- @vite(['resources/css/app.css']) --}}
    
    <!-- Chart.js (Pour les statistiques) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/charts.js') }}" defer></script>
    
    <style>
        /* Style d'urgence si la BDD est en panne pour l'affichage de l'erreur */
        .db-error-box { background: #fee; color: #c00; padding: 10px; border: 1px solid #c00; margin: 20px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar">
            <a class="navbar-brand" href="{{ url('/') }}">
                Data Center Gestion
            </a>

            <ul class="nav-links">
                <!-- Liens basiques sans dépendance DB forcée pour le test -->
                <li><a href="{{ url('/resources') }}">Ressources</a></li>
                <li><a href="{{ url('/categories') }}">Catégories</a></li>
                <li><a href="{{ url('/incidents') }}">Incidents</a></li>
                <li><a href="{{ url('/maintenances') }}">Maintenances</a></li>
                <li><a href="{{ url('/statistics') }}">Statistiques</a></li>
                
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ url('/home') }}">Tableau de bord</a></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Connexion</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">S'inscrire</a></li>
                        @endif
                    @endauth
                @endif
            </ul>
        </nav>

        <div class="container">
            {{-- Message d'erreur personnalisé si la BDD ne répond pas --}}
            @if(isset($exception) && str_contains($exception->getMessage(), 'SQLSTATE'))
                <div class="db-error-box">
                    🚨 Attention : Le serveur de base de données (MySQL) est éteint. Lancez MySQL dans XAMPP/Laragon.
                </div>
            @endif

            <main>
                @yield('content')
            </main>
        </div>

        <footer>
            <p>&copy; {{ date('Y') }} Data Center Project - Fatima, Zahrae, Ouarda, Halima, Chaymae</p>
        </footer>
    </div>
</body>
</html>