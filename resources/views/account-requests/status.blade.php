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
@endpush
