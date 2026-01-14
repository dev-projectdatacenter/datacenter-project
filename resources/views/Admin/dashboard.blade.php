@extends('layouts.admin')

@section('title', 'Dashboard Administrateur')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Dashboard Administrateur</h1>
        <p class="dashboard-subtitle">Vue d'ensemble du système Data Center</p>
    </div>

    <!-- Statistiques principales -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon users">
                👥
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ App\Models\User::count() }}</div>
                <div class="stat-label">Utilisateurs totaux</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon requests">
                📋
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ App\Models\AccountRequest::where('status', 'pending')->count() }}</div>
                <div class="stat-label">Demandes en attente</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon resources">
                🖥️
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ App\Models\Resource::count() ?? 0 }}</div>
                <div class="stat-label">Ressources totales</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon reservations">
                📅
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ App\Models\Reservation::count() ?? 0 }}</div>
                <div class="stat-label">Réservations totales</div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="dashboard-section">
        <h2>Actions rapides</h2>
        <div class="quick-actions">
            <a href="{{ route('admin.users.create') }}" class="action-card">
                <div class="action-icon">➕</div>
                <div class="action-title">Créer un utilisateur</div>
                <div class="action-description">Ajouter un nouvel utilisateur au système</div>
            </a>

            <a href="{{ route('admin.requests.index') }}" class="action-card">
                <div class="action-icon">📋</div>
                <div class="action-title">Valider les demandes</div>
                <div class="action-description">Approuver ou refuser les demandes de compte</div>
            </a>

            <a href="{{ route('admin.users.index') }}" class="action-card">
                <div class="action-icon">👥</div>
                <div class="action-title">Gérer les utilisateurs</div>
                <div class="action-description">Modifier les rôles et permissions</div>
            </a>

            <a href="{{ route('admin.logs.index') }}" class="action-card">
                <div class="action-icon">📝</div>
                <div class="action-title">Voir les logs</div>
                <div class="action-description">Consulter l'activité du système</div>
            </a>
        </div>
    </div>

    <!-- Activité récente -->
    <div class="dashboard-section">
        <h2>Activité récente</h2>
        <div class="activity-list">
            @php
                $recentLogs = App\Services\ActivityLogService::getRecentLogs(10);
            @endphp
            @forelse($recentLogs as $log)
                <div class="activity-item">
                    <div class="activity-icon">
                        @switch($log->action)
                            @case('login')
                                🟢
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
                            @case('account_request_rejected')
                                ❌
                                @break
                            @default
                                📝
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
                </div>
            @empty
                <div class="activity-empty">
                    Aucune activité récente
                </div>
            @endforelse
        </div>
    </div>

    <!-- Système -->
    <div class="dashboard-section">
        <h2>Informations système</h2>
        <div class="system-info">
            <div class="info-item">
                <div class="info-label">Version Laravel</div>
                <div class="info-value">{{ app()->version() }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Environnement</div>
                <div class="info-value">{{ app()->environment() }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Version PHP</div>
                <div class="info-value">{{ PHP_VERSION }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Fuseau horaire</div>
                <div class="info-value">{{ config('app.timezone') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
}

.dashboard-header {
    margin-bottom: 40px;
}

.dashboard-header h1 {
    color: #2d3748;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 8px;
}

.dashboard-subtitle {
    color: #718096;
    font-size: 16px;
    margin: 0;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.stat-icon.users {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.stat-icon.requests {
    background: linear-gradient(135deg, #f093fb, #f5576c);
}

.stat-icon.resources {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
}

.stat-icon.reservations {
    background: linear-gradient(135deg, #43e97b, #38f9d7);
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #2d3748;
    line-height: 1;
    margin-bottom: 4px;
}

.stat-label {
    color: #718096;
    font-size: 14px;
    font-weight: 500;
}

/* Dashboard Sections */
.dashboard-section {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.dashboard-section h2 {
    color: #2d3748;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
}

.action-card {
    display: block;
    padding: 20px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
}

.action-card:hover {
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}

.action-icon {
    font-size: 32px;
    margin-bottom: 12px;
}

.action-title {
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 4px;
}

.action-description {
    font-size: 14px;
    color: #718096;
}

/* Activity List */
.activity-list {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f7fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-text {
    color: #2d3748;
    font-size: 14px;
    margin-bottom: 4px;
}

.activity-meta {
    color: #718096;
    font-size: 12px;
}

.activity-empty {
    text-align: center;
    color: #718096;
    padding: 40px;
    font-style: italic;
}

/* System Info */
.system-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: #f7fafc;
    border-radius: 6px;
}

.info-label {
    color: #718096;
    font-size: 14px;
    font-weight: 500;
}

.info-value {
    color: #2d3748;
    font-size: 14px;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 0 15px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .system-info {
        grid-template-columns: 1fr;
    }
    
    .dashboard-header h1 {
        font-size: 28px;
    }
}
</style>
@endpush
