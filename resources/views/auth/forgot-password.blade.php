@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>🔐 Mot de passe oublié</h1>
            <p>Entrez votre adresse email pour recevoir un lien de réinitialisation</p>
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

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required
                       placeholder="votre.email@exemple.com"
                       autocomplete="email">
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                📧 Envoyer le lien de réinitialisation
            </button>
        </form>

        <div class="auth-links">
            <a href="{{ route('login') }}" class="auth-link">
                🔙 Retour à la connexion
            </a>
            <a href="{{ route('register') }}" class="auth-link">
                📝 S'inscrire
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.auth-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 40px;
    max-width: 400px;
    width: 100%;
}

.auth-header {
    text-align: center;
    margin-bottom: 30px;
}

.auth-header h1 {
    color: #2d3748;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
}

.auth-header p {
    color: #718096;
    font-size: 16px;
    margin: 0;
}

.auth-form {
    margin-bottom: 30px;
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

.form-group input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background-color: white;
}

.form-group input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
    width: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.auth-links {
    text-align: center;
}

.auth-link {
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.auth-link:hover {
    text-decoration: underline;
}

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-success {
    background-color: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.alert-danger {
    background-color: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.error {
    display: block;
    margin-top: 6px;
    color: #e53e3e;
    font-size: 12px;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .auth-container {
        padding: 20px 15px;
    }
    
    .auth-card {
        padding: 30px 20px;
    }
}
</style>

