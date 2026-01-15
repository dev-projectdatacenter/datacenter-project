{{-- resources/views/resources/index.blade.php --}}
{{-- Auteur : OUARDA --}}

@extends('layouts.app')

@section('title', 'Gestion des ressources')

@section('content')
<div class="container">
    <div class="header">
        <h1>Gestion des ressources</h1>
        <a href="{{ route('resources.create') }}" class="btn-primary">+ Nouvelle ressource</a>
    </div>
    
    {{-- Messages --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif
    
    {{-- Filtres --}}
    <form method="GET" class="filters" style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 2rem; background: #f4f4f4; padding: 1rem; border-radius: 8px;">
        <input type="text" name="search" placeholder="Nom..." value="{{ request('search') }}" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
        
        <select name="category_id" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        
        <select name="status" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
            <option value="">Tous les statuts</option>
            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
            <option value="busy" {{ request('status') == 'busy' ? 'selected' : '' }}>Réservée</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            <option value="hors_service" {{ request('status') == 'hors_service' ? 'selected' : '' }}>Hors service</option>
        </select>

        <input type="text" name="cpu" placeholder="CPU..." value="{{ request('cpu') }}" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 100px;">
        <input type="text" name="ram" placeholder="RAM..." value="{{ request('ram') }}" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 100px;">
        <input type="text" name="os" placeholder="OS..." value="{{ request('os') }}" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 100px;">
        <input type="text" name="location" placeholder="Localisation..." value="{{ request('location') }}" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; width: 120px;">
        
        <button type="submit" style="background: #3498db; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer;">Filtrer</button>
        <a href="{{ route('resources.index') }}" style="text-decoration: none; color: #666; padding-top: 0.5rem;">Réinitialiser</a>
    </form>
    
    {{-- Table --}}
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resources as $resource)
                <tr>
                    <td>{{ $resource->id }}</td>
                    <td>
                        <strong>{{ $resource->name }}</strong><br>
                        <small style="color: #666;">Specs: {{ $resource->cpu ?? 'N/A' }} / {{ $resource->ram ?? 'N/A' }}</small>
                    </td>
                    <td>{{ $resource->category->name }}</td>
                    <td>
                        <span class="badge badge-{{ $resource->status }}" style="padding: 0.3rem 0.6rem; border-radius: 12px; font-size: 0.8rem; background: {{ $resource->status == 'available' ? '#d4edda' : ($resource->status == 'busy' ? '#fff3cd' : '#f8d7da') }}; color: {{ $resource->status == 'available' ? '#155724' : ($resource->status == 'busy' ? '#856404' : '#721c24') }}; font-weight: bold;">
                            {{ ucfirst($resource->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('resources.show', $resource) }}">👁️ Voir</a>
                        <a href="{{ route('resources.edit', $resource) }}">✏️ Modifier</a>
                        
                        <form action="{{ route('resources.destroy', $resource) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Êtes-vous sûr ?')">🗑️ Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucune ressource trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    {{ $resources->links() }}
</div>
@endsection