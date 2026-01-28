@extends('layouts.admin')

@section('title', 'Détails de l\'utilisateur')

@section('content')

<style>
/* --- VARIABLES --- */
:root {
    --primary: #434861;        /* Bleu Ardoise */
    --accent: #e67e22;         /* Orange Accent */
    --bg-light: #f3f4f6;       /* Gris Perle */
    --white: #ffffff;
    --danger: #e74c3c;
    --success: #27ae60;
    --warning: #f1c40f;
    --text-dark: #2d3748;
    --text-gray: #718096;
    --border: #edf2f7;
}

/* --- STRUCTURE --- */
.admin-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 30px 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.admin-header h1 {
    color: var(--primary);
    font-size: 1.8rem;
    font-weight: 800;
    margin: 0;
}

/* --- PROFIL D'EN-TÊTE --- */
.admin-card {
    background: var(--white);
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--border);
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 25px;
    padding-bottom: 30px;
    border-bottom: 2px solid var(--bg-light);
    margin-bottom: 30px;
}

.avatar-circle {
    width: 90px;
    height: 90px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    font-weight: 700;
    box-shadow: 0 4px 20px rgba(67, 72, 97, 0.2);
}

.user-info h2 { margin: 0; font-size: 1.75rem; color: var(--primary); }
.user-email { color: var(--accent); font-weight: 600; margin: 5px 0 15px 0; }

/* --- GRILLE DE DÉTAILS --- */
.user-details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
}

.detail-section h3 {
    font-size: 1.1rem;
    color: var(--primary);
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.detail-list { margin: 0; }
.detail-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid var(--bg-light);
}

.detail-item dt { color: var(--text-gray); font-weight: 500; }
.detail-item dd { color: var(--text-dark); font-weight: 700; margin: 0; }

/* --- BADGES --- */
.role-badge, .status-badge, .badge-success, .badge-warning {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
}

.role-admin { background: #fee2e2; color: #991b1b; }
.role-tech_manager { background: #fef3c7; color: #92400e; }
.role-user { background: #e0f2fe; color: #0369a1; }

.status-badge.active { background: var(--success); color: white; }
.status-badge.inactive { background: var(--text-gray); color: white; }
.badge-success { background: #d1fae5; color: #065f46; }
.badge-warning { background: #fff7ed; color: #9a3412; }

/* --- CARTES D'ACTIONS RAPIDES --- */
.user-actions {
    background: var(--bg-light);
    padding: 25px;
    border-radius: 12px;
}

.user-actions h3 { margin-top: 0; font-size: 1.1rem; color: var(--primary); }

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    margin-top: 15px;
}

.action-card {
    display: flex;
    align-items: center;
    gap: 15px;
    background: var(--white);
    padding: 15px;
    border-radius: 10px;
    text-decoration: none;
    border: 2px solid transparent;
    transition: 0.3s;
    cursor: pointer;
    text-align: left;
    width: 100%;
}

.action-card:hover {
    border-color: var(--accent);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.action-icon { font-size: 1.5rem; }
.action-content h4 { margin: 0; color: var(--primary); font-size: 1rem; }
.action-content p { margin: 2px 0 0 0; color: var(--text-gray); font-size: 0.85rem; }

.action-card.danger:hover { border-color: var(--danger); }
.action-card.danger .action-content h4 { color: var(--danger); }

/* --- BOUTONS --- */
.header-actions { display: flex; gap: 10px; }
.btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 700;
    text-decoration: none;
    transition: 0.3s;
}

.btn-primary { background: var(--accent); color: white; }
.btn-primary:hover { background: #d35400; }

.btn-outline { border: 2px solid var(--border); color: var(--primary); }
.btn-outline:hover { background: var(--bg-light); }

.action-form { margin: 0; padding: 0; border: none; }

@media (max-width: 768px) {
    .user-details-grid { grid-template-columns: 1fr; }
    .user-profile { flex-direction: column; text-align: center; }
    .admin-header { flex-direction: column; gap: 15px; }
}
</style>

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
                    <span class="role-badge role-{{ $user->role->name ?? '' }}">
                        {{ $user->role->name ?? 'N/A' }}
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
                            <span class="role-badge role-{{ $user->role->name ?? '' }}">
                                {{ $user->role->name ?? 'N/A' }}
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

