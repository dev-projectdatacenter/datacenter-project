@extends('layouts.admin')

@section('title', 'Demandes de compte')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Demandes de compte</h1>
        <div class="header-actions">
            <span class="badge badge-info">
                {{ $requests->count() }} demande(s) en attente
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="admin-card">
        @forelse($requests as $request)
            <div class="request-card">
                <div class="request-header">
                    <div class="request-info">
                        <h3>{{ $request->name }}</h3>
                        <p class="request-email">{{ $request->email }}</p>
                        @if($request->phone)
                            <p class="request-phone">📞 {{ $request->phone }}</p>
                        @endif
                    </div>
                    <div class="request-meta">
                        <span class="role-badge role-{{ $request->role_requested }}">
                            @switch($request->role_requested)
                                @case('user')
                                    Utilisateur interne
                                @case('tech_manager')
                                    Responsable technique
                                @case('admin')
                                    Administrateur
                                @default
                                    Non spécifié
                            @endswitch
                        </span>
                        <span class="date-badge">
                            {{ $request->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>

                @if($request->message)
                    <div class="request-message">
                        <strong>Message :</strong>
                        <p>{{ $request->message }}</p>
                    </div>
                @endif

                @if($request->rejection_reason)
                    <div class="request-message">
                        <h4>❌ Motif du refus :</h4>
                        <p>{{ $request->rejection_reason }}</p>
                    </div>
                @endif

                <div class="request-actions">
                    <form method="POST" action="{{ route('admin.account-requests.approve', $request) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Approuver cette demande de compte ?')">
                            ✅ Approuver
                        </button>
                    </form>

                    <button type="button" class="btn btn-danger" onclick="showRejectForm({{ $request->id }})">
                        ❌ Refuser
                    </button>
                </div>

                <!-- Formulaire de refus caché -->
                <div id="reject-form-{{ $request->id }}" class="reject-form" style="display: none;">
                    <form method="POST" action="{{ route('admin.account-requests.reject', $request) }}">
                        @csrf
                        <div class="form-group">
                            <label for="rejection_reason_{{ $request->id }}">Motif du refus</label>
                            <textarea 
                                id="rejection_reason_{{ $request->id }}" 
                                name="rejection_reason" 
                                class="form-control" 
                                rows="3" 
                                required
                                placeholder="Expliquez pourquoi vous refusez cette demande..."
                            ></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-danger">
                                Confirmer le refus
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="hideRejectForm({{ $request->id }})">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h3>Aucune demande en attente</h3>
                <p>Toutes les demandes de compte ont été traitées.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($requests->hasPages())
        <div class="pagination-wrapper">
            {{ $requests->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.admin-container {
    padding: 20px;
    max-width: 1000px;
    margin: 0 auto;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.admin-header h1 {
    color: #2d3748;
    font-size: 28px;
    font-weight: 700;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-info {
    background-color: #ebf8ff;
    color: #2a4e7c;
    border: 1px solid #4299e1;
}

.admin-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.request-card {
    padding: 24px;
    border-bottom: 1px solid #e2e8f0;
}

.request-card:last-child {
    border-bottom: none;
}

.request-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
    flex-wrap: wrap;
    gap: 15px;
}

.request-info h3 {
    color: #2d3748;
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 4px 0;
}

.request-email {
    color: #718096;
    font-size: 14px;
    margin: 0;
}

.request-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
    align-items: flex-end;
}

.role-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.role-admin {
    background-color: #fed7d7;
    color: #742a2a;
}

.role-tech_manager {
    background-color: #feebc8;
    color: #7c2d12;
}

.role-user {
    background-color: #bee3f8;
    color: #2a4e7c;
}

.role-guest {
    background-color: #e2e8f0;
    color: #4a5568;
}

.date-badge {
    background-color: #f7fafc;
    color: #718096;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.request-message {
    background-color: #f7fafc;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 16px;
}

.request-message strong {
    color: #4a5568;
    font-size: 14px;
}

.request-message p {
    color: #2d3748;
    font-size: 14px;
    margin: 8px 0 0 0;
    line-height: 1.5;
}

.request-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.reject-form {
    margin-top: 16px;
    padding: 16px;
    background-color: #fff5f5;
    border: 1px solid #fed7d7;
    border-radius: 8px;
}

.form-group {
    margin-bottom: 16px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #4a5568;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 10px 14px;
    border: 2px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
    transition: all 0.2s ease;
    background-color: white;
    resize: vertical;
}

.form-control:focus {
    outline: none;
    border-color: #e53e3e;
    box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
}

.form-actions {
    display: flex;
    gap: 12px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 16px;
}

.empty-state h3 {
    color: #2d3748;
    font-size: 20px;
    font-weight: 600;
    margin: 0 0 8px 0;
}

.empty-state p {
    color: #718096;
    font-size: 16px;
    margin: 0 0 24px 0;
}

.pagination-wrapper {
    padding: 20px;
    display: flex;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-container {
        padding: 15px;
    }
    
    .admin-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .request-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .request-meta {
        align-items: flex-start;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .request-actions {
        flex-direction: column;
    }
    
    .request-actions .btn {
        width: 100%;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
function showRejectForm(requestId) {
    const form = document.getElementById('reject-form-' + requestId);
    form.style.display = 'block';
    form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function hideRejectForm(requestId) {
    const form = document.getElementById('reject-form-' + requestId);
    form.style.display = 'none';
}
</script>
@endpush
