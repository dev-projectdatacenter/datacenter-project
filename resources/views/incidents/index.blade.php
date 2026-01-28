@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-slate: #434861;
        --sidebar-bg: #d1d5db;
        --bg-main: #f3f4f6;
        --accent-orange: #e67e22;
        --white: #ffffff;
        --text-dark: #2d3748;
        --text-gray: #718096;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .resources-container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* --- HEADER --- */
    .resources-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        background: var(--white);
        padding: 20px 30px;
        border-radius: 15px;
        box-shadow: var(--shadow);
    }

    .resources-header h1 {
        font-size: 1.5rem;
        color: var(--primary-slate);
        margin: 0;
        font-weight: 700;
    }

    .btn-report {
        background: var(--accent-orange);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-report:hover {
        background: #d35400;
        transform: translateY(-1px);
    }

    /* --- TABLE STYLE --- */
    .table-card {
        background: var(--white);
        border-radius: 15px;
        padding: 25px;
        box-shadow: var(--shadow);
        overflow-x: auto;
    }

    .resource-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .resource-table th {
        background: #f8fafc;
        padding: 15px;
        color: var(--text-gray);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        border-bottom: 2px solid #edf2f7;
    }

    .resource-table td {
        padding: 15px;
        border-bottom: 1px solid #edf2f7;
        font-size: 0.9rem;
        color: var(--text-dark);
    }

    /* --- BADGES --- */
    .severity-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .severity-low { background: #d1fae5; color: #065f46; }
    .severity-medium { background: #fef3c7; color: #92400e; }
    .severity-high { background: #fee2e2; color: #b91c1c; }
    .severity-critical { background: #7f1d1d; color: white; }

    .status-badge {
        padding: 5px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .status-open { background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8; }
    .status-resolved { background: #f0fff4; color: #2f855a; border: 1px solid #c6f6d5; }

    /* --- ACTIONS --- */
    .action-icons {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .btn-action {
        padding: 6px;
        border-radius: 4px;
        text-decoration: none;
        transition: 0.2s;
    }
    .btn-details { color: var(--primary-slate); background: #edf2f7; }
    .btn-details:hover { background: #e2e8f0; }

    /* --- INFO BOX --- */
    .info-banner {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.9rem;
    }
    .info-admin { background: #fffbeb; color: #92400e; border: 1px solid #fef3c7; }
    .info-user { background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8; }

</style>

<div class="resources-container">
    <div class="resources-header">
        <h1><i class="fas fa-exclamation-triangle"></i> Liste des Incidents</h1>
        @if(auth()->user()->can('create', App\Models\Incident::class))
            <a href="{{ route('incidents.create') }}" class="btn-report">
                <i class="fas fa-plus"></i> Signaler un Incident
            </a>
        @endif
    </div>

    @if(auth()->user()->role && auth()->user()->role->name === 'admin')
        <div class="table-card">
            <table class="resource-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Ressource</th>
                        <th>Gravité</th>
                        <th>Utilisateur</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incidents as $incident)
                        <tr>
                            <td><strong>{{ $incident->created_at->format('d/m/Y') }}</strong><br><small>{{ $incident->created_at->format('H:i') }}</small></td>
                            <td>
                                @if($incident->resource)
                                    <a href="{{ route('resources.show', $incident->resource) }}" style="color: var(--primary-slate); font-weight: 600;">
                                        {{ $incident->resource->name }}
                                    </a>
                                @else
                                    <span style="color: #ccc;">Supprimée</span>
                                @endif
                            </td>
                            <td>
                                <span class="severity-badge severity-{{ $incident->severity }}">
                                    @switch($incident->severity)
                                        @case('low') Faible @break
                                        @case('medium') Moyenne @break
                                        @case('high') Élevée @break
                                        @case('critical') Critique @break
                                    @endswitch
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
                                    <a href="{{ route('incidents.show', $incident) }}" class="btn-action btn-details" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @can('update', $incident)
                                        <a href="{{ route('incidents.edit', $incident) }}" class="btn-action" style="color: #3498db;"><i class="fas fa-edit"></i></a>
                                    @endcan

                                    @if($incident->status == 'open' && auth()->user()->can('resolve', $incident))
                                        <form action="{{ route('incidents.resolve', $incident) }}" method="POST" style="display:inline;">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn-action" style="color: #27ae60; border:none; background:none; cursor:pointer;" title="Résoudre"><i class="fas fa-check-circle"></i></button>
                                        </form>
                                    @endif
                                    
                                    @can('delete', $incident)
                                        <form action="{{ route('incidents.destroy', $incident) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action" style="color: #e74c3c; border:none; background:none; cursor:pointer;"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @elseif(auth()->user()->role && auth()->user()->role->name === 'tech_manager')
        <div class="info-banner info-admin">
            <i class="fas fa-info-circle"></i>
            <span>Consultation des incidents sur vos ressources supervisées. La gestion complète est réservée aux admins.</span>
        </div>
        <div class="table-card">
            <table class="resource-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Ressource</th>
                        <th>Gravité</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $hasIncidents = false; @endphp
                    @foreach($incidents as $incident)
                        @if($incident->resource && $incident->resource->managed_by === auth()->id())
                            @php $hasIncidents = true; @endphp
                            <tr>
                                <td>{{ $incident->created_at->format('d/m/Y H:i') }}</td>
                                <td><strong>{{ $incident->resource->name }}</strong></td>
                                <td><span class="severity-badge severity-{{ $incident->severity }}">{{ $incident->severity }}</span></td>
                                <td><span class="status-badge status-{{ $incident->status }}">{{ $incident->status }}</span></td>
                                <td><a href="{{ route('incidents.show', $incident) }}" class="btn-action btn-details"><i class="fas fa-search"></i></a></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            @if(!$hasIncidents)
                <div style="text-align:center; padding: 40px; color: var(--text-gray);">Aucun incident sur vos ressources.</div>
            @endif
        </div>

    @else
        <div class="info-banner info-user">
            <i class="fas fa-user-shield"></i>
            <span>Vos signalements sont en cours de traitement par l'équipe technique.</span>
        </div>
        
        <div class="table-card">
            @forelse($incidents->where('user_id', auth()->id()) as $incident)
                <div style="border-left: 4px solid var(--primary-slate); padding: 15px; margin-bottom: 15px; background: #f8fafc; border-radius: 0 8px 8px 0; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 700; color: var(--primary-slate);">{{ $incident->resource->name ?? 'Service' }}</div>
                        <div style="font-size: 0.85rem; color: var(--text-gray); margin: 5px 0;">{{ $incident->description }}</div>
                        <small><i class="far fa-clock"></i> {{ $incident->created_at->diffForHumans() }}</small>
                    </div>
                    <span class="status-badge status-{{ $incident->status }}">
                        {{ $incident->status == 'open' ? 'En cours' : 'Résolu' }}
                    </span>
                </div>
            @empty
                <div style="text-align:center; padding: 40px; color: var(--text-gray);">Vous n'avez pas encore signalé d'incident.</div>
            @endforelse
        </div>
    @endif
</div>
@endsection