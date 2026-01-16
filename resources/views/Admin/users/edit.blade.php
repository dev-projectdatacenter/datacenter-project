@extends('layouts.admin')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Modifier l'utilisateur</h1>
        <div class="header-actions">
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline">
                Voir les détails
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                ← Retour à la liste
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-card">
        <div class="user-info-header">
            <div class="user-avatar">
                <div class="avatar-circle">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
            </div>
            <div class="user-details">
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
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

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="user-form">
            @csrf
            @method('PATCH')
            
            <div class="form-section">
                <h3>Informations générales</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nom complet <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-input" 
                            value="{{ old('name', $user->name) }}"
                            required
                            placeholder="Entrez le nom complet"
                        >
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            Email <span class="required">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            value="{{ old('email', $user->email) }}"
                            required
                            placeholder="exemple@email.com"
                        >
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">
                            Rôle <span class="required">*</span>
                        </label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="">Sélectionner un rôle</option>
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                                Utilisateur interne
                            </option>
                            <option value="tech_manager" {{ old('role', $user->role) == 'tech_manager' ? 'selected' : '' }}>
                                Responsable technique
                            </option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                Administrateur
                            </option>
                        </select>
                        @error('role')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input 
                                    type="checkbox" 
                                    name="is_active" 
                                    value="1"
                                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                >
                                <span class="checkmark"></span>
                                Compte actif
                            </label>
                            <small class="form-help">
                                Cochez cette case pour maintenir le compte actif
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Changer le mot de passe</h3>
                <p class="section-description">
                    Laissez ces champs vides pour conserver le mot de passe actuel
                </p>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="password" class="form-label">
                            Nouveau mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Minimum 8 caractères"
                        >
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            Confirmer le nouveau mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="form-input" 
                            placeholder="Répétez le mot de passe"
                        >
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    Mettre à jour l'utilisateur
                </button>
            </div>
        </form>
    </div>

    @if($user->id !== auth()->id())
        <div class="admin-card danger-zone">
            <h3>Zone de danger</h3>
            <p>Actions irréversibles sur cet utilisateur</p>
            <div class="danger-actions">
                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="danger-form">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-warning">
                        {{ $user->is_active ? 'Désactiver' : 'Activer' }} le compte
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="danger-form"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet utilisateur ? Cette action est irréversible.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        Supprimer l'utilisateur
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.admin-container {
    padding: 20px;
    max-width: 900px;
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
    margin-bottom: 20px;
}

.user-info-header {
    display: flex;
    align-items: center;
    gap: 20px;
    padding-bottom: 25px;
    border-bottom: 1px solid #e2e8f0;
    margin-bottom: 25px;
}

.user-avatar {
    flex-shrink: 0;
}

.avatar-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 18px;
    text-transform: uppercase;
}

.user-details h2 {
    margin: 0 0 5px 0;
    color: #2d3748;
    font-size: 20px;
    font-weight: 600;
}

.user-details p {
    margin: 0 0 10px 0;
    color: #718096;
    font-size: 14px;
}

.user-badges {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.role-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
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
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
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

.user-form {
    max-width: 100%;
}

.form-section {
    margin-bottom: 30px;
}

.form-section h3 {
    color: #2d3748;
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 15px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid #e2e8f0;
}

.section-description {
    color: #718096;
    font-size: 14px;
    margin: 0 0 20px 0;
    font-style: italic;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 8px;
    font-size: 14px;
}

.required {
    color: #e53e3e;
}

.form-input,
.form-select {
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
}

.form-input::placeholder {
    color: #a0aec0;
}

.form-error {
    color: #e53e3e;
    font-size: 12px;
    margin-top: 5px;
}

.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-weight: 500;
    color: #4a5568;
    position: relative;
    padding-left: 25px;
}

.checkbox-label input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.checkmark {
    position: absolute;
    left: 0;
    top: 0;
    height: 18px;
    width: 18px;
    background-color: #e2e8f0;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.checkbox-label:hover input ~ .checkmark {
    background-color: #cbd5e0;
}

.checkbox-label input:checked ~ .checkmark {
    background-color: #3182ce;
}

.checkmark:after {
    content: "";
    position: absolute;
    display: none;
    left: 6px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-label input:checked ~ .checkmark:after {
    display: block;
}

.form-help {
    color: #718096;
    font-size: 12px;
    margin-top: 5px;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
    margin-top: 30px;
}

.danger-zone {
    border: 2px solid #feb2b2;
    background-color: #fffaf0;
}

.danger-zone h3 {
    color: #c53030;
    margin-bottom: 10px;
}

.danger-zone p {
    color: #742a2a;
    margin-bottom: 20px;
}

.danger-actions {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.danger-form {
    display: inline;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-danger {
    background-color: #fed7d7;
    color: #742a2a;
    border: 1px solid #feb2b2;
}

.alert-danger ul {
    margin: 0;
    padding-left: 20px;
}

.alert-danger li {
    margin-bottom: 5px;
}

.alert-danger li:last-child {
    margin-bottom: 0;
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
    
    .user-info-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .user-badges {
        justify-content: center;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
    
    .danger-actions {
        flex-direction: column;
    }
    
    .danger-actions .btn {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .admin-card {
        padding: 15px;
    }
    
    .form-input,
    .form-select {
        padding: 10px 14px;
    }
    
    .avatar-circle {
        width: 50px;
        height: 50px;
        font-size: 16px;
    }
}
</style>
@endpush
