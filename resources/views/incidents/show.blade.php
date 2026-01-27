@extends('layouts.app')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('incidents.index') }}" class="btn-back">&larr; Retour à la liste</a>
        <h1 style="margin-top: 1rem;">Détails de l'Incident #{{ $incident->id }}</h1>
    </div>

    <!-- Message pour les utilisateurs non-admin -->
    @can('user')
        <div style="background: #e3f2fd; padding: 1rem; margin-bottom: 1rem; border-radius: 6px; border-left: 4px solid #2196f3;">
            <p style="margin: 0; color: #1565c0;">
                <strong>Information :</strong> En tant qu'utilisateur, vous pouvez uniquement consulter vos propres incidents. 
                La gestion des incidents est réservée aux administrateurs.
            </p>
        </div>
    @endcan

    <!-- Vérifier que l'utilisateur peut voir cet incident -->
    @if(auth()->user()->role->name === 'user' && $incident->user_id !== auth()->id())
        <div style="background: #fee; padding: 2rem; border-radius: 8px; border: 1px solid #fcc; text-align: center;">
            <h3 style="color: #c33;">Accès non autorisé</h3>
            <p>Vous ne pouvez consulter que les incidents que vous avez signalés.</p>
            <a href="{{ route('incidents.index') }}" class="btn-back">Retour à la liste</a>
        </div>
    @elseif(auth()->user()->role->name === 'tech_manager' && (!$incident->resource || $incident->resource->managed_by !== auth()->id()))
        <div style="background: #fee; padding: 2rem; border-radius: 8px; border: 1px solid #fcc; text-align: center;">
            <h3 style="color: #c33;">Accès non autorisé</h3>
            <p>Vous ne pouvez consulter que les incidents sur les ressources que vous supervisez.</p>
            <a href="{{ route('incidents.index') }}" class="btn-back">Retour à la liste</a>
        </div>
    @else
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        {{-- Description de l'incident --}}
        <div class="card" style="background: white; padding: 2rem; border-radius: 8px; border: 1px solid #ddd;">
            <h3 style="margin-top: 0; color: #333;">Description du problème</h3>
            <p style="white-space: pre-wrap; line-height: 1.6; color: #444; background: #f9f9f9; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #e74c3c;">{{ $incident->description }}</p>
            
            @if($incident->notes)
                <div style="margin-top: 1.5rem; background: #fff3cd; padding: 1rem; border-radius: 4px; border-left: 4px solid #ffc107;">
                    <strong>Notes administrateur :</strong><br>
                    {{ $incident->notes }}
                </div>
            @endif
            
            <div style="margin-top: 2rem; color: #666; font-size: 0.9rem;">
                Signalé le {{ $incident->created_at->format('d/m/Y à H:i') }} par {{ $incident->user ? $incident->user->name : 'System' }}
            </div>
        </div>

        {{-- Actions et Infos Ressource --}}
        <div>
            {{-- Infos Ressource --}}
            <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 1.5rem;">
                <h4 style="margin-top: 0;">Ressource Concernée</h4>
                <div style="margin-bottom: 1rem;">
                    <strong>{{ $incident->resource->name ?? 'N/A' }}</strong><br>
                    <span style="color: #666; font-size: 0.9rem;">{{ $incident->resource->category->name ?? '' }}</span><br>
                    <span class="severity-badge severity-{{ $incident->severity }}">
                        @if($incident->severity == 'low') Faible
                        @elseif($incident->severity == 'medium') Moyenne
                        @elseif($incident->severity == 'high') Élevée
                        @elseif($incident->severity == 'critical') Critique
                        @endif
                    </span>
                </div>
                @if($incident->resource)
                    <a href="{{ route('resources.show', $incident->resource) }}" style="color: #3498db; text-decoration: none; font-size: 0.9rem;">Voir la fiche technique &rarr;</a>
                @endif
            </div>

            {{-- Statut et Action (uniquement pour admin) --}}
            @can('admin')
            <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd;">
                <h4 style="margin-top: 0;">Statut actuel</h4>
                <div style="margin-bottom: 1.5rem;">
                    @if($incident->status == 'open')
                        <span style="display: block; text-align: center; background: #fde2e2; color: #c53030; padding: 0.5rem; border-radius: 4px; font-weight: bold;">🚨 OUVERT</span>
                    @else
                        <span style="display: block; text-align: center; background: #def7ec; color: #03543f; padding: 0.5rem; border-radius: 4px; font-weight: bold;">✅ RÉSOLU</span>
                    @endif
                </div>

                @if($incident->status == 'open')
                <div style="display: grid; gap: 1rem;">
                    <form action="{{ route('incidents.resolve', $incident) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="width: 100%; padding: 0.8rem; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                            Marquer comme résolu
                        </button>
                    </form>
                    
                    <form action="{{ route('incidents.convert-to-maintenance', $incident) }}" method="POST">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 0.8rem; background: #f39c12; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;"
                                onclick="return confirm('Convertir cet incident en maintenance ? La ressource sera marquée comme en maintenance.')">
                            ⚙️ Convertir en maintenance
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @else
            <!-- Pour les tech managers et utilisateurs non-admin : afficher seulement le statut -->
            <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd;">
                <h4 style="margin-top: 0;">Statut actuel</h4>
                <div>
                    @if($incident->status == 'open')
                        <span style="display: block; text-align: center; background: #fde2e2; color: #c53030; padding: 0.5rem; border-radius: 4px; font-weight: bold;">🚨 OUVERT</span>
                    @else
                        <span style="display: block; text-align: center; background: #def7ec; color: #03543f; padding: 0.5rem; border-radius: 4px; font-weight: bold;">✅ RÉSOLU</span>
                    @endif
                </div>
                <p style="margin-top: 1rem; color: #666; font-size: 0.8rem; text-align: center;">
                    Un administrateur traite actuellement cet incident.
                </p>
            </div>
            @endcan
        </div>
    </div>
    @endif
</div>
@endsection
