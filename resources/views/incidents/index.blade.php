@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-slate: #434861;
        --accent-orange: #e67e22;
        --white: #ffffff;
        --text-dark: #2d3748;
        --text-gray: #718096;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }
    .resources-container { padding: 20px; max-width: 1200px; margin: 0 auto; }
    .resources-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: var(--white); padding: 20px 30px; border-radius: 15px; box-shadow: var(--shadow); }
    .resources-header h1 { font-size: 1.5rem; color: var(--primary-slate); margin: 0; font-weight: 700; }
    .btn-report { background: var(--accent-orange); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; }
    .btn-report:hover { background: #d35400; transform: translateY(-1px); }
    .table-card { background: var(--white); border-radius: 15px; padding: 25px; box-shadow: var(--shadow); overflow-x: auto; }
    .resource-table { width: 100%; border-collapse: collapse; text-align: left; }
    .resource-table th { background: #f8fafc; padding: 15px; color: var(--text-gray); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; border-bottom: 2px solid #edf2f7; }
    .resource-table td { padding: 15px; border-bottom: 1px solid #edf2f7; font-size: 0.9rem; color: var(--text-dark); }
    .severity-badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
    .severity-low { background: #d1fae5; color: #065f46; }
    .severity-medium { background: #fef3c7; color: #92400e; }
    .severity-high { background: #fee2e2; color: #b91c1c; }
    .severity-critical { background: #7f1d1d; color: white; }
    .status-badge { padding: 5px 12px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
    .status-open { background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8; }
    .status-resolved { background: #f0fff4; color: #2f855a; border: 1px solid #c6f6d5; }
    .action-icons { display: flex; gap: 10px; align-items: center; }
    .btn-action { padding: 6px; border-radius: 4px; text-decoration: none; transition: 0.2s; border: none; background: none; cursor: pointer; }
    .btn-details { color: var(--primary-slate); background: #edf2f7; }
    .btn-details:hover { background: #e2e8f0; }
</style>

<div class="resources-container">
    <div class="resources-header">
        <h1><i class="fas fa-exclamation-triangle"></i> Liste des Incidents</h1>
        @can('create', App\Models\Incident::class)
            <a href="{{ route('incidents.create') }}" class="btn-report">
                <i class="fas fa-plus"></i> Signaler un Incident
            </a>
        @endcan
    </div>

    <div class="table-card">
        <table class="resource-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Ressource</th>
                    <th>Gravité</th>
                    <th>Signalé par</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incidents as $incident)
                    <tr>
                        <td><strong>{{ $incident->created_at->format('d/m/Y') }}</strong><br><small>{{ $incident->created_at->format('H:i') }}</small></td>
                        <td>
                            @if($incident->resource)
                                <a href="{{ route('resources.show', $incident->resource) }}" style="color: var(--primary-slate); font-weight: 600;">{{ $incident->resource->name }}</a>
                            @else
                                <span style="color: #ccc;">Supprimée</span>
                            @endif
                        </td>
                        <td>
                            <span class="severity-badge severity-{{ $incident->severity }}">
                                {{ $incident->severity }}
                            </span>
                        </td>
                        <td>{{ $incident->user ? $incident->user->name : 'Système' }}</td>
                        <td>
                            <span class="status-badge status-{{ $incident->status }}">
                                {{ $incident->status == 'open' ? 'Ouvert' : 'Résolu' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-icons">
                                @can('view', $incident)
                                    <a href="{{ route('incidents.show', $incident) }}" class="btn-action btn-details" title="Voir détails"><i class="fas fa-eye"></i></a>
                                @endcan
                                
                                @can('update', $incident)
                                    @if($incident->status == 'open')
                                        <form action="{{ route('incidents.resolve', $incident) }}" method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-action" style="color: #27ae60;" title="Résoudre"><i class="fas fa-check-circle"></i></button>
                                        </form>
                                        <form action="{{ route('incidents.convert-to-maintenance', $incident) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-action" style="color: #e67e22;" title="Convertir en maintenance"><i class="fas fa-tools"></i></button>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-gray);">Aucun incident à afficher.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection