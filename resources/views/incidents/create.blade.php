@extends('layouts.app')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1>Signaler un incident</h1>
        @if($resource)
            <p style="color: #666;">Ressource : <strong>{{ $resource->name }}</strong> ({{ $resource->category->name ?? 'N/A' }})</p>
        @else
            <p style="color: #666;">Veuillez sélectionner la ressource concernée.</p>
        @endif
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
        <form action="{{ route('incidents.store') }}" method="POST">
            @csrf
            
            @if($resource)
                <input type="hidden" name="resource_id" value="{{ $resource->id }}">
            @else
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Ressource concernée</label>
                    <select name="resource_id" required class="form-control">
                        <option value="">-- Sélectionner une ressource --</option>
                        @foreach($resources as $res)
                            <option value="{{ $res->id }}" {{ old('resource_id') == $res->id ? 'selected' : '' }}>
                                {{ $res->name }} ({{ $res->category->name ?? 'Sans catégorie' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Gravité de l'incident</label>
                <select name="severity" required class="form-control">
                    <option value="">-- Sélectionner la gravité --</option>
                    <option value="low" {{ old('severity') == 'low' ? 'selected' : '' }}>Faible</option>
                    <option value="medium" {{ old('severity') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                    <option value="high" {{ old('severity') == 'high' ? 'selected' : '' }}>Élevée</option>
                    <option value="critical" {{ old('severity') == 'critical' ? 'selected' : '' }}>Critique</option>
                </select>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Description du problème</label>
                <textarea name="description" rows="6" required placeholder="Décrivez précisément l'incident (ex: serveur injoignable, fumée, message d'erreur spécifique...)" class="form-control" style="font-family: inherit;">{{ old('description') }}</textarea>
                <small style="color: #666;">Minimum 10 caractères.</small>
            </div>

            <div style="background: #fdf6ec; border-left: 5px solid #e6a23c; padding: 1rem; margin-bottom: 1.5rem; color: #856404;">
                <p style="margin: 0;"><strong>Note :</strong> Ce signalement sera transmis immédiatement aux techniciens (Chaymae). Le statut de la ressource pourrait passer en "Maintenance" si nécessaire.</p>
            </div>

            <div style="text-align: right;">
                <a href="{{ $resource ? route('resources.show', $resource) : route('incidents.index') }}" style="text-decoration: none; color: #666; margin-right: 1.5rem;">Annuler</a>
                <button type="submit" class="btn btn-primary" style="background: #e67e22; padding: 0.8rem 2.5rem; border: none;">
                    Envoyer le rapport d'incident
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
