@extends('layouts.guest')

@section('title', 'Création de Compte Utilisateur')

@section('content')
<div class="register-container">
    <div class="register-card">
        <h2>Création de Compte Utilisateur Interne</h2>
        <p class="register-subtitle">Réservé aux ingénieurs, enseignants et doctorants</p>
        
        <form method="POST" action="{{ route('register.user') }}">
            @csrf
            
            <!-- Informations Personnelles -->
            <div class="form-section">
                <h3>👤 Informations Personnelles</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nom complet *</label>
                        <input type="text" id="name" name="name" 
                               value="{{ old('name') }}" required
                               placeholder="Jean Dupont">
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email professionnel *</label>
                        <input type="email" id="email" name="email" 
                               value="{{ old('email') }}" required
                               placeholder="jean.dupont@entreprise.com">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Téléphone professionnel</label>
                        <input type="tel" id="phone" name="phone" 
                               value="{{ old('phone') }}" 
                               placeholder="06XXXXXXXX">
                        @error('phone')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="department">Département/Service *</label>
                        <select id="department" name="department" required>
                            <option value="">-- Sélectionnez --</option>
                            <option value="engineering" {{ old('department') == 'engineering' ? 'selected' : '' }}>
                                Ingénierie
                            </option>
                            <option value="research" {{ old('department') == 'research' ? 'selected' : '' }}>
                                Recherche & Développement
                            </option>
                            <option value="teaching" {{ old('department') == 'teaching' ? 'selected' : '' }}>
                                Enseignement
                            </option>
                            <option value="phd" {{ old('department') == 'phd' ? 'selected' : '' }}>
                                Doctorat
                            </option>
                            <option value="admin" {{ old('department') == 'admin' ? 'selected' : '' }}>
                                Administration
                            </option>
                        </select>
                        @error('department')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="position">Poste/Fonction *</label>
                    <input type="text" id="position" name="position" 
                           value="{{ old('position') }}" required
                           placeholder="Ingénieur Système">
                    @error('position')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <!-- Sécurité -->
            <div class="form-section">
                <h3>🔐 Sécurité du Compte</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Mot de passe *</label>
                        <input type="password" id="password" name="password" required>
                        <small>Minimum 8 caractères, incluant majuscules, minuscules et chiffres</small>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le mot de passe *</label>
                        <input type="password" id="password_confirmation" 
                               name="password_confirmation" required>
                        @error('password_confirmation')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Informations Supplémentaires -->
            <div class="form-section">
                <h3>📋 Informations Supplémentaires</h3>
                
                <div class="form-group">
                    <label for="manager_name">Nom du responsable hiérarchique</label>
                    <input type="text" id="manager_name" name="manager_name" 
                           value="{{ old('manager_name') }}" 
                           placeholder="Marie Martin">
                    @error('manager_name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="manager_email">Email du responsable</label>
                    <input type="email" id="manager_email" name="manager_email" 
                           value="{{ old('manager_email') }}" 
                           placeholder="marie.martin@entreprise.com">
                    @error('manager_email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="justification">Justification de l'accès *</label>
                    <textarea id="justification" name="justification" rows="4" required
                              placeholder="Expliquez pourquoi vous avez besoin d'accéder au système Data Center...">{{ old('justification') }}</textarea>
                    <small>Décrivez vos besoins en termes de ressources informatiques</small>
                    @error('justification')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <!-- Conditions -->
            <div class="form-section">
                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" value="1" required>
                        <span>Je certifie que les informations fournies sont exactes *</span>
                    </label>
                    @error('terms')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="data_processing" value="1" required>
                        <span>J'accepte le traitement de mes données selon la politique interne *</span>
                    </label>
                    @error('data_processing')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-full">
                🚀 Créer mon compte
            </button>
        </form>
        
        <div class="register-links">
            <a href="{{ route('login') }}">Déjà un compte ? Se connecter</a>
            <a href="{{ route('register') }}">Pas utilisateur interne ? Faire une demande</a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.register-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.register-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 40px;
    max-width: 600px;
    width: 100%;
}

.register-card h2 {
    color: #2d3748;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
    text-align: center;
}

.register-subtitle {
    color: #718096;
    font-size: 16px;
    text-align: center;
    margin-bottom: 30px;
}

.form-section {
    margin-bottom: 30px;
}

.form-section h3 {
    color: #4a5568;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e2e8f0;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #4a5568;
    font-size: 14px;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background-color: white;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.form-group small {
    display: block;
    margin-top: 6px;
    color: #718096;
    font-size: 12px;
}

.checkbox-group {
    margin-bottom: 15px;
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    cursor: pointer;
    font-size: 14px;
    color: #4a5568;
}

.checkbox-label input[type="checkbox"] {
    margin-top: 2px;
    flex-shrink: 0;
}

.error {
    display: block;
    margin-top: 6px;
    color: #e53e3e;
    font-size: 12px;
    font-weight: 500;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    width: 100%;
    margin-top: 20px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.btn-full {
    width: 100%;
}

.register-links {
    margin-top: 30px;
    text-align: center;
    display: flex;
    justify-content: space-between;
    gap: 15px;
}

.register-links a {
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.register-links a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 768px) {
    .register-container {
        padding: 20px 15px;
    }
    
    .register-card {
        padding: 30px 20px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .register-links {
        flex-direction: column;
        gap: 10px;
    }
}
</style>
@endpush
