@extends('layouts.app')

@section('title', 'Tableau de Bord Technique')

@section('content')
<div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
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
                    <a href="{{ route('resources.index') }}" class="nav-link">
                        <i class="fas fa-server"></i>
                        <span>Ressources</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('maintenances.index') }}" class="nav-link">
                        <i class="fas fa-tools"></i>
                        <span>Maintenances</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('incidents.index') }}" class="nav-link">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Incidents</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('statistics.index') }}" class="nav-link">
                        <i class="fas fa-chart-line"></i>
                        <span>Statistiques</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-title">
                <h1>Tableau de bord technique</h1>
                <p class="header-subtitle">Gestion des ressources et maintenance du datacenter</p>
            </div>
            <div class="user-menu">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" title="Déconnexion">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </header>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-server"></i>
                </div>
                <div class="stat-content">
                    <h3>Serveurs actifs</h3>
                    <div class="stat-number">{{ $statistics['totalResources'] ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <h3>Réservations en attente</h3>
                    <div class="stat-number">{{ $statistics['pendingReservations'] ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="stat-content">
                    <h3>Maintenances planifiées</h3>
                    <div class="stat-number">{{ $statistics['criticalResources'] ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h3>Incidents signalés</h3>
                    <div class="stat-number">{{ is_array($incidents) ? count($incidents) : ($incidents->count() ?? 0) }}</div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="actions-grid">
            <div class="action-card" onclick="window.location.href='{{ route('resources.index') }}'">
                <div class="action-icon">
                    <i class="fas fa-server"></i>
                </div>
                <div class="action-content">
                    <h3>Gestion des ressources</h3>
                    <p>Ajouter, modifier et superviser les serveurs, VMs et équipements</p>
                    <button class="btn">Gérer les ressources</button>
                </div>
            </div>
            
            <div class="action-card" onclick="window.location.href='{{ route('tech.reservations.pending') }}'">
                <div class="action-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="action-content">
                    <h3>Validation des réservations</h3>
                    <p>Approuver ou rejeter les demandes de réservation des utilisateurs</p>
                    <button class="btn">Valider les réservations</button>
                </div>
            </div>
            
            <div class="action-card" onclick="window.location.href='{{ route('maintenances.index') }}'">
                <div class="action-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <div class="action-content">
                    <h3>Planification des maintenances</h3>
                    <p>Programmer et suivre les opérations de maintenance</p>
                    <button class="btn">Planifier maintenances</button>
                </div>
            </div>
            
            <div class="action-card" onclick="window.location.href='{{ route('statistics.index') }}'">
                <div class="action-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="action-content">
                    <h3>Rapports techniques</h3>
                    <p>Statistiques d'utilisation et performance des ressources</p>
                    <button class="btn">Voir les rapports</button>
                </div>
            </div>
            
            <div class="action-card" onclick="window.location.href='{{ route('incidents.index') }}'">
                <div class="action-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="action-content">
                    <h3>Gestion des incidents</h3>
                    <p>Traiter les signalements et les pannes matérielles</p>
                    <button class="btn">Gérer les incidents</button>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        @if(isset($recentActivities) && count($recentActivities) > 0)
        <div class="recent-activities">
            <h2>Activités récentes</h2>
            <div class="activities-list">
                @foreach($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-{{ $activity['icon'] ?? 'info-circle' }}"></i>
                    </div>
                    <div class="activity-content">
                        <h4>{{ $activity['title'] }}</h4>
                        <p>{{ $activity['description'] }}</p>
                        <span class="activity-time">{{ $activity['time'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </main>
</div>

<style>
:root {
    --primary: #194569;
    --secondary: #2c5282;
    --success: #28a745;
    --danger: #dc3545;
    --warning: #ffc107;
    --info: #17a2b8;
    --light: #f8f9fa;
    --dark: #343a40;
    --gray: #6c757d;
    --light-gray: #e9ecef;
    --border-radius: 8px;
    --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    --transition: all 0.3s ease;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

body {
    background-color: #f8fafc;
    color: #1e293b;
    line-height: 1.6;
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.dashboard-container {
    display: flex;
    min-height: 100vh;
}

/* Sidebar */
.sidebar {
    width: 260px;
    background: #d1d5db;
    border-right: 1px solid #e2e8f0;
    padding: 1.5rem 0;
    position: fixed;
    height: 100%;
    overflow-y: auto;
    transition: var(--transition);
    z-index: 1000;
}

.logo {
    text-align: center;
    padding: 20px 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
    border-bottom: 1px solid var(--light-gray);
    margin-bottom: 20px;
}

.nav-menu {
    list-style: none;
    padding: 0 15px;
}

.nav-item {
    margin-bottom: 5px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: var(--gray);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-link:hover, .nav-link.active {
    background-color: rgba(108, 117, 125, 0.1);
    color: var(--primary);
}

.nav-link i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}

/* Main Content */
.main-content {
    flex: 1;
    margin-left: 260px;
    padding: 20px;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 15px 25px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 25px;
}

.header-title h1 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--dark);
}

.header-subtitle {
    color: var(--gray);
    font-size: 0.9rem;
    margin-top: 5px;
}

.user-menu {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-name {
    font-weight: 500;
    color: var(--dark);
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
}

.logout-btn {
    background: none;
    border: none;
    color: var(--gray);
    cursor: pointer;
    font-size: 1rem;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.logout-btn:hover {
    background-color: rgba(220, 53, 69, 0.1);
    color: var(--danger);
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
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    border-left: 4px solid var(--primary);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    align-items: center;
    gap: 20px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    font-size: 2rem;
    color: var(--primary);
}

.stat-content h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 10px;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary);
}

/* Actions Grid */
.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.action-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    border-left: 4px solid var(--secondary);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.action-icon {
    font-size: 2rem;
    color: var(--secondary);
    margin-bottom: 15px;
}

.action-content h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 10px;
}

.action-content p {
    color: var(--gray);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 15px;
}

.btn {
    background: var(--secondary);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn:hover {
    background: var(--primary);
}

/* Recent Activities */
.recent-activities {
    margin-bottom: 30px;
}

.recent-activities h2 {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 20px;
}

.activities-list {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    border-bottom: 1px solid var(--light-gray);
    transition: all 0.3s ease;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-item:hover {
    background: rgba(0, 0, 0, 0.02);
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--info);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 5px;
}

.activity-content p {
    color: var(--gray);
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.activity-time {
    color: var(--light-gray);
    font-size: 0.8rem;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .stats-grid,
    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Script pour gérer les clics sur les cartes
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('[onclick*="window.location"]');
    cards.forEach(card => {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function(e) {
            // Ne pas suivre le lien si on clique sur un bouton à l'intérieur de la carte
            if (!e.target.closest('button, a')) {
                window.location = this.getAttribute('onclick').match(/'(.*?)'/)[1];
            }
        });
    </script>
</body>
</html>
