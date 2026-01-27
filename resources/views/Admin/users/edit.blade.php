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

