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
}

.users-management {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 25px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.page-header h1 {
    color: var(--dark);
    margin: 0;
    font-size: 1.8rem;
    font-weight: 600;
}

.page-header h1 i {
    margin-right: 12px;
    color: var(--primary);
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    font-size: 14px;
}

.btn i {
    margin-right: 8px;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--secondary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(25, 69, 105, 0.3);
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    font-weight: 500;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-left: 4px solid var(--success);
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border-left: 4px solid var(--danger);
}

.alert i {
    margin-right: 10px;
}

.filters-section {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    padding: 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.search-container {
    flex: 1;
}

.search-box {
    position: relative;
    max-width: 400px;
}

.search-box i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
}

.search-box input {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 2px solid var(--light-gray);
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.search-box input:focus {
    outline: none;
    border-color: var(--primary);
}

.filter-container {
    min-width: 200px;
}

.filter-select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--light-gray);
    border-radius: 8px;
    font-size: 14px;
    background: white;
    cursor: pointer;
    transition: border-color 0.3s ease;
}

.filter-select:focus {
    outline: none;
    border-color: var(--primary);
}

.table-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table th {
    background: var(--primary);
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    font-size: 14px;
}

.users-table td {
    padding: 15px;
    border-bottom: 1px solid var(--light-gray);
    font-size: 14px;
}

.users-table tr:hover {
    background: var(--light);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-avatar-small {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.role-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.role-admin {
    background: #dc3545;
    color: white;
}

.role-tech-manager {
    background: var(--warning);
    color: var(--dark);
}

.role-user {
    background: var(--info);
    color: white;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-badge.active {
    background: var(--success);
    color: white;
}

.status-badge.inactive {
    background: var(--gray);
    color: white;
}

.actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

.action-btn {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 12px;
    color: white;
}

.btn-view {
    background: var(--info);
}

.btn-view:hover {
    background: #138496;
    transform: translateY(-1px);
}

.btn-edit {
    background: var(--warning);
    color: var(--dark);
}

.btn-edit:hover {
    background: #e0a800;
    transform: translateY(-1px);
}

.btn-deactivate {
    background: var(--gray);
}

.btn-deactivate:hover {
    background: #5a6268;
    transform: translateY(-1px);
}

.btn-activate {
    background: var(--success);
}

.btn-activate:hover {
    background: #218838;
    transform: translateY(-1px);
}

.btn-delete {
    background: var(--danger);
}

.btn-delete:hover {
    background: #c82333;
    transform: translateY(-1px);
}

.action-form {
    margin: 0;
    padding: 0;
}

.no-results {
    text-align: center;
    padding: 40px;
    color: var(--gray);
}

.no-results i {
    font-size: 3rem;
    margin-bottom: 15px;
    display: block;
    opacity: 0.5;
}

@media (max-width: 768px) {
    .filters-section {
        flex-direction: column;
    }
    
    .search-box {
        max-width: 100%;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .page-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
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
