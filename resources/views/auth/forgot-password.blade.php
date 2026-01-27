@extends('layouts.app')

@section('styles')
    <!-- CSS spécifique à cette page -->
    <link rel="stylesheet" href="{{ asset('css/appcss') }}">
@endsection

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
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        placeholder="votre.email@exemple.com" autocomplete="email">
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

