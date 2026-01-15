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
    <form method="GET" class="filters">
        <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}">
        
        <select name="category_id">
            <option value="">Toutes les catégories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        
        <select name="status">
            <option value="">Tous les statuts</option>
            <option value="disponible" {{ request('status') == 'disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="reservee" {{ request('status') == 'reservee' ? 'selected' : '' }}>Réservée</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            <option value="hors_service" {{ request('status') == 'hors_service' ? 'selected' : '' }}>Hors service</option>
        </select>
        
        <button type="submit">Filtrer</button>
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
                        <small>{{ Str::limit($resource->description, 50) }}</small>
                    </td>
                    <td>{{ $resource->category->name }}</td>
                    <td>
                        <span class="badge badge-{{ $resource->status }}">
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