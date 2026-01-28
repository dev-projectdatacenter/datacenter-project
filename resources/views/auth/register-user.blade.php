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
