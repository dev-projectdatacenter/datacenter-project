@extends('layouts.app')

@section('title', 'Tableau de Bord Admin')

@section('content')
<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <i class="fas fa-server"></i>
            <span>DataCenter</span>
        </div>
        <nav>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.resources.index') }}" class="nav-link">
                        <i class="fas fa-server"></i>
                        <span>Ressources</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Utilisateurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reservations.index') }}" class="nav-link">
                        <i class="fas fa-calendar"></i>
                        <span>Réservations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.logs.index') }}" class="nav-link">
                        <i class="fas fa-list"></i>
                        <span>Logs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="header">
            <div>
                <h1>Tableau de bord Administrateur</h1>
                <p>Bienvenue, {{ auth()->user()->name }}!</p>
            </div>
            <div class="user-info">
                <span>{{ auth()->user()->email }}</span>
                <div class="user-avatar">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <a href="{{ route('logout') }}" class="btn btn-outline">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card" onclick="window.location.href='{{ route('admin.resources.index') }}'">
                <i class="fas fa-server"></i>
                <div class="stat-value">{{ $statistics['totalResources'] ?? 0 }}</div>
                <div class="stat-label">Ressources totales</div>
            </div>
            <div class="stat-card" onclick="window.location.href='{{ route('admin.resources.index') }}?status=available'">
                <i class="fas fa-check-circle"></i>
                <div class="stat-value">{{ $statistics['availableResources'] ?? 0 }}</div>
                <div class="stat-label">Disponibles</div>
            </div>
            <div class="stat-card" onclick="window.location.href='{{ route('admin.users.index') }}'">
                <i class="fas fa-users"></i>
                <div class="stat-value">{{ $statistics['totalUsers'] ?? 0 }}</div>
                <div class="stat-label">Utilisateurs</div>
            </div>
            <div class="stat-card" onclick="window.location.href='{{ route('admin.reservations.index') }}'">
                <i class="fas fa-calendar-alt"></i>
                <div class="stat-value">{{ $statistics['totalReservations'] ?? 0 }}</div>
                <div class="stat-label">Réservations</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Actions rapides</h2>
            </div>
            <div class="quick-actions">
                <a href="{{ route('admin.resources.create') }}" class="action-card">
                    <div class="action-icon">➕</div>
                    <div class="action-title">Ajouter une ressource</div>
                    <div class="action-description">Ajouter un nouveau serveur ou équipement</div>
                </a>
                <a href="{{ route('admin.users.create') }}" class="action-card">
                    <div class="action-icon">👤</div>
                    <div class="action-title">Créer un utilisateur</div>
                    <div class="action-description">Ajouter un nouvel utilisateur au système</div>
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="action-card">
                    <div class="action-icon">📅</div>
                    <div class="action-title">Gérer les réservations</div>
                    <div class="action-description">Voir et approuver les demandes</div>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="action-card">
                    <div class="action-icon">⚙️</div>
                    <div class="action-title">Paramètres</div>
                    <div class="action-description">Configurer le système</div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Activité récente</h2>
                <a href="{{ route('admin.logs.index') }}" class="btn btn-outline">
                    <i class="fas fa-list"></i> Voir tous les logs
                </a>
            </div>
            <ul class="activity-list">
                @forelse($activityLogs as $log)
                    <li class="activity-item">
                        <div class="activity-icon activity-{{ $log->action }}">
                            @switch($log->action)
                                @case('login')
                                    🔴
                                    @break
                                @case('logout')
                                    🔴
                                    @break
                                @case('user_created')
                                    👤
                                    @break
                                @case('account_request_approved')
                                    ✅
                                    @break
                                @default
                                    📋
                            @endswitch
                        </div>
                        <div class="activity-content">
                            <div class="activity-text">{{ $log->description }}</div>
                            <div class="activity-meta">
                                {{ $log->created_at->diffForHumans() }}
                                @if($log->user)
                                    • {{ $log->user->name }}
                                @endif
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="activity-item">
                        <div class="activity-content">
                            <div class="activity-text">Aucune activité récente</div>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </main>
</div>

<style>
:root {
    --primary: #194569;
    --secondary: #2c5282;
    --success: #28a745;
    --danger: #dc3545;
    --warning: #ffc107;
    --light: #f8f9fa;
    --dark: #343a40;
    --gray: #6c757d;
    --light-gray: #e9ecef;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
}

body {
    background-color: #f5f7fb;
    color: #333;
    line-height: 1.6;
}

.dashboard-container {
    display: flex;
    min-height: 100vh;
}

/* Sidebar */
.sidebar {
    width: 250px;
    background: white;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    padding: 20px 0;
    position: fixed;
    height: 100%;
    overflow-y: auto;
}

.logo {
    text-align: center;
    padding: 20px;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
}

.logo i {
    margin-right: 10px;
}

.nav-menu {
    list-style: none;
    padding: 0;
}

.nav-item {
    margin-bottom: 5px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #555;
    text-decoration: none;
    transition: all 0.3s ease;
}

.nav-link:hover, .nav-link.active {
    background-color: var(--primary);
    color: white;
}

.nav-link i {
    width: 20px;
    margin-right: 10px;
}

/* Main Content */
.main-content {
    flex: 1;
    margin-left: 250px;
    padding: 20px;
}

.header {
    background: white;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h1 {
    color: var(--dark);
    font-size: 1.8rem;
    font-weight: 600;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.stat-card i {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 15px;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 5px;
}

.stat-label {
    color: var(--gray);
    font-size: 0.9rem;
}

/* Sections */
.section {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--dark);
}

.btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: var(--primary);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    background: var(--secondary);
    transform: translateY(-2px);
}

.btn i {
    margin-right: 8px;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--primary);
    color: var(--primary);
}

.btn-outline:hover {
    background: var(--primary);
    color: white;
}

/* Activity Logs */
.activity-list {
    list-style: none;
    padding: 0;
}

.activity-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid var(--light-gray);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 0.9rem;
}

.activity-create { background: #d4edda; color: #155724; }
.activity-update { background: #fff3cd; color: #856404; }
.activity-delete { background: #f8d7da; color: #721c24; }
.activity-login { background: #d1ecf1; color: #0c5460; }
.activity-logout { background: #e2e3e5; color: #383d41; }

.activity-content {
    flex: 1;
}

.activity-text {
    font-weight: 500;
    margin-bottom: 5px;
}

.activity-meta {
    font-size: 0.85rem;
    color: var(--gray);
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.action-card {
    background: white;
    border: 2px solid var(--light-gray);
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.action-card:hover {
    border-color: var(--primary);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.action-icon {
    font-size: 2rem;
    color: var(--primary);
    margin-bottom: 10px;
}

.action-title {
    font-weight: 600;
    margin-bottom: 5px;
}

.action-description {
    font-size: 0.85rem;
    color: var(--gray);
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
