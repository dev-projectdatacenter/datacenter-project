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
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div class="form-group">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmation du mot de passe -->
                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror" required
                        autocomplete="new-password">
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

