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
    max-width: 500px;
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

.reset-info {
    margin-bottom: 30px;
}

.info-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 15px;
}

.info-box h3 {
    color: #4a5568;
    font-size: 14px;
    font-weight: 600;
    margin: 0 0 10px 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-box p {
    color: #2d3748;
    font-size: 16px;
    margin: 0;
    font-weight: 500;
}

.email-display {
    color: #667eea;
    font-weight: 600;
    font-size: 18px;
}

.token-display {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.token-display code {
    background: #f1f5f9;
    color: #e53e3e;
    padding: 8px 12px;
    border-radius: 6px;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    font-weight: 600;
    word-break: break-all;
    flex: 1;
}

.btn-copy {
    background: #667eea;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-copy:hover {
    background: #5a67d8;
    transform: translateY(-1px);
}

.reset-actions {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 30px;
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
    text-align: center;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.btn-outline {
    background: transparent;
    color: #667eea;
    border: 2px solid #667eea;
}

.btn-outline:hover {
    background: #667eea;
    color: white;
}

.instructions {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 8px;
    padding: 20px;
}

.instructions h4 {
    color: #0369a1;
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 15px 0;
}

.instructions ol {
    color: #0c4a6e;
    font-size: 14px;
    margin: 0;
    padding-left: 20px;
}

.instructions li {
    margin-bottom: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .auth-container {
        padding: 20px 15px;
    }
    
    .auth-card {
        padding: 30px 20px;
    }
    
    .token-display {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-copy {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
function copyToken() {
    const token = document.querySelector('.token-display code').textContent;
    navigator.clipboard.writeText(token).then(function() {
        // Afficher une confirmation
        const btn = document.querySelector('.btn-copy');
        const originalText = btn.textContent;
        btn.textContent = '✅ Copié!';
        btn.style.background = '#10b981';
        
        setTimeout(function() {
            btn.textContent = originalText;
            btn.style.background = '#667eea';
        }, 2000);
    }).catch(function(err) {
        console.error('Erreur lors de la copie:', err);
        alert('Erreur lors de la copie du token. Veuillez le copier manuellement.');
    });
}
</script>
@endpush
