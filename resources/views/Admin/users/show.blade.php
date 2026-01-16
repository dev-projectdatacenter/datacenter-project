@extends('layouts.admin')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Détails de l'utilisateur</h1>
        <div class="header-actions">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                Modifier
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                ← Retour à la liste
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="user-profile">
            <div class="user-avatar">
                <div class="avatar-circle">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
            </div>
            <div class="user-info">
                <h2>{{ $user->name }}</h2>
                <p class="user-email">{{ $user->email }}</p>
                <div class="user-badges">
                    <span class="role-badge role-{{ $user->role }}">
                        {{ __('roles.' . $user->role) }}
                    </span>
                    <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="user-details-grid">
            <div class="detail-section">
                <h3>Informations générales</h3>
                <dl class="detail-list">
                    <div class="detail-item">
                        <dt>ID</dt>
                        <dd>#{{ $user->id }}</dd>
                    </div>
                    <div class="detail-item">
                        <dt>Nom complet</dt>
                        <dd>{{ $user->name }}</dd>
                    </div>
                    <div class="detail-item">
                        <dt>Email</dt>
                        <dd>{{ $user->email }}</dd>
                    </div>
                    <div class="detail-item">
                        <dt>Rôle</dt>
                        <dd>
                            <span class="role-badge role-{{ $user->role }}">
                                {{ __('roles.' . $user->role) }}
                            </span>
                        </dd>
                    </div>
                    <div class="detail-item">
                        <dt>Statut</dt>
                        <dd>
                            <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="detail-section">
                <h3>Informations temporelles</h3>
                <dl class="detail-list">
                    <div class="detail-item">
                        <dt>Date de création</dt>
                        <dd>{{ $user->created_at->format('d/m/Y à H:i') }}</dd>
                    </div>
                    <div class="detail-item">
                        <dt>Dernière mise à jour</dt>
                        <dd>{{ $user->updated_at->format('d/m/Y à H:i') }}</dd>
                    </div>
                    <div class="detail-item">
                        <dt>Email vérifié</dt>
                        <dd>
                            @if($user->email_verified_at)
                                <span class="badge-success">Oui ({{ $user->email_verified_at->format('d/m/Y') }})</span>
                            @else
                                <span class="badge-warning">Non</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        @if($user->id !== auth()->id())
            <div class="user-actions">
                <h3>Actions rapides</h3>
                <div class="actions-grid">
                    <a href="{{ route('admin.users.edit', $user) }}" class="action-card">
                        <div class="action-icon">✏️</div>
                        <div class="action-content">
                            <h4>Modifier</h4>
                            <p>Éditer les informations de l'utilisateur</p>
                        </div>
                    </a>

                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="action-form">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="action-card">
                            <div class="action-icon">{{ $user->is_active ? '🔒' : '🔓' }}</div>
                            <div class="action-content">
                                <h4>{{ $user->is_active ? 'Désactiver' : 'Activer' }}</h4>
                                <p>{{ $user->is_active ? 'Désactiver le compte' : 'Activer le compte' }}</p>
                            </div>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="action-form"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet utilisateur ? Cette action est irréversible.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-card danger">
                            <div class="action-icon">🗑️</div>
                            <div class="action-content">
                                <h4>Supprimer</h4>
                                <p>Supprimer définitivement l'utilisateur</p>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.admin-container {
    padding: 20px;
    max-width: 1000px;
    margin: 0 auto;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.admin-header h1 {
    color: #2d3748;
    font-size: 28px;
    font-weight: 700;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.admin-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 25px;
    padding-bottom: 30px;
    border-bottom: 2px solid #e2e8f0;
    margin-bottom: 30px;
}

.user-avatar {
    flex-shrink: 0;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 24px;
    text-transform: uppercase;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.user-info h2 {
    margin: 0 0 8px 0;
    color: #2d3748;
    font-size: 24px;
    font-weight: 700;
}

.user-email {
    margin: 0 0 15px 0;
    color: #718096;
    font-size: 16px;
}

.user-badges {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.role-badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
}

.role-admin {
    background-color: #fed7d7;
    color: #742a2a;
}

.role-tech_manager {
    background-color: #feebc8;
    color: #7c2d12;
}

.role-user {
    background-color: #bee3f8;
    color: #2a4e7c;
}

.role-guest {
    background-color: #e2e8f0;
    color: #4a5568;
}

.status-badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.status-badge.active {
    background-color: #c6f6d5;
    color: #22543d;
}

.status-badge.inactive {
    background-color: #fed7d7;
    color: #742a2a;
}

.user-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
}

.detail-section h3 {
    color: #2d3748;
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 20px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid #e2e8f0;
}

.detail-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f7fafc;
}

.detail-item dt {
    font-weight: 600;
    color: #4a5568;
    font-size: 14px;
}

.detail-item dd {
    margin: 0;
    color: #2d3748;
    font-size: 14px;
    text-align: right;
}

.badge-success {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    background-color: #c6f6d5;
    color: #22543d;
    font-size: 12px;
    font-weight: 600;
}

.badge-warning {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    background-color: #feebc8;
    color: #7c2d12;
    font-size: 12px;
    font-weight: 600;
}

.user-actions {
    border-top: 2px solid #e2e8f0;
    padding-top: 30px;
}

.user-actions h3 {
    color: #2d3748;
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 20px 0;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.action-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    background: white;
}

.action-card:hover {
    border-color: #3182ce;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(49, 130, 206, 0.15);
}

.action-card.danger:hover {
    border-color: #e53e3e;
    box-shadow: 0 4px 12px rgba(229, 62, 62, 0.15);
}

.action-card.danger {
    color: #e53e3e;
}

.action-form {
    display: block;
}

.action-form button {
    width: 100%;
    text-align: left;
    border: none;
    background: none;
    cursor: pointer;
    font-family: inherit;
}

.action-icon {
    font-size: 24px;
    flex-shrink: 0;
}

.action-content h4 {
    margin: 0 0 5px 0;
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
}

.action-content p {
    margin: 0;
    font-size: 13px;
    color: #718096;
}

.action-card.danger .action-content h4 {
    color: #e53e3e;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-container {
        padding: 15px;
    }
    
    .admin-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .admin-header h1 {
        text-align: center;
        margin-bottom: 15px;
    }
    
    .header-actions {
        justify-content: center;
    }
    
    .admin-card {
        padding: 20px;
    }
    
    .user-profile {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .avatar-circle {
        width: 70px;
        height: 70px;
        font-size: 20px;
    }
    
    .user-badges {
        justify-content: center;
    }
    
    .user-details-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .detail-item dd {
        text-align: left;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .admin-card {
        padding: 15px;
    }
    
    .avatar-circle {
        width: 60px;
        height: 60px;
        font-size: 18px;
    }
    
    .user-info h2 {
        font-size: 20px;
    }
    
    .action-card {
        padding: 15px;
    }
    
    .action-icon {
        font-size: 20px;
    }
}
</style>
@endpush
