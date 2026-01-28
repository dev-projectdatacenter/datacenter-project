@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="users-management">
    <div class="page-header">
        <h1><i class="fas fa-users"></i> Gestion des utilisateurs</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvel utilisateur
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="filters-section">
        <div class="search-container">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="userSearch" placeholder="Rechercher un utilisateur...">
            </div>
        </div>
        <div class="filter-container">
            <select id="roleFilter" class="filter-select">
                <option value="">Tous les rôles</option>
                @if(isset($roles) && (is_array($roles) || is_object($roles)))
                    @foreach($roles as $id => $name)
                        <option value="{{ $id }}">{{ ucfirst($name) }}</option>
                    @endforeach
                @else
                    <option value="1">Admin</option>
                    <option value="2">Tech Manager</option>
                    <option value="3">User</option>
                @endif
            </select>
        </div>
    </div>

    <div class="table-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Date d'inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    @php
                        $roleName = $user->role ? $user->role->name : 'Aucun rôle';
                        $roleId = $user->role ? $user->role->id : null;
                    @endphp
                    <tr data-role-id="{{ $roleId }}">
                        <td>#{{ $user->id }}</td>
                        <td>
                            <div class="user-info">
                                <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=194569&color=fff&size=40' }}" alt="{{ $user->name }}" class="user-avatar-small">
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-badge role-{{ strtolower(str_replace(' ', '-', $roleName)) }}">
                                {{ $roleName }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.users.show', $user) }}" class="action-btn btn-view" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="action-btn btn-edit" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="action-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn {{ $user->is_active ? 'btn-deactivate' : 'btn-activate' }}" 
                                                title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                            <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="action-form" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="no-results">
                            <i class="fas fa-user-slash"></i>
                            <p>Aucun utilisateur trouvé</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* --- VARIABLES GLOBALES --- */
:root {
    --primary-slate: #434861;   /* Bleu Ardoise */
    --accent-orange: #e39958ff;   /* Orange Accent */
    --bg-light: #f3f4f6;        /* Gris Perle / Fond */
    --white: #ffffff;
    --success: #27ae60;
    --danger: #e74c3c;
    --warning: #f1c40f;
    --info: #3498db;
    --text-dark: #2d3748;
    --text-gray: #718096;
    --border-color: #edf2f7;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* --- STRUCTURE GÉNÉRALE --- */
.users-management {
    max-width: 1400px;
    margin: 0 auto;
    padding: 30px 20px;
    background-color: var(--bg-light);
    min-height: 100vh;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* --- ESPACEMENTS DES BLOCS (Margin Bottom) --- */
.page-header, 
.filters-section, 
.table-container,
.admin-card {
    margin-bottom: 24px !important; /* Espace crucial entre chaque section */
    box-shadow: var(--shadow);
}

/* --- HEADER --- */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 25px 30px;
    background: var(--white);
    border-radius: 12px;
    border-left: 6px solid var(--accent-orange);
}

.page-header h1 {
    color: var(--primary-slate);
    margin: 0;
    font-size: 1.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
}

/* --- FILTRES & RECHERCHE --- */
.filters-section {
    display: flex;
    gap: 20px;
    padding: 20px 30px;
    background: var(--white);
    border-radius: 12px;
    align-items: center;
}

.search-box {
    flex: 1;
    position: relative;
    max-width: 450px;
}

.search-box input {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.search-box input:focus {
    border-color: var(--accent-orange);
    outline: none;
    box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
}

.filter-select {
    padding: 12px 15px;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    min-width: 200px;
    cursor: pointer;
}

/* --- TABLEAU --- */
.table-container {
    background: var(--white);
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table th {
    background: var(--primary-slate);
    color: var(--white);
    padding: 16px 20px;
    text-align: left;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.users-table td {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-dark);
    vertical-align: middle;
}

.users-table tr:hover {
    background-color: #fdfaf7; /* Rappel orange très léger */
}

/* --- BOUTONS --- */
.btn {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    font-size: 0.9rem;
}

.btn-primary {
    background: var(--accent-orange);
    color: white;
}

.btn-primary:hover {
    background: #bd6f3bff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(230, 126, 34, 0.2);
}

/* --- BADGES (Rôles & Statuts) --- */
.role-badge, .status-badge {
    padding: 6px 12px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 700;
    display: inline-block;
}

.role-admin { background: #fee2e2; color: #991b1b; }
.role-tech-manager { background: #fef3c7; color: #92400e; }
.role-user { background: #e0f2fe; color: #0369a1; }

.status-badge.active { background: #d1fae5; color: #065f46; }
.status-badge.inactive { background: #f3f4f6; color: #374151; }

/* --- ACTIONS (Boutons de ligne) --- */
.actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: 0.2s;
}

.btn-view { background: var(--primary-slate); }
.btn-edit { background: var(--accent-orange); }
.btn-delete { background: var(--danger); }

/* --- AVATARS --- */
.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar-small {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--border-color);
}

/* --- RESPONSIVE --- */
@media (max-width: 768px) {
    .page-header, .filters-section {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    .search-box {
        max-width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('userSearch');
    const roleFilter = document.getElementById('roleFilter');
    const tableRows = document.querySelectorAll('.users-table tbody tr');

    function filterUsers() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedRole = roleFilter.value;

        tableRows.forEach(row => {
            if (row.querySelector('.no-results')) {
                return; // Skip the "no results" row
            }

            const userName = row.querySelector('strong')?.textContent.toLowerCase() || '';
            const userEmail = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const rowRoleId = row.dataset.roleId;

            const matchesSearch = userName.includes(searchTerm) || userEmail.includes(searchTerm);
            const matchesRole = !selectedRole || rowRoleId === selectedRole;

            if (matchesSearch && matchesRole) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterUsers);
    roleFilter.addEventListener('change', filterUsers);
});
</script>
@endsection
