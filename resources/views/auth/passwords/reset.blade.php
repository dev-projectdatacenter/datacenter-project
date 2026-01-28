@extends('layouts.guest')

@section('title', 'Réinitialiser le mot de passe')

@push('styles')
<style>
    .auth-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #4a5568; /* Fond violet/gris */
        padding: 1rem;
    }
    .auth-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        padding: 2.5rem;
        max-width: 450px;
        width: 100%;
    }
    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .auth-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1f2937;
    }
    .auth-header p {
        color: #6b7280;
        font-size: 1rem;
        margin-top: 0.5rem;
    }
    .alert-success {
        background-color: #e6fffa;
        color: #38a169;
        border: 1px solid #a7f3d0;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-group label {
        display: block;
        text-align: left;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-group input {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        width: 100%;
    }
    .form-group input[readonly] {
        background-color: #edf2f7;
        cursor: not-allowed;
    }
    .form-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    }
    .btn-primary {
        width: 100%;
        padding: 0.85rem 1rem;
        background: linear-gradient(to right, #8b5cf6, #6366f1);
        color: white;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .auth-footer {
        margin-top: 2rem;
        text-align: center;
        border-top: 1px solid #e5e7eb;
        padding-top: 1.5rem;
        display: flex;
        justify-content: space-between;
    }
    .auth-link {
        color: #6366f1;
        font-weight: 500;
        text-decoration: none;
    }
    .auth-link:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Réinitialiser le mot de passe</h1>
            <p>Choisissez votre nouveau mot de passe</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input id="email" type="email" name="email" value="{{ request()->email ?? old('email') }}" required readonly>
            </div>

            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary">
                Réinitialiser le mot de passe
            </button>
        </form>

        <div class="auth-footer">
            <a href="{{ route('login') }}" class="auth-link"><i class="fas fa-arrow-left"></i> Retour à la connexion</a>
            <a href="{{ route('register') }}" class="auth-link">S'inscrire <i class="fas fa-user-plus"></i></a>
        </div>
    </div>
</div>
@endsection
