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

@push('styles')
<style>
.admin-container {
    padding: 20px;
    max-width: 800px;
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

.admin-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

.user-form {
    max-width: 100%;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
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
    
    .admin-card {
        padding: 20px;
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
}

@media (max-width: 480px) {
    .admin-card {
        padding: 15px;
    }
    
    .form-input,
    .form-select {
        padding: 10px 14px;
    }
}
</style>
@endpush
