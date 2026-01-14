@extends('layouts.guest')

@section('title', 'Data Center Management')

@section('content')
<div class="welcome-container">
    <div class="welcome-header">
        <h1>🏢 Data Center Management</h1>
        <p class="subtitle">Système de gestion des ressources informatiques</p>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">👥</div>
            <h3>Gestion des Utilisateurs</h3>
            <p>4 rôles différents avec permissions adaptées</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">🖥️</div>
            <h3>Ressources</h3>
            <p>Serveurs, VMs, stockage et équipements réseau</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">📅</div>
            <h3>Réservations</h3>
            <p>Système complet avec validation automatique</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3>Statistiques</h3>
            <p>Tableaux de bord et rapports en temps réel</p>
        </div>
    </div>

    <!-- Section Test Authentification -->
    <div class="test-section">
        <h2>🧪 Test du Système d'Authentification</h2>
        <p class="test-description">Testez les différentes fonctionnalités du système :</p>
        
        <div class="test-buttons">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                🔐 Page de Connexion
            </a>
            
            <a href="{{ route('register') }}" class="btn btn-success btn-lg">
                📝 Demander un Compte
            </a>
            
            <a href="/mot-de-passe-oublie" class="btn btn-warning btn-lg">
                🔑 Mot de Passe Oublié
            </a>
            
            <a href="/403" class="btn btn-danger btn-lg">
                🚫 Test Erreur 403
            </a>
        </div>
    </div>

    <!-- Section Accès Rapide (si connecté) -->
    @if(auth()->check())
        <div class="user-section">
            <h2>👋 Bienvenue, {{ auth()->user()->name }} !</h2>
            <p class="user-role">Rôle : {{ __('roles.' . auth()->user()->role) }}</p>
            
            <div class="dashboard-buttons">
                @switch(auth()->user()->role)
                    @case('admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            🏢 Dashboard Admin
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                            👥 Gérer les Utilisateurs
                        </a>
                        <a href="{{ route('admin.requests.index') }}" class="btn btn-outline">
                            📋 Demandes en Attente
                        </a>
                        @break
                        
                    @case('tech_manager')
                        <a href="{{ route('dashboard.tech') }}" class="btn btn-primary">
                            🔧 Dashboard Tech
                        </a>
                        @break
                        
                    @case('user')
                        <a href="{{ route('dashboard.user') }}" class="btn btn-primary">
                            👤 Dashboard User
                        </a>
                        @break
                        
                    @default
                        <a href="/dashboard" class="btn btn-primary">
                            🏠 Dashboard
                        </a>
                @endswitch
                
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        🚪 Se Déconnecter
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Section Informations -->
    <div class="info-section">
        <h2>ℹ️ Informations du Projet</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Version Laravel :</strong> {{ app()->version() }}
            </div>
            <div class="info-item">
                <strong>Environnement :</strong> {{ app()->environment() }}
            </div>
            <div class="info-item">
                <strong>Version PHP :</strong> {{ PHP_VERSION }}
            </div>
            <div class="info-item">
                <strong>Statut Auth :</strong> ✅ Opérationnel
            </div>
        </div>
    </div>

    <!-- Section Équipe -->
    <div class="team-section">
        <h2>👥 Équipe de Développement</h2>
        <div class="team-grid">
            <div class="team-member">
                <div class="member-avatar">👩‍💼</div>
                <h4>FATIMA</h4>
                <p>BDD + Modèles + Coordination</p>
            </div>
            <div class="team-member">
                <div class="member-avatar">🔐</div>
                <h4>ZAHRAE</h4>
                <p>Authentification + Sécurité</p>
            </div>
            <div class="team-member">
                <div class="member-avatar">📊</div>
                <h4>OUARDA</h4>
                <p>Ressources + Statistiques</p>
            </div>
            <div class="team-member">
                <div class="member-avatar">🎫</div>
                <h4>HALIMA</h4>
                <p>Réservations + Notifications</p>
            </div>
            <div class="team-member">
                <div class="member-avatar">🎨</div>
                <h4>CHAYMAE</h4>
                <p>Design System + UI</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.welcome-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 20px;
}

.welcome-header {
    text-align: center;
    margin-bottom: 60px;
    color: white;
}

.welcome-header h1 {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 16px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.subtitle {
    font-size: 20px;
    opacity: 0.9;
    margin: 0;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    max-width: 1000px;
    margin: 0 auto 60px;
}

.feature-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.feature-icon {
    font-size: 48px;
    margin-bottom: 20px;
}

.feature-card h3 {
    color: #2d3748;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 12px;
}

.feature-card p {
    color: #718096;
    font-size: 16px;
    margin: 0;
}

.test-section {
    background: white;
    border-radius: 16px;
    padding: 40px;
    max-width: 800px;
    margin: 0 auto 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.test-section h2 {
    color: #2d3748;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 12px;
    text-align: center;
}

.test-description {
    color: #718096;
    font-size: 16px;
    text-align: center;
    margin-bottom: 30px;
}

.test-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.user-section {
    background: white;
    border-radius: 16px;
    padding: 40px;
    max-width: 800px;
    margin: 0 auto 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.user-section h2 {
    color: #2d3748;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 8px;
}

.user-role {
    color: #667eea;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 30px;
}

.dashboard-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.info-section {
    background: white;
    border-radius: 16px;
    padding: 40px;
    max-width: 800px;
    margin: 0 auto 40px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.info-section h2 {
    color: #2d3748;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.info-item {
    padding: 15px;
    background: #f7fafc;
    border-radius: 8px;
    font-size: 14px;
    color: #4a5568;
}

.team-section {
    background: white;
    border-radius: 16px;
    padding: 40px;
    max-width: 1000px;
    margin: 0 auto;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.team-section h2 {
    color: #2d3748;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 30px;
    text-align: center;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
}

.team-member {
    text-align: center;
    padding: 20px;
    border-radius: 12px;
    background: #f7fafc;
    transition: all 0.3s ease;
}

.team-member:hover {
    background: #edf2f7;
    transform: translateY(-2px);
}

.member-avatar {
    font-size: 48px;
    margin-bottom: 12px;
}

.team-member h4 {
    color: #2d3748;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
}

.team-member p {
    color: #718096;
    font-size: 14px;
    margin: 0;
}

/* Boutons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
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

.btn-lg {
    padding: 18px 36px;
    font-size: 18px;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #48bb78, #38a169);
    color: white;
}

.btn-warning {
    background: linear-gradient(135deg, #ed8936, #dd6b20);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #e53e3e, #c53030);
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

/* Responsive */
@media (max-width: 768px) {
    .welcome-container {
        padding: 20px 15px;
    }
    
    .welcome-header h1 {
        font-size: 36px;
    }
    
    .subtitle {
        font-size: 18px;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .test-buttons {
        grid-template-columns: 1fr;
    }
    
    .dashboard-buttons {
        flex-direction: column;
    }
    
    .dashboard-buttons .btn {
        width: 100%;
    }
    
    .team-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }
}
</style>
@endpush
