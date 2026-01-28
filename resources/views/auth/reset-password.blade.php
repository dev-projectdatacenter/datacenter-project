@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Réinitialiser le mot de passe</h1>
            <p>Choisissez votre nouveau mot de passe</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf
            
            <!-- Token caché -->
            <input type="hidden" name="token" value="{{ $token }}">
            
            <!-- Email -->
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    value="{{ old('email') }}" 
                    required 
                    autocomplete="email" 
                    autofocus
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nouveau mot de passe -->
            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    required 
                    autocomplete="new-password"
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-control @error('password_confirmation') is-invalid @enderror" 
                    required 
                    autocomplete="new-password"
                >
                @error('password_confirmation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bouton de réinitialisation -->
            <button type="submit" class="btn btn-primary btn-full">
                Réinitialiser le mot de passe
            </button>
        </form>

        <div class="auth-footer">
            <p>
                <a href="{{ route('login') }}" class="auth-link">🔙 Retour à la connexion</a>
                <a href="{{ route('register') }}" class="auth-link">📝 S'inscrire</a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
}

.auth-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    padding: 40px;
    width: 100%;
    max-width: 420px;
}

.auth-header {
    text-align: center;
    margin-bottom: 30px;
}

.auth-header h1 {
    color: #2d3748;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
}

.auth-header p {
    color: #718096;
    font-size: 16px;
    margin: 0;
}

.auth-form {
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #4a5568;
    font-weight: 600;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control.is-invalid {
    border-color: #e53e3e;
}

.error-message {
    display: block;
    color: #e53e3e;
    font-size: 14px;
    margin-top: 5px;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.btn-full {
    width: 100%;
}

.auth-footer {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.auth-footer p {
    margin: 8px 0;
    color: #718096;
    font-size: 14px;
}

.auth-footer a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}

.auth-footer a:hover {
    text-decoration: underline;
}

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-success {
    background-color: #f0fff4;
    border: 1px solid #9ae6b4;
    color: #22543d;
}

/* Responsive */
@media (max-width: 480px) {
    .auth-container {
        padding: 10px;
    }
    
    .auth-card {
        padding: 30px 20px;
    }
    
    .auth-header h1 {
        font-size: 24px;
    }
}
</style>
@endpush
