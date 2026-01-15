@extends('layouts.app')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1>Signaler un incident</h1>
        <p style="color: #666;">Ressource : <strong>{{ $resource->name }}</strong> ({{ $resource->category->name }})</p>
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
            <input type="hidden" name="resource_id" value="{{ $resource->id }}">

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Description du problème</label>
                <textarea name="description" rows="6" required placeholder="Décrivez précisément l'incident (ex: serveur injoignable, fumée, message d'erreur spécifique...)" style="width: 100%; padding: 0.7rem; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;">{{ old('description') }}</textarea>
                <small style="color: #666;">Minimum 10 caractères.</small>
            </div>

            <div style="background: #fdf6ec; border-left: 5px solid #e6a23c; padding: 1rem; margin-bottom: 1.5rem; color: #856404;">
                <p style="margin: 0;"><strong>Note :</strong> Ce signalement sera transmis immédiatement aux techniciens (Chaymae). Le statut de la ressource pourrait passer en "Maintenance" si nécessaire.</p>
            </div>

            <div style="text-align: right;">
                <a href="{{ route('resources.show', $resource) }}" style="text-decoration: none; color: #666; margin-right: 1.5rem;">Annuler</a>
                <button type="submit" style="background: #e67e22; color: white; padding: 0.8rem 2.5rem; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    Envoyer le rapport d'incident
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
