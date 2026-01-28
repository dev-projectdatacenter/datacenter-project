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
