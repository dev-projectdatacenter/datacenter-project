@extends('layouts.admin')

@section('title', 'Modifier un utilisateur')

@section('content')

<style>
/* --- VARIABLES --- */
:root {
    --primary: #434861;        /* Bleu Ardoise */
    --accent: #cf884aff;         /* Orange Accent */
    --bg-light: #f3f4f6;       /* Gris Perle */
    --white: #ffffff;
    --danger: #a82f21ff;
    --warning: #f1c40f;
    --success: #27ae60;
    --text-dark: #2d3748;
    --text-gray: #718096;
    --border: #edf2f7;
}

/* --- STRUCTURE --- */
.admin-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 30px 20px;
    font-family: 'Inter', system-ui, sans-serif;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.admin-header h1 {
    color: var(--primary);
    font-size: 1.8rem;
    font-weight: 800;
}

/* --- ALERTES --- */
.alert-danger {
    background: #fff5f5;
    border-left: 5px solid var(--danger);
    color: #c53030;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

/* --- CARTES & SECTIONS --- */
.admin-card {
    background: var(--white);
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    margin-bottom: 25px;
    border: 1px solid var(--border);
}

.form-section {
    margin-bottom: 35px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border);
}

.form-section h3 {
    color: var(--primary);
    margin-bottom: 10px;
    font-size: 1.2rem;
}

.section-description {
    color: var(--text-gray);
    font-size: 0.9rem;
    margin-bottom: 20px;
}

/* --- PROFIL HEADER (L'encart en haut du formulaire) --- */
.user-info-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 40px;
    padding: 20px;
    background: var(--bg-light);
    border-radius: 10px;
}

.avatar-circle {
    width: 70px;
    height: 70px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(67, 72, 97, 0.3);
}

.user-details h2 { margin: 0; color: var(--primary); }
.user-details p { margin: 5px 0; color: var(--text-gray); }

.user-badges {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

/* --- BADGES --- */
.role-badge, .status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
}

.role-admin { background: #fee2e2; color: #991b1b; }
.role-tech_manager { background: #fef3c7; color: #92400e; }
.role-user { background: #e0f2fe; color: #0369a1; }

.status-badge.active { background: var(--success); color: white; }
.status-badge.inactive { background: var(--text-gray); color: white; }

/* --- FORMULAIRE --- */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group { display: flex; flex-direction: column; margin-bottom: 15px; }
.form-label { font-weight: 600; color: var(--primary); margin-bottom: 8px; }
.required { color: var(--accent); }

.form-input, .form-select {
    padding: 12px;
    border: 2px solid var(--border);
    border-radius: 8px;
    transition: 0.3s;
}

.form-input:focus, .form-select:focus {
    border-color: var(--accent);
    outline: none;
    box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
}

/* --- CHECKBOX CUSTOM --- */
.checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-weight: 600;
    color: var(--primary);
}

.form-help { color: var(--text-gray); font-size: 0.8rem; margin-top: 5px; }

/* --- BOUTONS --- */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 20px;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.3s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-primary { background: var(--accent); color: white; border: none; }
.btn-primary:hover { background: #c06a31ff; transform: translateY(-2px); }

.btn-outline { background: transparent; border: 2px solid var(--border); color: var(--text-gray); }
.btn-outline:hover { border-color: var(--primary); color: var(--primary); }

/* --- ZONE DE DANGER --- */
.danger-zone {
    border: 2px solid #feb2b2;
    background: #fff5f5;
}

.danger-zone h3 { color: #a01f1fff; margin-top: 0; }
.danger-actions { display: flex; gap: 15px; margin-top: 20px; }

.btn-danger { background: var(--danger); color: white; border: none; }
.btn-warning { background: #cf884aff; color: white; border: none; }

@media (max-width: 768px) {
    .form-grid { grid-template-columns: 1fr; }
    .admin-header { flex-direction: column; gap: 15px; }
}
</style>

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

