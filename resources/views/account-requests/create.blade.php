@extends('layouts.guest')

@section('title', 'Demande de compte')

@section('content')
<div class="request-container">
    <div class="request-card">
        <div class="request-header">
            <h1>📋 Demande de compte</h1>
            <p>Remplissez ce formulaire pour demander un accès au système de gestion du Data Center</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                ❌ {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('account.request.store') }}" class="request-form">
            @csrf
            
            <div class="form-section">
                <h3>👤 Informations personnelles</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nom complet *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               placeholder="Jean Dupont">
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email professionnel *</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               placeholder="jean.dupont@entreprise.com">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               placeholder="+212600000000">
                        @error('phone')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>🎯 Demande d'accès</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="role_requested">Type de compte demandé *</label>
                        <select id="role_requested" name="role_requested" required>
                            <option value="">-- Sélectionnez le type de compte --</option>
                            <option value="user" {{ old('role_requested') == 'user' ? 'selected' : '' }}>
                                👤 Utilisateur interne (Ingénieur/Enseignant/Doctorant)
                            </option>
                            <option value="tech_manager" {{ old('role_requested') == 'tech_manager' ? 'selected' : '' }}>
                                🔧 Responsable technique de ressources
                            </option>
                            <option value="admin" {{ old('role_requested') == 'admin' ? 'selected' : '' }}>
                                👑 Administrateur du système
                            </option>
                        </select>
                        @error('role_requested')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    📤 Envoyer la demande
                </button>
            </div>
        </form>

        <div class="request-info">
            <div class="info-card">
                <h4>ℹ️ Informations importantes</h4>
                <ul>
                    <li>Les demandes sont traitées par les administrateurs</li>
                    <li>Vous recevrez une réponse par email dans les 24-48h</li>
                    <li>Les comptes administrateurs nécessitent une justification</li>
                    <li>En cas d'approbation, vous recevrez vos identifiants par email</li>
                </ul>
            </div>
        </div>

        <div class="request-links">
            <a href="{{ route('login') }}" class="link-back">
                🔙 Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')

@endpush
