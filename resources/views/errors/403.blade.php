@extends('layouts.guest')

@section('title', 'Accès interdit')

@section('content')
<div class="error-container">
    <div class="error-card">
        <div class="error-icon">🚫</div>
        <h1>Accès interdit</h1>
        <p>Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
        
        <div class="error-details">
            <p><strong>Code d'erreur :</strong> 403 - Forbidden</p>
            <p><strong>Rôle actuel :</strong> {{ auth()->check() ? (auth()->user()->role->name ?? 'Rôle inconnu') : 'Non connecté' }}</p>
            <p><strong>URL demandée :</strong> {{ request()->url() }}</p>
            <p><strong>Méthode :</strong> {{ request()->method() }}</p>
            <p><strong>IP :</strong> {{ request()->ip() }}</p>
            @if(auth()->check())
                <p><strong>Utilisateur :</strong> {{ auth()->user()->name }} ({{ auth()->user()->email }})</p>
            @endif
            <p><strong>Timestamp :</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        @if(auth()->check())
            <!-- Utilisateur connecté mais sans permissions -->
            <div class="alert alert-warning">
                <h5 class="alert-heading">
                    <i class="fas fa-user-shield me-2"></i>
                    Permissions insuffisantes
                </h5>
                <p class="mb-2">
                    Vous êtes connecté en tant que :
                    <strong>{{ auth()->user()->name }}</strong>
                    ({{ auth()->user()->role->name ?? 'Rôle inconnu' }})
                </p>
                <p class="mb-0">
                    Cette action nécessite des permissions plus élevées.
                </p>
            </div>
        @else
            <!-- Utilisateur non connecté -->
            <div class="alert alert-info">
                <h5 class="alert-heading">
                    <i class="fas fa-info-circle me-2"></i>
                    Connexion requise
                </h5>
                <p class="mb-0">
                    Vous devez être connecté pour accéder à cette page.
                </p>
            </div>
        @endif

        <div class="error-actions">
            @if(auth()->check())
                @if(auth()->user()->role->name === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        🏠 Dashboard Admin
                    </a>
                @elseif(auth()->user()->role->name === 'tech_manager')
                    <a href="{{ route('dashboard.tech') }}" class="btn btn-primary">
                        🏠 Dashboard Tech
                    </a>
                @else
                    <a href="{{ route('dashboard.user') }}" class="btn btn-primary">
                        🏠 Dashboard User
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline">
                        🚪 Se déconnecter
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    🔐 Se connecter
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline">
                    🏠 Page d'accueil
                </a>
            @endif
        </div>

        <!-- Actions possibles selon le rôle -->
        @if(auth()->check())
            <div class="role-actions">
                <h4>Actions disponibles pour votre rôle :</h4>
                @if(auth()->user()->role->name === 'user')
                    <div class="role-card">
                        <h5><i class="fas fa-user me-2"></i>Utilisateur</h5>
                        <ul>
                            <li><a href="{{ route('dashboard.user') }}">🏠 Tableau de bord utilisateur</a></li>
                            <li><a href="#">📅 Mes réservations</a></li>
                            <li><a href="#">🖥️ Voir les ressources disponibles</a></li>
                            <li><a href="#">📊 Mes statistiques</a></li>
                        </ul>
                    </div>
                @elseif(auth()->user()->role->name === 'tech_manager')
                    <div class="role-card">
                        <h5><i class="fas fa-tools me-2"></i>Responsable technique</h5>
                        <ul>
                            <li><a href="{{ route('dashboard.tech') }}">🏠 Tableau de bord technique</a></li>
                            <li><a href="#">🔧 Gérer les ressources</a></li>
                            <li><a href="#">✅ Approuver les réservations</a></li>
                            <li><a href="#">🔧 Planifier les maintenances</a></li>
                            <li><a href="#">📊 Statistiques des ressources</a></li>
                        </ul>
                    </div>
                @elseif(auth()->user()->role->name === 'admin')
                    <div class="role-card">
                        <h5><i class="fas fa-user-shield me-2"></i>Administrateur</h5>
                        <ul>
                            <li><a href="{{ route('admin.dashboard') }}">🏠 Dashboard administrateur</a></li>
                            <li><a href="#">👥 Gérer les utilisateurs</a></li>
                            <li><a href="#">📋 Gérer les demandes de compte</a></li>
                            <li><a href="#">📊 Voir les logs d'activité</a></li>
                            <li><a href="#">⚙️ Paramètres système</a></li>
                        </ul>
                    </div>
                @endif
            </div>
        @endif

        <div class="help-section">
            <h3>Besoin d'aide ?</h3>
            <p>Si vous pensez que c'est une erreur, veuillez contacter l'administrateur système.</p>
            <ul>
                <li>Vérifiez que vous êtes connecté avec le bon compte</li>
                <li>Assurez-vous d'avoir les permissions nécessaires</li>
                <li>Contactez votre administrateur si le problème persiste</li>
                <li>Vérifiez que l'URL est correcte</li>
            </ul>
            
            @if(!auth()->check())
                <div class="mt-3">
                    <h6>Pas encore de compte ?</h6>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-2"></i>
                        Demander un compte
                    </a>
                </div>
            @endif
        </div>

        <!-- Informations techniques détaillées -->
        <div class="technical-info">
            <details>
                <summary><i class="fas fa-code me-2"></i>Informations techniques</summary>
                <div class="tech-details">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>User Agent:</strong></td>
                            <td class="text-break">{{ request()->userAgent() }}</td>
                        </tr>
                        <tr>
                            <td><strong>Referer:</strong></td>
                            <td class="text-break">{{ request()->header('referer') ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Session ID:</strong></td>
                            <td>{{ session()->getId() }}</td>
                        </tr>
                        <tr>
                            <td><strong>Locale:</strong></td>
                            <td>{{ app()->getLocale() }}</td>
                        </tr>
                        <tr>
                            <td><strong>Environment:</strong></td>
                            <td>{{ app()->environment() }}</td>
                        </tr>
                    </div>
                </div>
            </details>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.error-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
}

.error-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 40px;
    text-align: center;
    max-width: 600px;
    width: 100%;
}

.error-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.error-card h1 {
    color: #2d3748;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 16px;
}

.error-card > p {
    color: #718096;
    font-size: 16px;
    margin-bottom: 30px;
    line-height: 1.5;
}

.error-details {
    background: #f7fafc;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    text-align: left;
}

.error-details p {
    margin: 4px 0;
    font-size: 13px;
    color: #4a5568;
}

.error-details strong {
    color: #2d3748;
}

.error-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.role-actions {
    margin-bottom: 20px;
}

.role-actions h4 {
    color: #2d3748;
    font-size: 16px;
    margin-bottom: 12px;
}

.role-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
    text-align: left;
}

.role-card h5 {
    color: #495057;
    font-size: 14px;
    margin-bottom: 10px;
}

.role-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.role-card li {
    margin: 5px 0;
}

.role-card a {
    color: #6c757d;
    text-decoration: none;
    font-size: 13px;
    transition: color 0.2s;
}

.role-card a:hover {
    color: #007bff;
}

.help-section {
    border-top: 1px solid #e2e8f0;
    padding-top: 20px;
    margin-top: 20px;
}

.help-section h3 {
    color: #2d3748;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 12px;
}

.help-section p {
    color: #718096;
    font-size: 14px;
    margin-bottom: 16px;
}

.help-section ul {
    text-align: left;
    color: #4a5568;
    font-size: 14px;
    line-height: 1.6;
}

.help-section li {
    margin-bottom: 8px;
}

.technical-info {
    margin-top: 20px;
    text-align: left;
}

.technical-info details {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
}

.technical-info summary {
    cursor: pointer;
    font-weight: 600;
    color: #495057;
    padding: 5px;
}

.technical-info summary:hover {
    color: #007bff;
}

.tech-details {
    margin-top: 10px;
}

.table-sm td {
    padding: 5px;
    font-size: 12px;
}

.text-break {
    word-break: break-all;
}

/* Boutons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-outline {
    background-color: transparent;
    border: 2px solid #667eea;
    color: #667eea;
}

.btn-outline:hover {
    background-color: #667eea;
    color: white;
}

.btn-outline-primary {
    background-color: transparent;
    border: 2px solid #007bff;
    color: #007bff;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    color: white;
}

/* Alerts */
.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: left;
}

.alert-warning {
    background-color: #fff3cd;
    border: 1px solid #ffeaa7;
    color: #856404;
}

.alert-info {
    background-color: #d1ecf1;
    border: 1px solid #bee5eb;
    color: #0c5460;
}

.alert-heading {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 10px;
}

/* Responsive */
@media (max-width: 480px) {
    .error-container {
        padding: 10px;
    }
    
    .error-card {
        padding: 30px 20px;
    }
    
    .error-icon {
        font-size: 48px;
    }
    
    .error-card h1 {
        font-size: 28px;
    }
    
    .error-actions {
        flex-direction: column;
    }
    
    .error-actions .btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
    // Auto-redirection après 15 secondes si non connecté
    @if(!auth()->check())
    let countdown = 15;
    let countdownInterval = setInterval(function() {
        countdown--;
        if (countdown <= 0) {
            clearInterval(countdownInterval);
            if (confirm('Rediriger vers la page de connexion ?')) {
                window.location.href = '{{ route("login") }}';
            }
        }
    }, 1000);
    @endif
    
    // Logger l'erreur 403 pour analyse
    console.log('403 Error logged:', {
        url: window.location.href,
        userAgent: navigator.userAgent,
        timestamp: new Date().toISOString(),
        @if(auth()->check())
        userId: {{ auth()->user()->id }},
        userRole: '{{ auth()->user()->role->name ?? "unknown" }}',
        userEmail: '{{ auth()->user()->email }}',
        @endif
        referer: document.referrer,
        sessionId: '{{ session()->getId() }}'
    });
    
    // Afficher/masquer les détails techniques
    document.querySelector('details summary').addEventListener('click', function() {
        const details = this.parentElement;
        if (details.open) {
            console.log('Technical details expanded');
        }
    });
</script>
@endpush
