@extends('layouts.app')

@section('content')
<div class="container">
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Détails de la ressource</h1>
        <div>
            <a href="{{ route('resources.index') }}" class="btn-secondary" style="margin-right: 1rem;">Retour à la liste</a>
            <a href="{{ route('resources.edit', $resource) }}" class="btn-primary" style="background: #3498db; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">Modifier</a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        {{-- Colonne de gauche : Infos techniques --}}
        <div class="card" style="background: #fff; padding: 2rem; border-radius: 8px; border: 1px solid #ddd; height: fit-content;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
                <div>
                    <h2 style="margin: 0; color: #2c3e50;">{{ $resource->name }}</h2>
                    <p style="color: #7f8c8d; margin-top: 0.5rem;">Catégorie : <strong>{{ $resource->category->name }}</strong></p>
                </div>
                <span class="badge badge-{{ $resource->status }}" style="padding: 0.5rem 1rem; border-radius: 20px; font-weight: bold; text-transform: uppercase; font-size: 0.8rem; background: {{ $resource->status == 'available' ? '#d4edda' : ($resource->status == 'busy' ? '#fff3cd' : '#f8d7da') }}; color: {{ $resource->status == 'available' ? '#155724' : ($resource->status == 'busy' ? '#856404' : '#721c24') }};">
                    {{ ucfirst($resource->status) }}
                </span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div>
                    <h4 style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1rem; color: #34495e;">Spécifications</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.8rem;"><strong>CPU :</strong> {{ $resource->cpu ?? 'N/A' }}</li>
                        <li style="margin-bottom: 0.8rem;"><strong>RAM :</strong> {{ $resource->ram ?? 'N/A' }}</li>
                        <li style="margin-bottom: 0.8rem;"><strong>Stockage :</strong> {{ $resource->storage ?? 'N/A' }}</li>
                        <li style="margin-bottom: 0.8rem;"><strong>OS :</strong> {{ $resource->os ?? 'N/A' }}</li>
                    </ul>
                </div>
                <div>
                    <h4 style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1rem; color: #34495e;">Localisation & Dates</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.8rem;"><strong>Emplacement :</strong> {{ $resource->location ?? 'Non précisé' }}</li>
                        <li style="margin-bottom: 0.8rem;"><strong>Créé le :</strong> {{ $resource->created_at->format('d/m/Y H:i') }}</li>
                        <li style="margin-bottom: 0.8rem;"><strong>Mis à jour :</strong> {{ $resource->updated_at->format('d/m/Y H:i') }}</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Colonne de droite : Statut / Actions rapides --}}
        <div>
            <div class="card" style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 1.5rem;">
                <h4 style="margin-top: 0;">Actions de gestion</h4>
                <p style="font-size: 0.9rem; color: #666;">Modifier le statut ou les caractéristiques de la ressource.</p>
                <div style="display: grid; gap: 1rem; margin-top: 1rem;">
                    <a href="{{ route('incidents.report', $resource) }}" style="text-align: center; width: 100%; padding: 0.6rem; background: #e67e22; border: none; color: white; border-radius: 4px; text-decoration: none; font-weight: bold;">⚠️ Signaler un incident</a>
                    
                    <button type="button" onclick="location.href='{{ route('resources.edit', $resource) }}'" style="width: 100%; padding: 0.6rem; background: #fff; border: 1px solid #3498db; color: #3498db; border-radius: 4px; cursor: pointer;">✏️ Éditer les infos</button>
                    
                    <form action="{{ route('resources.destroy', $resource) }}" method="POST" onsubmit="return confirm('Attention : Cette action est irréversible. Confirmer ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width: 100%; padding: 0.6rem; background: #e74c3c; border: none; color: white; border-radius: 4px; cursor: pointer;">🗑️ Supprimer la ressource</button>
                    </form>
                </div>
            </div>

            <div class="card" style="background: #fff; padding: 1.5rem; border-radius: 8px; border: 1px solid #ddd;">
                <h4 style="margin-top: 0;">Historique court</h4>
                <p style="font-size: 0.85rem; color: #7f8c8d;">Cette ressource a été utilisée dans <strong>{{ $resource->reservations->count() }}</strong> réservation(s).</p>
            </div>
        </div>
    </div>
</div>
@endsection
