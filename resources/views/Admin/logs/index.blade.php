@extends('layouts.admin')

@section('title', 'Logs d\'activité')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Logs d'activité</h1>
                <div class="btn-group">
                    <a href="{{ route('admin.logs.export') }}" class="btn btn-success">
                        <i class="fas fa-download"></i> Exporter CSV
                    </a>
                    <a href="{{ route('admin.logs.statistics') }}" class="btn btn-info">
                        <i class="fas fa-chart-bar"></i> Statistiques
                    </a>
                </div>
            </div>

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
                            </div>
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
                            </div>
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
                                            <span class="badge bg-{{ $log->getActionColor() }}">
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

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Affichage de {{ $logs->firstItem() }} à {{ $logs->lastItem() }} 
                            sur {{ $logs->total() }} logs
                        </div>
                        {{ $logs->links() }}
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
                            </div>
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

@push('scripts')
<script>
    // Auto-rafraîchissement toutes les 30 secondes
    setInterval(() => {
        if (document.visibilityState === 'visible') {
            window.location.reload();
        }
    }, 30000);

    // Confirmation avant suppression
    document.querySelector('form[action*="clear"]').addEventListener('submit', function(e) {
        const days = document.getElementById('days').value;
        if (!confirm(`Êtes-vous sûr de vouloir supprimer tous les logs de plus de ${days} jours ? Cette action est irréversible.`)) {
            e.preventDefault();
        }
    });
</script>
@endpush
