@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Créer un utilisateur</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
            ← Retour à la liste
        </a>
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
        <form method="POST" action="{{ route('admin.users.store') }}" class="user-form">
            @csrf
            
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
                        value="{{ old('name') }}"
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
                        value="{{ old('email') }}"
                        required
                        placeholder="exemple@email.com"
                    >
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        Mot de passe <span class="required">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        required
                        placeholder="Minimum 8 caractères"
                    >
                    @error('password')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        Confirmer le mot de passe <span class="required">*</span>
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-input" 
                        required
                        placeholder="Répétez le mot de passe"
                    >
                </div>

                <div class="form-group">
                    <label for="role_id" class="form-label">
                        Rôle <span class="required">*</span>
                    </label>
                    <select id="role_id" name="role_id" class="form-select" required>
                        <option value="">Sélectionner un rôle</option>
                        <option value="1" {{ old('role_id') == '1' ? 'selected' : '' }}>
                            Administrateur
                        </option>
                        <option value="2" {{ old('role_id') == '2' ? 'selected' : '' }}>
                            Responsable technique
                        </option>
                        <option value="3" {{ old('role_id') == '3' ? 'selected' : '' }}>
                            Utilisateur interne
                        </option>
                    </select>
                    @error('role_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">
                        Statut
                    </label>
                    <select id="status" name="status" class="form-select">
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                            Actif
                        </option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                            Inactif
                        </option>
                        <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>
                            Bloqué
                        </option>
                    </select>
                    @error('status')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

