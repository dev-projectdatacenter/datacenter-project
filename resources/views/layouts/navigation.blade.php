<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-server me-2"></i>
            DataCenter Manager
        </a>

        <!-- Mobile toggle button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Menu principal -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>
                        Accueil
                    </a>
                </li>

                <!-- Ressources (visible pour tous les utilisateurs connectés) -->
                @if(auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="resourcesDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-server me-1"></i>
                            Ressources
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="resourcesDropdown">
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-list me-2"></i>Voir toutes les ressources
                            </a></li>
                            @if(auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'tech_manager')
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-plus me-2"></i>Ajouter une ressource
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-tools me-2"></i>Gérer les catégories
                                </a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Réservations (visible pour les utilisateurs connectés) -->
                @if(auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="reservationsDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Réservations
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="reservationsDropdown">
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-plus me-2"></i>Nouvelle réservation
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-list me-2"></i>Mes réservations
                            </a></li>
                            @if(auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'tech_manager')
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-clock me-2"></i>Réservations en attente
                                </a></li>
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-history me-2"></i>Historique
                                </a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Menu Admin (visible pour les administrateurs) -->
                @if(auth()->check() && auth()->user()->role->name === 'admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-shield me-1"></i>
                            Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users me-2"></i>Gérer les utilisateurs
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.account-requests') }}">
                                <i class="fas fa-user-plus me-2"></i>Demandes de compte
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.logs.index') }}">
                                <i class="fas fa-list-alt me-2"></i>Logs d'activité
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Paramètres système
                            </a></li>
                        </ul>
                    </li>
                @endif

                <!-- Menu Tech (visible pour les responsables techniques) -->
                @if(auth()->check() && auth()->user()->role->name === 'tech_manager')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="techDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-tools me-1"></i>
                            Technique
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="techDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard.tech') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard Tech
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-server me-2"></i>Gérer les ressources
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-wrench me-2"></i>Maintenances
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-check-circle me-2"></i>Approuver réservations
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-chart-bar me-2"></i>Statistiques
                            </a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            <!-- Right side menu -->
            <ul class="navbar-nav">
                <!-- Notifications -->
                @if(auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationsDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                    <span class="visually-hidden">Notifications non lues</span>
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="min-width: 300px;">
                            <li class="dropdown-header">
                                <i class="fas fa-bell me-2"></i>
                                Notifications
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="badge bg-danger ms-2">
                                        {{ auth()->user()->unreadNotifications->count() }} nouvelles
                                    </span>
                                @endif
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if(auth()->user()->notifications->count() > 0)
                                @foreach(auth()->user()->notifications->take(5) as $notification)
                                    <li class="dropdown-item {{ $notification->read_at ? '' : 'bg-light' }}">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                <div>{{ $notification->data['message'] ?? $notification->data['title'] ?? 'Notification' }}</div>
                                            </div>
                                            @if(!$notification->read_at)
                                                <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" class="ms-2">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                                @if(auth()->user()->notifications->count() > 5)
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-center" href="{{ route('notifications.index') }}">
                                        Voir toutes les notifications
                                    </a></li>
                                @endif
                            @else
                                <li><a class="dropdown-item text-muted" href="#">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Aucune notification
                                </a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- User menu -->
                @if(auth()->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ auth()->user()->name }}
                            <small class="text-muted ms-1">({{ auth()->user()->role->name }})</small>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li class="dropdown-header">
                                <i class="fas fa-user me-2"></i>
                                {{ auth()->user()->name }}
                                <br>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-user-edit me-2"></i>Mon profil
                            </a></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Paramètres
                            </a></li>
                            @if(auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'tech_manager')
                                <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-chart-bar me-2"></i>Statistiques
                                </a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        Se déconnecter
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Login/Register buttons for guests -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>
                            Demander un compte
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<!-- Quick stats bar (visible pour les utilisateurs connectés) -->
@if(auth()->check())
<div class="bg-light border-bottom py-2">
    <div class="container-fluid">
        <div class="row align-items-center text-center">
            <div class="col-md-3 col-6">
                <small class="text-muted">Ressources actives</small>
                <div class="fw-bold text-primary">42</div>
            </div>
            <div class="col-md-3 col-6">
                <small class="text-muted">Réservations aujourd'hui</small>
                <div class="fw-bold text-success">8</div>
            </div>
            <div class="col-md-3 col-6">
                <small class="text-muted">En maintenance</small>
                <div class="fw-bold text-warning">3</div>
            </div>
            <div class="col-md-3 col-6">
                <small class="text-muted">Taux d'occupation</small>
                <div class="fw-bold text-info">67%</div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
/* Styles personnalisés pour la navigation */
.navbar-brand {
    font-weight: 600;
    font-size: 1.25rem;
}

.navbar-nav .nav-link {
    font-weight: 500;
    transition: all 0.2s ease;
}

.navbar-nav .nav-link:hover {
    transform: translateY(-1px);
}

.navbar-nav .nav-link.active {
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 0.25rem;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.5rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    transform: translateX(2px);
}

.dropdown-header {
    padding: 0.5rem 1rem;
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.7em;
}

/* Quick stats bar */
.bg-light.border-bottom {
    background-color: #f8f9fa !important;
}

.bg-light.border-bottom .fw-bold {
    font-size: 1.1rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .navbar-brand {
        font-size: 1.1rem;
    }
    
    .navbar-nav .nav-link {
        padding: 0.5rem 1rem;
    }
    
    .dropdown-menu {
        position: static !important;
        transform: none !important;
        border: none;
        box-shadow: none;
        background-color: transparent;
    }
    
    .dropdown-item {
        color: rgba(255, 255, 255, 0.8) !important;
        padding-left: 2rem;
    }
    
    .dropdown-item:hover {
        color: white !important;
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .dropdown-header {
        color: rgba(255, 255, 255, 0.7) !important;
    }
}

/* Animation pour les badges */
.badge {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

/* Style pour les notifications non lues */
.dropdown-item.bg-light {
    border-left: 3px solid #007bff;
}

/* Bouton de déconnexion dans dropdown */
.dropdown-item.text-danger:hover {
    background-color: #f8d7da;
    color: #721c24 !important;
}
</style>

<script>
// Auto-rafraîchissement des notifications toutes les 30 secondes
@if(auth()->check())
setInterval(function() {
    // Recharger la page si l'utilisateur est sur une page de notifications
    if (window.location.pathname.includes('notifications')) {
        window.location.reload();
    }
}, 30000);
@endif

// Gestion du dropdown responsive
if (window.innerWidth < 768) {
    document.querySelectorAll('.dropdown-toggle').forEach(function(dropdown) {
        dropdown.addEventListener('click', function(e) {
            e.preventDefault();
            const menu = this.nextElementSibling;
            if (menu.style.display === 'block') {
                menu.style.display = 'none';
            } else {
                menu.style.display = 'block';
            }
        });
    });
}
</script>
