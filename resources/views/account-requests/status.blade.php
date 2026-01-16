@extends('layouts.guest')

@section('title', 'Statut de la demande')

@section('content')
<div class="status-container">
    <div class="status-card">
        <div class="status-header">
            <h1>📋 Statut de votre demande</h1>
        </div>

        @if($request)
            <div class="status-info">
                <div class="info-section">
                    <h3>Informations de la demande</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nom :</label>
                            <span>{{ $request->name }}</span>
                        </div>
                        <div class="info-item">
                            <label>Email :</label>
                            <span>{{ $request->email }}</span>
                        </div>
                        <div class="info-item">
                            <label>Téléphone :</label>
                            <span>{{ $request->phone ?: 'Non spécifié' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Rôle demandé :</label>
                            <span>{{ $request->role_requested_formatted }}</span>
                        </div>
                        <div class="info-item">
                            <label>Date de la demande :</label>
                            <span>{{ $request->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                    </div>
                </div>

                <div class="status-section">
                    <h3>Statut actuel</h3>
                    <div class="status-badge {{ $request->status }}">
                        @if($request->status == 'pending')
                            ⏳ En attente de traitement
                        @elseif($request->status == 'approved')
                            ✅ Approuvée
                        @elseif($request->status == 'rejected')
                            ❌ Refusée
                        @endif
                    </div>

                    @if($request->status == 'pending')
                        <div class="pending-info">
                            <p>📧 Votre demande est en cours de traitement par nos administrateurs.</p>
                            <p>⏰ Vous recevrez une réponse par email dans les 24-48 heures.</p>
                        </div>
                    @elseif($request->status == 'approved')
                        <div class="approved-info">
                            <p>🎉 Félicitations ! Votre demande a été approuvée.</p>
                            <p>📧 Vos identifiants de connexion ont été envoyés par email.</p>
                            <p>🔑 Vous pouvez vous connecter avec votre email et le mot de passe temporaire.</p>
                            <div class="login-prompt">
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    🔐 Se connecter maintenant
                                </a>
                            </div>
                        </div>
                    @elseif($request->status == 'rejected')
                        <div class="rejected-info">
                            <p>❌ Votre demande a été refusée.</p>
                            @if($request->rejection_reason)
                                <div class="rejection-reason">
                                    <h4>Motif du refus :</h4>
                                    <p>{{ $request->rejection_reason }}</p>
                                </div>
                            @endif
                            <p>💡 Vous pouvez soumettre une nouvelle demande si nécessaire.</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="no-request">
                <div class="error-icon">❌</div>
                <h3>Aucune demande trouvée</h3>
                <p>Aucune demande de compte n'a été trouvée pour cette adresse email.</p>
                <div class="actions">
                    <a href="{{ route('account.request.create') }}" class="btn btn-outline">
                        📝 Faire une demande
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        🔐 Se connecter
                    </a>
                </div>
            </div>
        @endif

        <div class="status-footer">
            <a href="{{ route('login') }}" class="link-back">
                🔙 Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.status-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.status-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 40px;
    max-width: 700px;
    width: 100%;
}

.status-header {
    text-align: center;
    margin-bottom: 30px;
}

.status-header h1 {
    color: #2d3748;
    font-size: 28px;
    font-weight: 700;
    margin: 0;
}

.status-info {
    margin-bottom: 30px;
}

.info-section,
.status-section {
    margin-bottom: 30px;
}

.info-section h3,
.status-section h3 {
    color: #4a5568;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e2e8f0;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
}

.info-item {
    background: #f8fafc;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.info-item label {
    display: block;
    font-weight: 600;
    color: #4a5568;
    font-size: 12px;
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-item span {
    color: #2d3748;
    font-size: 14px;
    font-weight: 500;
}

.status-badge {
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 20px;
}

.status-badge.pending {
    background: #fef3c7;
    color: #d97706;
    border: 1px solid #fbbf24;
}

.status-badge.approved {
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.status-badge.rejected {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.pending-info,
.approved-info,
.rejected-info {
    background: #f8fafc;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.pending-info p,
.approved-info p,
.rejected-info p {
    color: #4a5568;
    font-size: 14px;
    margin-bottom: 10px;
}

.rejection-reason {
    background: #fef2f2;
    padding: 15px;
    border-radius: 6px;
    border: 1px solid #fecaca;
    margin-top: 15px;
}

.rejection-reason h4 {
    color: #dc2626;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
}

.rejection-reason p {
    color: #718096;
    font-size: 14px;
    margin: 0;
}

.login-prompt {
    text-align: center;
    margin-top: 20px;
}

.no-request {
    text-align: center;
    padding: 40px 20px;
}

.error-icon {
    font-size: 48px;
    margin-bottom: 20px;
}

.no-request h3 {
    color: #dc2626;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 15px;
}

.no-request p {
    color: #718096;
    font-size: 16px;
    margin-bottom: 30px;
}

.actions {
    display: flex;
    gap: 15px;
    justify-content: center;
}

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

.status-footer {
    text-align: center;
    margin-top: 30px;
}

.link-back {
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    padding: 10px 20px;
    border: 1px solid #667eea;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.link-back:hover {
    background: #667eea;
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .status-container {
        padding: 20px 15px;
    }
    
    .status-card {
        padding: 30px 20px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>
@endpush
