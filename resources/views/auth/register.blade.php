{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.guest')

@section('title', 'Inscription')

@section('content')
<div class="register-container">
    <div class="register-card">
        <h2>Demande de compte</h2>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" id="name" name="name" 
                       value="{{ old('name') }}" required>
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email">Email professionnel</label>
                <input type="email" id="email" name="email" 
                       value="{{ old('email') }}" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="phone">Téléphone (optionnel)</label>
                <input type="tel" id="phone" name="phone" 
                       value="{{ old('phone') }}" 
                       placeholder="06XXXXXXXX">
                @error('phone')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="role_requested">Type de compte demandé</label>
                <select id="role_requested" name="role_requested" required>
                    <option value="">-- Sélectionnez --</option>
                    <option value="USER" {{ old('role_requested') == 'USER' ? 'selected' : '' }}>
                        Utilisateur interne (Ingénieur/Enseignant/Doctorant)
                    </option>
                    <option value="TECH_MANAGER" {{ old('role_requested') == 'TECH_MANAGER' ? 'selected' : '' }}>
                        Responsable technique de ressources
                    </option>
                    <option value="INVITE" {{ old('role_requested') == 'INVITE' ? 'selected' : '' }}>
                        Invité (lecture seule)
                    </option>
                </select>
                <small>Les demandes de compte ADMIN doivent être faites directement par un administrateur existant.</small>
                @error('role_requested')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="message">Message de motivation</label>
                <textarea id="message" name="message" rows="4" 
                          placeholder="Expliquez brièvement pourquoi vous souhaitez accéder au système Data Center...">{{ old('message') }}</textarea>
                <small>Facultatif mais recommandé pour accélérer le traitement de votre demande.</small>
                @error('message')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Envoyer la demande</button>
        </form>
        
        <div class="register-links">
            <a href="{{ route('login') }}">Déjà un compte ? Se connecter</a>
        </div>
    </div>
</div>
@endsection