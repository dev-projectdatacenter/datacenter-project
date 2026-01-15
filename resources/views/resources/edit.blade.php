@extends('layouts.app')

@section('content')
<div class="container">
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Modifier la ressource : {{ $resource->name }}</h1>
        <a href="{{ route('resources.index') }}" class="btn-secondary">Retour à la liste</a>
    </div>

    @if ($errors->any())
        <div class="alert-error" style="background: #fee; border: 1px solid #f99; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="background: #fff; padding: 2rem; border-radius: 8px; border: 1px solid #ddd;">
        <form action="{{ route('resources.update', $resource) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                {{-- Informations de base --}}
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Nom de la ressource</label>
                    <input type="text" name="name" value="{{ old('name', $resource->name) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Catégorie</label>
                    <select name="category_id" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $resource->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Statut</label>
                    <select name="status" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="available" {{ old('status', $resource->status) == 'available' ? 'selected' : '' }}>Disponible</option>
                        <option value="busy" {{ old('status', $resource->status) == 'busy' ? 'selected' : '' }}>Occupée (Réservée)</option>
                        <option value="maintenance" {{ old('status', $resource->status) == 'maintenance' ? 'selected' : '' }}>En maintenance</option>
                        <option value="hors_service" {{ old('status', $resource->status) == 'hors_service' ? 'selected' : '' }}>Hors service</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Localisation</label>
                    <input type="text" name="location" value="{{ old('location', $resource->location) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #eee;">
            <h3 style="margin-bottom: 1rem;">Spécifications techniques</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">CPU</label>
                    <input type="text" name="cpu" value="{{ old('cpu', $resource->cpu) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">RAM</label>
                    <input type="text" name="ram" value="{{ old('ram', $resource->ram) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Stockage</label>
                    <input type="text" name="storage" value="{{ old('storage', $resource->storage) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">OS</label>
                    <input type="text" name="os" value="{{ old('os', $resource->os) }}" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-top: 2rem; border-top: 1px solid #eee; padding-top: 1.5rem; text-align: right;">
                <button type="submit" style="background: #3498db; color: white; padding: 0.7rem 2rem; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    Mettre à jour la ressource
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
