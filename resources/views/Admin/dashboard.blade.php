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


