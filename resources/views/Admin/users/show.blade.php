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

