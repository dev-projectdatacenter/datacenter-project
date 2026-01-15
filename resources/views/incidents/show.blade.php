@extends('layouts.app')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('incidents.index') }}" style="color: #666; text-decoration: none;">&larr; Retour à la liste</a>
        <h1 style="margin-top: 1rem;">Détails de l'Incident #{{ $incident->id }}</h1>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        {{-- Description de l'incident --}}
        <div class="card" style="background: white; padding: 2rem; border-radius: 8px; border: 1px solid #ddd;">
            <h3 style="margin-top: 0; color: #333;">Description du problème</h3>
            <p style="white-space: pre-wrap; line-height: 1.6; color: #444; background: #f9f9f9; padding: 1.5rem; border-radius: 4px; border-left: 4px solid #e74c3c;">{{ $incident->description }}</p>
            
            <div style="margin-top: 2rem; color: #666; font-size: 0.9rem;">
                Signalé le {{ $incident->created_at->format('d/m/Y à H:i') }} par l'utilisateur #{{ $incident->user_id }}
            </div>
        </div>

        {{-- Actions et Infos Ressource --}}
        <div>
            {{-- Infos Ressource --}}
            <div class="card" style="background: white; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 1.5rem;">
                <h4 style="margin-top: 0;">Ressource Concernée</h4>
                <div style="margin-bottom: 1rem;">
                    <strong>{{ $incident->resource->name ?? 'N/A' }}</strong><br>
                    <span style="color: #666; font-size: 0.9rem;">{{ $incident->resource->category->name ?? '' }}</span>
                </div>
                <a href="{{ route('resources.show', $incident->resource_id) }}" style="color: #3498db; text-decoration: none; font-size: 0.9rem;">Voir la fiche technique &rarr;</a>
            </div>

            {{-- Statut et Action --}}
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
                    
                    <a href="{{ route('maintenances.create', ['resource_id' => $incident->resource_id]) }}" style="text-align: center; width: 100%; padding: 0.7rem; background: #f39c12; color: white; border: none; border-radius: 4px; text-decoration: none; font-size: 0.9rem; font-weight: bold;">
                        ⚙️ Planifier une maintenance
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
