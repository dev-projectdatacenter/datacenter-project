@extends('layouts.app')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1>Planifier une Maintenance</h1>
        <a href="{{ route('maintenances.index') }}" style="color: #666; text-decoration: none;">&larr; Retour au planning</a>
    </div>

    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #f5c6cb;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="background: white; padding: 2rem; border-radius: 8px; border: 1px solid #ddd;">
        <form action="{{ route('maintenances.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 1.5rem;">
                {{-- Sélection Ressource --}}
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Ressource à maintenir</label>
                    <select name="resource_id" required style="width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="">-- Choisir un serveur/équipement --</option>
                        @foreach($resources as $res)
                            <option value="{{ $res->id }}" {{ (isset($resource) && $resource->id == $res->id) || old('resource_id') == $res->id ? 'selected' : '' }}>
                                {{ $res->name }} ({{ $res->category->name ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dates --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Date début</label>
                        <input type="datetime-local" name="start_date" value="{{ old('start_date', now()->format('Y-m-d\TH:i')) }}" required style="width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Date fin (est.)</label>
                        <input type="datetime-local" name="end_date" value="{{ old('end_date', now()->addHours(2)->format('Y-m-d\TH:i')) }}" required style="width: 100%; padding: 0.6rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Raison / Détails des travaux</label>
                <textarea name="reason" rows="4" required placeholder="Ex: Mise à jour noyau, remplacement disque, nettoyage poussière..." style="width: 100%; padding: 0.7rem; border: 1px solid #ccc; border-radius: 4px;">{{ old('reason') }}</textarea>
            </div>

            <div style="background: #eef2f7; padding: 1rem; border-radius: 4px; border-left: 4px solid #3498db; margin-bottom: 2rem;">
                <p style="margin: 0; color: #34495e; font-size: 0.95rem;">
                    <strong>Information :</strong> En validant, la ressource passera automatiquement en statut <strong>"Maintenance"</strong>.
                </p>
            </div>

            <div style="text-align: right;">
                <button type="submit" style="background: #f39c12; color: white; padding: 0.8rem 2.5rem; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 1rem;">
                    Valider la planification
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
