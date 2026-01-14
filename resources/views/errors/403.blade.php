@extends('layouts.guest')

@section('title', 'Accès interdit')

@section('content')
<div class="error-container">
    <div class="error-card">
        <div class="error-icon">🚫</div>
        <h1>Accès interdit</h1>
        <p>Vous n'avez pas les permissions nécessaires pour accéder à cette page.</p>
        
        <div class="error-details">
            <p><strong>Code d'erreur :</strong> 403 - Forbidden</p>
            <p><strong>Rôle actuel :</strong> {{ auth()->check() ? __('roles.' . auth()->user()->role) : 'Non connecté' }}</p>
            <p><strong>URL demandée :</strong> {{ request()->url() }}</p>
        </div>

        <div class="error-actions">
            @if(auth()->check())
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    🏠 Retour au dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline">
                        🚪 Se déconnecter
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    🔐 Se connecter
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline">
                    🏠 Page d'accueil
                </a>
            @endif
        </div>

        <div class="help-section">
            <h3>Besoin d'aide ?</h3>
            <p>Si vous pensez que c'est une erreur, veuillez contacter l'administrateur système.</p>
            <ul>
                <li>Vérifiez que vous êtes connecté avec le bon compte</li>
                <li>Assurez-vous d'avoir les permissions nécessaires</li>
                <li>Contactez votre administrateur si le problème persiste</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.error-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
}

.error-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 40px;
    text-align: center;
    max-width: 500px;
    width: 100%;
}

.error-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.error-card h1 {
    color: #2d3748;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 16px;
}

.error-card > p {
    color: #718096;
    font-size: 16px;
    margin-bottom: 30px;
    line-height: 1.5;
}

.error-details {
    background: #f7fafc;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
    text-align: left;
}

.error-details p {
    margin: 8px 0;
    font-size: 14px;
    color: #4a5568;
}

.error-details strong {
    color: #2d3748;
}

.error-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.help-section {
    border-top: 1px solid #e2e8f0;
    padding-top: 30px;
}

.help-section h3 {
    color: #2d3748;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 12px;
}

.help-section p {
    color: #718096;
    font-size: 14px;
    margin-bottom: 16px;
}

.help-section ul {
    text-align: left;
    color: #4a5568;
    font-size: 14px;
    line-height: 1.6;
}

.help-section li {
    margin-bottom: 8px;
}

/* Boutons */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-outline {
    background-color: transparent;
    border: 2px solid #667eea;
    color: #667eea;
}

.btn-outline:hover {
    background-color: #667eea;
    color: white;
}

/* Responsive */
@media (max-width: 480px) {
    .error-container {
        padding: 10px;
    }
    
    .error-card {
        padding: 30px 20px;
    }
    
    .error-icon {
        font-size: 48px;
    }
    
    .error-card h1 {
        font-size: 28px;
    }
    
    .error-actions {
        flex-direction: column;
    }
    
    .error-actions .btn {
        width: 100%;
    }
}
</style>
@endpush
