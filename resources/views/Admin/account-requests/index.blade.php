@extends('layouts.admin')

@section('title', 'Demandes de compte')

@section('content')

<style>
    :root {
        --primary-slate: #434861;   /* Bleu Ardoise */
        --accent-orange: #e67e22;   /* Orange Accent */
        --bg-perle: #f3f4f6;        /* Gris Perle */
        --white: #ffffff;
        --success: #27ae60;
        --danger: #e74c3c;
        --text-dark: #2d3748;
        --text-gray: #718096;
        --shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .admin-container {
        padding: 30px 20px;
        max-width: 1000px;
        margin: 0 auto;
        font-family: 'Inter', system-ui, sans-serif;
    }

    /* --- Header & Badges --- */
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .admin-header h1 {
        color: var(--primary-slate);
        font-weight: 800;
        margin: 0;
    }

    .badge-info {
        background: var(--primary-slate);
        color: white;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* --- Alertes --- */
    .alert {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    .alert-success { background: #d1fae5; color: #065f46; border-left: 5px solid var(--success); }
    .alert-danger { background: #fee2e2; color: #991b1b; border-left: 5px solid var(--danger); }

    /* --- Request Cards --- */
    .admin-card {
        background: transparent;
        border: none;
    }

    .request-card {
        background: var(--white);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: var(--shadow);
        border: 1px solid #edf2f7;
        transition: transform 0.2s;
    }

    .request-card:hover {
        transform: translateY(-3px);
    }

    .request-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    .request-info h3 {
        margin: 0;
        color: var(--primary-slate);
        font-size: 1.25rem;
    }

    .request-email { color: var(--accent-orange); font-weight: 600; margin: 5px 0; }
    .request-phone { color: var(--text-gray); font-size: 0.9rem; }

    /* --- Roles & Dates --- */
    .role-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    .role-user { background: #e0e7ff; color: #4338ca; }
    .role-tech_manager { background: #fef3c7; color: #92400e; }
    .role-admin { background: #fee2e2; color: #991b1b; }

    .date-badge {
        display: block;
        font-size: 0.8rem;
        color: var(--text-gray);
        text-align: right;
    }

    /* --- Messages --- */
    .request-message {
        background: var(--bg-perle);
        padding: 15px;
        border-radius: 8px;
        margin: 15px 0;
        font-size: 0.95rem;
        color: var(--text-dark);
        border-left: 3px solid #cbd5e1;
    }

    /* --- Actions & Buttons --- */
    .request-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: 0.3s;
        font-size: 0.9rem;
    }

    .btn-success { background: var(--success); color: white; }
    .btn-success:hover { background: #219150; box-shadow: 0 4px 10px rgba(39, 174, 96, 0.3); }

    .btn-danger { background: var(--danger); color: white; }
    .btn-danger:hover { background: #c0392b; box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3); }

    .btn-secondary { background: #94a3b8; color: white; }

    /* --- Rejection Form --- */
    .reject-form {
        margin-top: 20px;
        padding: 20px;
        background: #fff5f5;
        border-radius: 8px;
        border: 1px solid #feb2b2;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        margin-top: 8px;
    }

    /* --- Empty State --- */
    .empty-state {
        text-align: center;
        padding: 60px;
        background: var(--white);
        border-radius: 12px;
        color: var(--text-gray);
    }

    .empty-icon { font-size: 4rem; margin-bottom: 20px; }
</style>

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
