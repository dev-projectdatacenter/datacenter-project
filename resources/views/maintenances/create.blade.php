@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Header --}}
    <div style="margin-bottom: 2rem; border-bottom: 2px solid #997953; padding-bottom: 1rem;">
        <h1 style="color: #0f1e3f; margin: 0;">Planifier une Maintenance</h1>
        <a href="{{ route('maintenances.index') }}" style="color: #997953; text-decoration: none; font-weight: 500;">&larr; Retour au planning</a>
    </div>

    {{-- Erreurs --}}
    @if ($errors->any())
        <div style="background: #fdf2f2; color: #dc3545; padding: 1rem; border-radius: 6px; margin-bottom: 1rem; border: 1px solid #fecaca;">
            <ul style="margin: 0; font-weight: 500;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Carte du Formulaire --}}
    <div class="card" style="background: white; padding: 2rem; border-radius: 8px; border: 1px solid #e2d1b9; box-shadow: 0 4px 6px -1px rgba(15, 30, 63, 0.1);">
        <form action="{{ route('maintenances.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 1.5rem;">
                {{-- Sélection Ressource --}}
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Ressource à maintenir</label>
                    <select name="resource_id" required style="width: 100%; padding: 0.6rem; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f; background-color: #fdfaf5;">
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
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Date début</label>
                        <input type="datetime-local" name="start_date" value="{{ old('start_date', now()->format('Y-m-d\TH:i')) }}" required style="width: 100%; padding: 0.6rem; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;">
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Date fin (est.)</label>
                        <input type="datetime-local" name="end_date" value="{{ old('end_date', now()->addHours(2)->format('Y-m-d\TH:i')) }}" required style="width: 100%; padding: 0.6rem; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;">
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold; color: #0f1e3f;">Raison / Détails des travaux</label>
                <textarea name="reason" rows="4" required placeholder="Ex: Mise à jour noyau, remplacement disque, nettoyage poussière..." style="width: 100%; padding: 0.7rem; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f; font-family: inherit;">{{ old('reason') }}</textarea>
            </div>

            {{-- Info Box (Thème Crème/Bleu) --}}
            <div style="background: #fdfaf5; padding: 1rem; border-radius: 4px; border-left: 4px solid #997953; margin-bottom: 2rem;">
                <p style="margin: 0; color: #213a56; font-size: 0.95rem;">
                    <strong>Information :</strong> En validant, la ressource passera automatiquement en statut <strong style="color: #997953;">"Maintenance"</strong>.
                </p>
            </div>

            {{-- Bouton (Thème Bleu Nuit / Hover Doré simulé par le style) --}}
            <div style="text-align: right;">
                <button type="submit" style="background: #424665; color: white; padding: 0.8rem 2.5rem; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; font-size: 1rem; transition: background 0.3s ease;">
                    Valider la planification
                </button>
            </div>
        </form>
    </div>
</div>
@endsection