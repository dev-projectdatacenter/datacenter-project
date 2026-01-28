@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>🛡️ Support Technique</h1>
        <p>Espace de support pour les responsables techniques</p>
    </div>

    <div class="support-container">
        <!-- Statistiques du support -->
        <div class="support-stats">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-content">
                    <h3>{{ $stats['totalRequests'] ?? 0 }}</h3>
                    <p>Demandes en cours</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⏰</div>
                <div class="stat-content">
                    <h3>{{ $stats['pendingRequests'] ?? 0 }}</h3>
                    <p>En attente</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <h3>{{ $stats['resolvedToday'] ?? 0 }}</h3>
                    <p>Résolues aujourd'hui</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📈</div>
                <div class="stat-content">
                    <h3>{{ $stats['avgResponseTime'] ?? 0 }}h</h3>
                    <p>Temps moyen de réponse</p>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="quick-actions">
            <div class="action-card">
                <h3>📋 Voir toutes les demandes</h3>
                <p>Consultez l'historique complet des demandes de support</p>
                <a href="{{ route('support.requests') }}" class="btn btn-primary">Voir les demandes</a>
            </div>
            
            <div class="action-card">
                <h3>📧 Boîte de réception</h3>
                <p>Consultez les nouveaux emails de support</p>
                <a href="{{ route('support.emails') }}" class="btn btn-outline">Voir les emails</a>
            </div>
            
            <div class="action-card">
                <h3>⚠️ Incidents critiques</h3>
                <p>Gérez les incidents urgents en priorité</p>
                <a href="{{ route('incidents.index') }}" class="btn btn-danger">Voir les incidents</a>
            </div>
        </div>

        <!-- Formulaire de support -->
        <div class="support-form-section">
            <h2>📝 Nouvelle demande de support</h2>
            <p>Créez une nouvelle demande de support pour un utilisateur</p>
            
            <form class="support-form" onsubmit="submitSupportForm(event)">
                <div class="form-row">
                    <div class="form-group">
                        <label for="user_id">Utilisateur concerné *</label>
                        <select id="user_id" name="user_id" required>
                            <option value="">Sélectionnez un utilisateur</option>
                            @foreach(\App\Models\User::where('role_id', '!=', 1)->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role->name ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Sujet *</label>
                        <select id="subject" name="subject" required>
                            <option value="">Choisissez un sujet</option>
                            <option value="resource">Problème de ressource</option>
                            <option value="reservation">Problème de réservation</option>
                            <option value="access">Problème d'accès</option>
                            <option value="incident">Signalement d'incident</option>
                            <option value="account">Problème de compte</option>
                            <option value="maintenance">Demande de maintenance</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="urgency">Niveau d'urgence *</label>
                        <select id="urgency" name="urgency" required>
                            <option value="">Choisissez l'urgence</option>
                            <option value="low">🟢 Faible - Question générale</option>
                            <option value="medium">🟡 Moyenne - Problème gênant</option>
                            <option value="high">🔴 Élevée - Blocage majeur</option>
                            <option value="critical">🚨 Critique - Urgence absolue</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="resource_id">Ressource concernée</label>
                        <select id="resource_id" name="resource_id">
                            <option value="">Sélectionnez une ressource</option>
                            @foreach(\App\Models\Resource::all() as $resource)
                                <option value="{{ $resource->id }}">{{ $resource->name }} ({{ $resource->status }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description du problème *</label>
                    <textarea id="description" name="description" rows="6" required
                              placeholder="Décrivez en détail ce que l'utilisateur rencontre..."></textarea>
                </div>

                <div class="form-group">
                    <label for="notes">Notes internes (visible uniquement par les tech managers)</label>
                    <textarea id="notes" name="notes" rows="3"
                              placeholder="Notes internes pour l'équipe technique..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Créer la demande</button>
                    <button type="button" class="btn btn-outline" onclick="resetForm()">Effacer</button>
                </div>
            </form>
        </div>

        <!-- Demandes récentes -->
        <div class="recent-requests">
            <h2>📋 Demandes récentes</h2>
            <div class="requests-list">
                @if($recentRequests->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">📋</div>
                        <h3>Aucune demande récente</h3>
                        <p>Les demandes de support apparaîtront ici</p>
                    </div>
                @else
                    @foreach($recentRequests as $request)
                        <div class="request-item urgency-{{ $request->urgency }}">
                            <div class="request-header">
                                <div class="request-info">
                                    <h4>{{ $request->subject }}</h4>
                                    <div class="request-meta">
                                        <span class="user-name">{{ $request->user->name }}</span>
                                        <span class="request-date">{{ $request->created_at->format('d/m/Y H:i') }}</span>
                                        <span class="urgency-badge">{{ $request->urgency }}</span>
                                    </div>
                                </div>
                                <div class="request-status">
                                    @if($request->status === 'pending')
                                        <span class="status-badge status-pending">⏳ En attente</span>
                                    @elseif($request->status === 'in_progress')
                                        <span class="status-badge status-progress">🔄 En cours</span>
                                    @elseif($request->status === 'resolved')
                                        <span class="status-badge status-resolved">✅ Résolu</span>
                                    @endif
                                </div>
                            </div>
                            <div class="request-content">
                                <p><strong>Description :</strong> {{ $request->description }}</p>
                                @if($request->resource_id)
                                    <p><strong>Ressource :</strong> {{ $request->resource->name ?? 'N/A' }}</p>
                                @endif
                                @if($request->notes)
                                    <div class="internal-notes">
                                        <strong>Notes internes :</strong>
                                        <p>{{ $request->notes }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="request-actions">
                                @if($request->status === 'pending')
                                    <button class="btn btn-sm btn-primary" onclick="updateRequestStatus({{ $request->id }}, 'in_progress')">Prendre en charge</button>
                                @endif
                                @if($request->status === 'in_progress')
                                    <button class="btn btn-sm btn-success" onclick="updateRequestStatus({{ $request->id }}, 'resolved')">Marquer comme résolu</button>
                                @endif
                                <button class="btn btn-sm btn-outline" onclick="viewRequestDetails({{ $request->id }})">Voir détails</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.support-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 0;
}

.support-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    font-size: 2.5rem;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    color: white;
}

.stat-content h3 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: bold;
    color: #333;
}

.stat-content p {
    margin: 0;
    color: #666;
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.action-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(00,0,0.1);
    text-align: center;
}

.action-card h3 {
    margin: 0 0 0.5rem 0;
    color: #333;
}

.action-card p {
    color: #666;
    margin-bottom: 1rem;
}

.support-form-section {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.support-form {
    max-width: 800px;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-family: inherit;
    font-size: 1rem;
}

.form-group textarea {
    resize: vertical;
}

.form-actions {
    display: flex;
    gap: 1rem;
}

.recent-requests {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.requests-list {
    margin-top: 2rem;
}

.request-item {
    border: 1px solid #e1e5e9;
    border-radius: 8px;
    margin-bottom: 1rem;
    overflow: hidden;
}

.request-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e1e5e9;
}

.request-info h4 {
    margin: 0 0 0.5rem 0;
    color: #333;
}

.request-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
}

.user-name {
    font-weight: 600;
    color: #333;
}

.request-date {
    color: #666;
    font-size: 0.9rem;
}

.urgency-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
}

.urgency-low {
    background: #d4edda;
    color: #155724;
}

.urgency-medium {
    background: #fff3cd;
    color: #856404;
}

.urgency-high {
    background: #f8d7da;
    color: #721c24;
}

.urgency-critical {
    background: #f5c6cb;
    color: #721c24;
}

.request-status {
    display: flex;
    gap: 0.5rem;
}

.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status-pending {
    background: #ffc107;
    color: #333;
}

.status-progress {
    background: #17a2b8;
    color: white;
}

.status-resolved {
    background: #28a745;
    color: white;
}

.request-content {
    padding: 1rem;
}

.request-content p {
    margin: 0 0 1rem 0;
    color: #333;
}

.internal-notes {
    background: #e3f2fd;
    padding: 1rem;
    border-radius: 4px;
    margin-top: 1rem;
}

.internal-notes p {
    margin: 0;
    color: #1976d2;
    font-style: italic;
}

.request-actions {
    padding: 1rem;
    background: #f8f9fa;
    border-top: 1px solid #e1e5e9;
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #666;
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #4299e1;
    color: white;
}

.btn-primary:hover {
    background: #3182ce;
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #218838;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}

.btn-outline {
    background: transparent;
    color: #4299e1;
    border: 2px solid #4299e1;
}

.btn-outline:hover {
    background: #4299e1;
    color: white;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

@media (max-width: 768px) {
    .support-stats,
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .request-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .request-actions {
        flex-direction: column;
    }
}
</style>

<script>
function submitSupportForm(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    
    // Simuler la création de la demande
    alert('Demande de support créée avec succès !\n\nUtilisateur: ' + formData.get('user_id') + '\nSujet: ' + formData.get('subject') + '\nUrgence: ' + formData.get('urgency') + '\n\nLa demande a été enregistrée et sera traitée par l\'équipe technique.');
    
    // Réinitialiser le formulaire
    event.target.reset();
}

function resetForm() {
    document.querySelector('.support-form').reset();
}

function updateRequestStatus(requestId, status) {
    if (confirm('Êtes-vous sûr de vouloir changer le statut de cette demande ?')) {
        // Simuler la mise à jour du statut
        const statusText = status === 'in_progress' ? 'en cours' : 'résolu';
        alert('Statut de la demande mis à jour : ' + statusText);
        
        // Recharger la page pour voir les changements
        location.reload();
    }
}

function viewRequestDetails(requestId) {
    alert('Détails de la demande #' + requestId + '\n\nFonctionnalité à implémenter pour voir les détails complets.');
}
</script>
@endsection
