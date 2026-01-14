<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Data Center Manager') }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

   <nav class="landing-nav">
        <div class="logo">
            <i class="fas fa-server"></i> DataCenter
        </div>
        <div class="nav-links">
            <a href="#" class="btn btn-outline">Se connecter</a>
            <a href="#" class="btn btn-primary">S'inscrire</a>
        </div>
    </nav>

    <header class="hero-section">
        <div class="hero-content">
            <h1>Gestion de Parc Informatique & <span style="color: var(--primary);">Ressources</span></h1>
            <p>Une plateforme centralisée pour gérer les serveurs, les machines virtuelles et les réservations d'accès pour vos équipes.</p>
            
            <div class="hero-actions">
                <a href="#" class="btn btn-primary btn-lg">
                         Accéder à la plateforme 
                <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                </a>
            </div>
        </div>
        <div class="hero-image">
            <i class="fas fa-network-wired"></i>
        </div>
    </header>

    <section class="features-section">
        <div class="feature-card">
            <div class="icon">
                <i class="fas fa-laptop-code"></i>
            </div>
            <h3>Gestion des Ressources</h3>
            <p>Inventaire complet des serveurs physiques et virtuels avec suivi d'état.</p>
        </div>

        <div class="feature-card">
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <h3>Système de Réservation</h3>
            <p>Planifiez l'utilisation des ressources et évitez les conflits d'accès.</p>
        </div>

        <div class="feature-card">
            <div class="icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h3>Administration</h3>
            <p>Gestion des rôles utilisateurs et validation des demandes en temps réel.</p>
        </div>
    </section>

    <footer class="landing-footer">
        <p>&copy; {{ date('Y') }} Data Center Manager.</p>
    </footer>

</body>
</html>