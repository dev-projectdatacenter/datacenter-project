<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'DataCenter') }} - Accueil</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        /* Un peu de style spécifique juste pour l'accueil */
        .hero-section {
            background-color: var(--bg-sidebar);
            color: white;
            padding: 1rem 15rem;
            text-align: center;
        }
        .hero-title { font-size: 3rem; margin-bottom: 1rem; font-weight: bold; }
        .hero-subtitle { font-size: 1.25rem; color: #94a3b8; margin-bottom: 2rem; }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 4rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <nav style="padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; background: white;">
        <div style="font-weight: bold; font-size: 1.2rem; color: var(--primary);">
            🔌 DataCenter Manager
        </div>
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn" style="color: var(--text-main);">Se connecter</a>
                    @endauth
            @endif
        </div>
    </nav>

    <header class="hero-section">
        <h1 class="hero-title">Gérez votre infrastructure IT<br>en toute simplicité.</h1>
        <p class="hero-subtitle">
            Surveillance des serveurs, gestion des incidents et réservation de ressources<br>
            centralisés en un seul endroit.
        </p>
        <div>
            <a href="{{ url('/login') }}" class="btn btn-primary" style="padding: 0.8rem 2rem; font-size: 1.1rem;">
                Accéder à l'espace Admin
            </a>
        </div>
    </header>

    <section class="feature-grid">
        <div class="card text-center">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">💻</div>
            <h3>Serveurs</h3>
            <p class="text-muted mt-3">Suivez l'état de vos machines en temps réel et gérez les maintenances.</p>
        </div>

        <div class="card text-center">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">🗓️</div>
            <h3>Réservations</h3>
            <p class="text-muted mt-3">Planifiez l'utilisation des ressources et évitez les conflits.</p>
        </div>

        <div class="card text-center">
            <div style="font-size: 2.5rem; margin-bottom: 1rem;">👤</div>
            <h3>Utilisateurs</h3>
            <p class="text-muted mt-3">Gérez les accès et les rôles de votre équipe technique.</p>
        </div>
    </section>

    <footer class="text-center" style="padding: 2rem; color: var(--text-muted); font-size: 0.9rem;">
        &copy; 2024 DataCenter Manager. Projet Developpement web.
    </footer>

</body>
</html>