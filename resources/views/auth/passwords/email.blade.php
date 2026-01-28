@extends('layouts.guest')

@section('title', 'Mot de passe oublié')

@push('styles')
<style>
    .auth-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #f3f4f6;
        padding: 1rem;
    }
    .auth-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        padding: 3rem;
        max-width: 450px;
        width: 100%;
        text-align: center;
    }
    .auth-card h1 {
        font-size: 2rem; /* 32px */
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.75rem;
    }
    .auth-card p {
        color: #6b7280;
        font-size: 1rem;
        margin-bottom: 2.5rem;
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
    .form-group input:focus {
        outline: none;
        border-color: #434861;
        box-shadow: 0 0 0 3px rgba(67, 72, 97, 0.1);
    }
    .btn-primary {
        width: 100%;
        padding: 0.85rem 1rem;
        background-color: #434861;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: #2d3748;
    }
    .auth-links {
        margin-top: 2rem;
    }
    .auth-link {
        color: #434861;
        font-weight: 500;
        text-decoration: none;
    }
    .auth-link:hover {
        text-decoration: underline;
    }
    .alert-success {
        background-color: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1>Mot de passe oublié ?</h1>
        <p>Pas de souci. Indiquez-nous votre email et nous vous enverrons un lien pour le réinitialiser.</p>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="error" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Envoyer le lien de réinitialisation
            </button>
        </form>

        <div class="auth-links">
            <a href="{{ route('login') }}" class="auth-link">
                Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection
