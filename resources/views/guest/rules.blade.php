@extends('layouts.app')

@section('title', 'Règles d\'utilisation')

@section('content')
<div class="guest-rules">
    <div class="rules-header">
        <h1>Règles d'utilisation du Data Center</h1>
        <p>Conditions et modalités d'utilisation des ressources</p>
    </div>

    <div class="rules-content">
        <div class="rules-section">
            <h2>📋 Principes généraux</h2>
            <div class="rule-item">
                <h3>1. Accès réservé</h3>
                <p>L'accès aux ressources du Data Center est réservé aux utilisateurs autorisés après validation de leur demande de compte.</p>
            </div>
            
            <div class="rule-item">
                <h3>2. Utilisation professionnelle</h3>
                <p>Les ressources doivent être utilisées à des fins professionnelles et académiques conformément aux objectifs de l'institution.</p>
            </div>
            
            <div class="rule-item">
                <h3>3. Respect des ressources</h3>
                <p>Les utilisateurs doivent respecter le matériel et les configurations logicielles mises à leur disposition.</p>
            </div>
        </div>

        <div class="rules-section">
            <h2>🖥️ Utilisation des ressources</h2>
            <div class="rule-item">
                <h3>Réservation préalable</h3>
                <p>Toute utilisation des ressources doit faire l'objet d'une réservation préalable via le système de gestion.</p>
            </div>
            
            <div class="rule-item">
                <h3>Durée d'utilisation</h3>
                <p>Les réservations sont limitées dans le temps selon les politiques définies pour chaque type de ressource.</p>
            </div>
            
            <div class="rule-item">
                <h3>Annulation</h3>
                <p>Les utilisateurs doivent annuler leur réservation en cas d'empêchement pour libérer les ressources.</p>
            </div>
        </div>

        <div class="rules-section">
            <h2>🔒 Sécurité et confidentialité</h2>
            <div class="rule-item">
                <h3>Données personnelles</h3>
                <p>Les utilisateurs sont responsables de la sécurité de leurs données et doivent respecter les réglementations en vigueur.</p>
            </div>
            
            <div class="rule-item">
                <h3>Accès non autorisé</h3>
                <p>Toute tentative d'accès non autorisé à des ressources ou des données est strictement interdite.</p>
            </div>
            
            <div class="rule-item">
                <h3>Signalement des incidents</h3>
                <p>Tout incident de sécurité doit être immédiatement signalé à l'administrateur du Data Center.</p>
            </div>
        </div>

        <div class="rules-section">
            <h2>⚠️ Responsabilités</h2>
            <div class="rule-item">
                <h3>Responsabilité utilisateur</h3>
                <p>L'utilisateur est responsable de toutes les activités effectuées avec son compte et ses accès.</p>
            </div>
            
            <div class="rule-item">
                <h3>Dommages</h3>
                <p>Toute dégradation volontaire ou négligence du matériel engage la responsabilité de l'utilisateur.</p>
            </div>
            
            <div class="rule-item">
                <h3>Conformité légale</h3>
                <p>Les utilisateurs doivent respecter toutes les lois et réglementations applicables à leur utilisation des ressources.</p>
            </div>
        </div>

        <div class="rules-section">
            <h2>📞 Contact et support</h2>
            <div class="rule-item">
                <h3>Support technique</h3>
                <p>Pour toute question technique ou demande d'assistance, contactez l'équipe du Data Center.</p>
            </div>
            
            <div class="rule-item">
                <h3>Réclamation</h3>
                <p>Les réclamations concernant l'utilisation des ressources doivent être formulées par écrit.</p>
            </div>
        </div>
    </div>

    <div class="rules-actions">
        <div class="action-card">
            <h3>Vous êtes prêt à utiliser nos ressources?</h3>
            <p>Demandez votre compte pour accéder à toutes les fonctionnalités</p>
            <a href="{{ route('guest.request-account') }}" class="btn btn-primary">
                Demander un compte
            </a>
        </div>
        
        <div class="action-card">
            <h3>Consultez nos ressources</h3>
            <p>Découvrez les équipements et services disponibles</p>
            <a href="{{ route('guest.resources.index') }}" class="btn btn-outline">
                Voir les ressources
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
.guest-rules {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

.rules-header {
    text-align: center;
    margin-bottom: 40px;
}

.rules-header h1 {
    color: #2d3748;
    font-size: 36px;
    margin-bottom: 10px;
}

.rules-header p {
    color: #718096;
    font-size: 18px;
}

.rules-content {
    margin-bottom: 40px;
}

.rules-section {
    margin-bottom: 40px;
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.rules-section h2 {
    color: #2d3748;
    font-size: 24px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e2e8f0;
}

.rule-item {
    margin-bottom: 25px;
}

.rule-item:last-child {
    margin-bottom: 0;
}

.rule-item h3 {
    color: #3b82f6;
    font-size: 18px;
    margin-bottom: 10px;
}

.rule-item p {
    color: #4a5568;
    line-height: 1.6;
    margin: 0;
}

.rules-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

.action-card {
    background: white;
    padding: 30px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.action-card h3 {
    color: #2d3748;
    font-size: 20px;
    margin-bottom: 10px;
}

.action-card p {
    color: #718096;
    margin-bottom: 20px;
    line-height: 1.6;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-1px);
}

.btn-outline {
    background: transparent;
    color: #3b82f6;
    border: 2px solid #3b82f6;
}

.btn-outline:hover {
    background: #3b82f6;
    color: white;
}

@media (max-width: 768px) {
    .guest-rules {
        padding: 15px;
    }
    
    .rules-section {
        padding: 20px;
    }
    
    .rules-actions {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
@endsection
