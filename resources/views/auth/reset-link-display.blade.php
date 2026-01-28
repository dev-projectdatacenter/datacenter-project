@extends('layouts.guest')

@section('title', 'Lien de réinitialisation')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>🔗 Lien de réinitialisation</h1>
            <p>Voici votre lien de réinitialisation de mot de passe</p>
        </div>

        <div class="reset-info">
            <div class="info-box">
                <h3>📧 Email concerné :</h3>
                <p class="email-display">{{ session('password_reset_email') }}</p>
            </div>

            <div class="info-box">
                <h3>🔑 Token de réinitialisation :</h3>
                <div class="token-display">
                    <code>{{ session('password_reset_token') }}</code>
                    <button onclick="copyToken()" class="btn-copy">📋 Copier</button>
                </div>
            </div>

            <div class="info-box">
                <h3>⏰ Valable jusqu'à :</h3>
                <p>{{ session('password_reset_expires') ? \Carbon\Carbon::parse(session('password_reset_expires'))->format('d/m/Y à H:i') : 'N/A' }}</p>
            </div>
        </div>

        <div class="reset-actions">
            <a href="{{ route('password.reset', session('password_reset_token')) }}" class="btn btn-primary">
                🔐 Réinitialiser mon mot de passe
            </a>
            
            <a href="{{ route('login') }}" class="btn btn-outline">
                🔙 Retour à la connexion
            </a>
        </div>

        <div class="instructions">
            <h4>📋 Instructions :</h4>
            <ol>
                <li>Cliquez sur le bouton "Réinitialiser mon mot de passe"</li>
                <li>Ou copiez le token et utilisez-le manuellement</li>
                <li>Le lien expirera dans 1 heure</li>
            </ol>
        </div>
    </div>
</div>
@endsection

