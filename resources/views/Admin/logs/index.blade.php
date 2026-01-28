@extends('layouts.admin')

@section('title', 'Logs d\'activité')

@section('content')
<style>
/* --- VARIABLES --- */
:root {
    --primary: #434861;        /* Bleu Ardoise */
    --accent: #b4967cff;         /* Orange Accent */
    --bg-light: #f3f4f6;       /* Gris Perle */
    --white: #ffffff;
    --danger: #c25050ff;
    --success: #10b981;
    --info: #3b82f6;
    --border: #edf2f7;
    --text-dark: #2d3748;
}

/* --- MISE EN PAGE GÉNÉRALE --- */
.container-fluid {
    padding: 30px;
    background-color: var(--bg-light);
    min-height: 100vh;
    font-family: 'Inter', system-ui, sans-serif;
}

h1 {
    color: var(--primary);
    font-weight: 800;
    font-size: 1.75rem;
}

/* --- CARTES --- */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    background: var(--white);
    margin-bottom: 25px !important;
}

.card-body { padding: 25px; }

/* --- FILTRES --- */
.form-label {
    font-weight: 600;
    color: var(--primary);
    font-size: 0.85rem;
    margin-bottom: 8px;
}

.form-select, .form-control {
    border: 2px solid var(--border);
    border-radius: 8px;
    padding: 10px;
    transition: 0.3s;
}

.form-select:focus, .form-control:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
    outline: none;
}

/* --- TABLEAU DE LOGS --- */
.table-responsive {
    max-height: 600px;
    border-radius: 8px;
}

.table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.table th {
    background: var(--primary) !important;
    color: white !important;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 1px;
    padding: 15px 20px;
    position: sticky;
    top: 0;
    z-index: 10;
    border: none;
}

.table td {
    padding: 15px 20px;
    vertical-align: middle;
    border-bottom: 1px solid var(--border);
    color: var(--text-dark);
    font-size: 0.9rem;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #fafbfc;
}

.table tbody tr:hover {
    background-color: #fff9f5; /* Hover léger orange */
}

/* --- BADGES D'ACTION (Refactorisés) --- */
.action-badge {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    color: white;
    min-width: 80px;
    text-align: center;
}

.action-create { background-color: var(--success); }
.action-update { background-color: var(--info); }
.action-delete { background-color: var(--danger); }
.action-login  { background-color: #8b5cf6; } /* Violet */
.action-logout { background-color: #6b7280; } /* Gris */
.action-warning, .action-error { background-color: var(--accent); }

/* --- BOUTONS --- */
.btn {
    border-radius: 8px;
    padding: 10px 18px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: 0.3s;
}

.btn-primary { background-color: var(--accent); border: none; }
.btn-primary:hover { background-color: #d35400; transform: translateY(-1px); }

.btn-success { background-color: #66d695ff; border: none; }
.btn-info { background-color: var(--primary); border: none; color: white; }
.btn-secondary { background-color: var(--border); color: var(--primary); border: none; }

/* --- NETTOYAGE DES LOGS (Zone Danger) --- */
.card-title {
    color: #c53030;
    font-weight: 700;
}

.input-group-text {
    background: var(--bg-light);
    border: 2px solid var(--border);
    border-left: none;
    border-radius: 0 8px 8px 0;
}

/* --- PAGINATION --- */
.pagination .page-link {
    color: var(--primary);
    border: none;
    margin: 0 3px;
    border-radius: 6px;
}

.pagination .page-item.active .page-link {
    background-color: var(--accent);
}


</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Logs d'activité</h1><br>
                <div class="btn-group">
                    <a href="{{ route('admin.logs.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Exporter CSV
                    </a>
                    <a href="{{ route('admin.logs.statistics') }}" class="btn btn-info">
                        <i class="fas fa-chart-bar"></i> Statistiques
                    </a>
                </div>
            </div><br>

            <!-- Filtres -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.logs.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="action" class="form-label">Action</label>
                                <select name="action" id="action" class="form-select">
                                    <option value="">Toutes les actions</option>
                                    @foreach($actions as $value => $label)
                                        <option value="{{ $value }}" {{ request('action') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="col-md-3">
                                <label for="user_id" class="form-label">Utilisateur</label>
                                <select name="user_id" id="user_id" class="form-select">
                                    <option value="">Tous les utilisateurs</option>
                                    @foreach(\App\Models\User::orderBy('name')->get() as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="date" class="form-control" 
                                       value="{{ request('date') }}">
                            </div><br>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-filter"></i> Filtrer
                                </button>
                                <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Réinitialiser
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tableau des logs -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Utilisateur</th>
                                    <th>Description</th>
                                    <th>Adresse IP</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>
                                            <span class="action-badge {{ $log->getActionColor() }}">
                                                {{ $log->getActionLabel() }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($log->user)
                                                <a href="{{ route('admin.users.show', $log->user) }}">
                                                    {{ $log->user->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->ip_address ?? 'N/A' }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.logs.show', $log) }}" 
                                                   class="btn btn-outline-primary" title="Voir les détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Aucun log trouvé pour les critères sélectionnés.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Nettoyage des logs -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Nettoyage des anciens logs</h5>
                    <p class="card-text">
                        Supprimez les logs plus anciens qu'un certain nombre de jours pour libérer de l'espace.
                    </p>
                    <form method="POST" action="{{ route('admin.logs.clear') }}" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ces logs ?')">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <label for="days" class="form-label">Supprimer les logs de plus de</label>
                                <div class="input-group">
                                    <input type="number" name="days" id="days" class="form-control" 
                                           value="30" min="1" max="365" required>
                                    <span class="input-group-text">jours</span>
                                </div>
                            </div><br>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer les anciens logs
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

