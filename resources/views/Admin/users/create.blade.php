@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@section('content')

<style>
    /* --- Variables de couleurs --- */
    :root {
        --primary-slate: #434861;   /* Bleu Ardoise */
        --accent-orange: #e67e22;   /* Orange Accent */
        --bg-perle: #f3f4f6;        /* Gris Perle */
        --white: #ffffff;
        --text-dark: #2d3748;
        --text-light: #718096;
        --error-red: #e74c3c;
        --border-color: #e2e8f0;
    }

    /* --- Conteneur Principal --- */
    .admin-container {
        padding: 40px 20px;
        max-width: 900px;
        margin: 0 auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* --- Header --- */
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 15px;
    }

    .admin-header h1 {
        color: var(--primary-slate);
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }

    /* --- Alertes Erreurs --- */
    .alert-danger {
        background: #fff5f5;
        border-left: 4px solid var(--error-red);
        color: #c53030;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    /* --- Carte du Formulaire --- */
    .admin-card {
        background: var(--white);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
    }

    /* --- Grid du Formulaire --- */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-slate);
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .required {
        color: var(--accent-orange);
    }

    /* --- Inputs & Selects --- */
    .form-input, .form-select {
        padding: 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #fcfcfc;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: var(--accent-orange);
        box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
        background-color: var(--white);
    }

    .form-error {
        color: var(--error-red);
        font-size: 0.8rem;
        margin-top: 5px;
        font-weight: 500;
    }

    /* --- Boutons --- */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    .btn {
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
    }

    .btn-primary {
        background: var(--primary-slate);
        color: var(--white);
        border: none;
    }

    .btn-primary:hover {
        background: #d35400;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(230, 126, 34, 0.3);
    }

    .btn-outline {
        background: transparent;
        color: var(--text-light);
        border: 2px solid var(--border-color);
    }

    .btn-outline:hover {
        background: var(--bg-perle);
        color: var(--primary-slate);
        border-color: var(--primary-slate);
    }
</style>

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

