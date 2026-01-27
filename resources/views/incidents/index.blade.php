@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1>Liste des Incidents</h1>
        @if(auth()->user()->can('create', App\Models\Incident::class))
            <a href="{{ route('incidents.create') }}" class="btn btn-primary" style="background: #e67e22; border: none;">+ Signaler un Incident</a>
        @endif
    </div>

    <!-- Tableau pour les admins -->
    @if(auth()->user()->role && auth()->user()->role->name === 'admin')
    <div class="table-container">
        <table class="resource-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Ressource</th>
                    <th>Description</th>
                    <th>Gravité</th>
                    <th>Utilisateur</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidents as $incident)
                    <tr>
                        <td>{{ $incident->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($incident->resource)
                                <a href="{{ route('resources.show', $incident->resource) }}">
                                    {{ $incident->resource->name }}
                                </a>
                            @else
                                Ressource supprimée
                            @endif
                        </td>
                        <td>
                            <span title="{{ $incident->description }}">
                                {{ substr($incident->description, 0, 50) }}{{ strlen($incident->description) > 50 ? '...' : '' }}
                            </span>
                        </td>
                        <td>
                            <span class="severity-badge severity-{{ $incident->severity }}">
                                @if($incident->severity == 'low') Faible
                                @elseif($incident->severity == 'medium') Moyenne
                                @elseif($incident->severity == 'high') Élevée
                                @elseif($incident->severity == 'critical') Critique
                                @endif
                            </span>
                        </td>
                        <td>{{ $incident->user ? $incident->user->name : 'System' }}</td>
                        <td>
                            <span class="status-badge status-{{ $incident->status == 'open' ? 'maintenance' : 'available' }}">
                                @if($incident->status == 'open') Ouvert
                                @elseif($incident->status == 'resolved') Résolu
                                @else {{ $incident->status }}
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('incidents.show', $incident) }}" class="btn btn-sm">Détails</a>
                                
                                @can('update', $incident)
                                    <a href="{{ route('incidents.edit', $incident) }}" class="btn btn-sm" style="color: #3498db;">✏️</a>
                                @endcan
                                
                                @can('delete', $incident)
                                    <form action="{{ route('incidents.destroy', $incident) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer cet incident ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="color: #e74c3c;" title="Supprimer">
                                            🗑️
                                        </button>
                                    </form>
                                @endcan
                                
                                @if($incident->status == 'open')
                                    @can('resolve', $incident)
                                        <form action="{{ route('incidents.resolve', $incident) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="Marquer comme résolu">
                                                ✓ Résolu
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('incidents.convert-to-maintenance', $incident) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning" title="Convertir en maintenance" 
                                                    onclick="return confirm('Convertir cet incident en maintenance ? La ressource sera marquée comme en maintenance.')">
                                                🔧 Maintenance
                                            </button>
                                        </form>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif(auth()->user()->role && auth()->user()->role->name === 'tech_manager')
    <!-- Vue pour les tech managers : incidents sur leurs ressources (consultation uniquement) -->
    <div class="table-container">
        <h3 style="margin-bottom: 1rem; color: #666;">Incidents sur vos ressources supervisées</h3>
        <div style="background: #fff3cd; padding: 1rem; margin-bottom: 1rem; border-radius: 6px; border-left: 4px solid #ffc107;">
            <p style="margin: 0; color: #856404;">
                <strong>Note :</strong> En tant que responsable technique, vous pouvez consulter les incidents sur vos ressources. 
                La gestion des incidents (résolution, maintenance) est réservée aux administrateurs.
            </p>
        </div>
        <table class="resource-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Ressource</th>
                    <th>Description</th>
                    <th>Gravité</th>
                    <th>Utilisateur</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidents as $incident)
                    @if(auth()->user()->role->name === 'tech_manager' && $incident->user_id !== auth()->id() && (!$incident->resource || $incident->resource->managed_by !== auth()->id()))
                        @continue
                    @endif
                    <tr>
                        <td>{{ $incident->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($incident->resource)
                                <a href="{{ route('resources.show', $incident->resource) }}">
                                    {{ $incident->resource->name }}
                                </a>
                            @else
                                Ressource supprimée
                            @endif
                        </td>
                        <td>
                            <span title="{{ $incident->description }}">
                                {{ substr($incident->description, 0, 50) }}{{ strlen($incident->description) > 50 ? '...' : '' }}
                            </span>
                        </td>
                        <td>
                            <span class="severity-badge severity-{{ $incident->severity }}">
                                @if($incident->severity == 'low') Faible
                                @elseif($incident->severity == 'medium') Moyenne
                                @elseif($incident->severity == 'high') Élevée
                                @elseif($incident->severity == 'critical') Critique
                                @endif
                            </span>
                        </td>
                        <td>{{ $incident->user ? $incident->user->name : 'System' }}</td>
                        <td>
                            <span class="status-badge status-{{ $incident->status == 'open' ? 'maintenance' : 'available' }}">
                                @if($incident->status == 'open') Ouvert
                                @elseif($incident->status == 'resolved') Résolu
                                @else {{ $incident->status }}
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('incidents.show', $incident) }}" class="btn btn-sm">Détails</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <?php 
        $hasTechIncidents = false;
        foreach($incidents as $incident) {
            if($incident->resource && $incident->resource->managed_by === auth()->id()) {
                $hasTechIncidents = true;
                break;
            }
        }
        ?>
        @if(!$hasTechIncidents)
            <div style="text-align: center; padding: 2rem; color: #666;">
                Aucun incident signalé sur les ressources que vous supervisez.
            </div>
        @endif
    </div>
    @else
    <!-- Vue simple pour les utilisateurs non-admin -->
    <div style="background: white; padding: 2rem; border-radius: 8px; border: 1px solid #ddd;">
        <h3 style="margin-bottom: 1rem;">Vos signalements</h3>
        <div style="background: #e3f2fd; padding: 1rem; margin-bottom: 1rem; border-radius: 6px; border-left: 4px solid #2196f3;">
            <p style="margin: 0; color: #1565c0;">
                <strong>Information :</strong> Vos incidents sont transmis automatiquement aux administrateurs du Data Center qui les traiteront dans les plus brefs délais.
            </p>
        </div>
        @if($incidents->where('user_id', auth()->id())->isEmpty())
            <p style="color: #666;">Vous n'avez signalé aucun incident.</p>
        @else
            @foreach($incidents->where('user_id', auth()->id()) as $incident)
                <div style="border: 1px solid #e0e0e0; padding: 1rem; margin-bottom: 1rem; border-radius: 6px;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <strong>{{ $incident->resource->name ?? 'N/A' }}</strong>
                            <p style="margin: 0.5rem 0; color: #666;">{{ $incident->description }}</p>
                            <small style="color: #999;">Signalé le {{ $incident->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <span class="status-badge status-{{ $incident->status == 'open' ? 'maintenance' : 'available' }}">
                            @if($incident->status == 'open') Ouvert
                            @elseif($incident->status == 'resolved') Résolu
                            @endif
                        </span>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    @endif
</div>
@endsection
