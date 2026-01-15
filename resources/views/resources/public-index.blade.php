{{-- resources/views/resources/public-index.blade.php --}}
{{-- Auteur : OUARDA --}}

@extends('layouts.guest')

@section('title', 'Ressources disponibles')

@section('content')
<div class="container">
    <h1>Ressources du Data Center</h1>
    
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
        
        <button type="submit">Filtrer</button>
    </form>
    
    {{-- Liste des ressources --}}
    <div class="resources-grid">
        @forelse($resources as $resource)
            <div class="resource-card">
                <h3>{{ $resource->name }}</h3>
                <p><strong>Catégorie :</strong> {{ $resource->category->name }}</p>
                <p>{{ Str::limit($resource->description, 100) }}</p>
                <span class="badge-success">Disponible</span>
                <a href="{{ route('login') }}">Connectez-vous pour réserver</a>
            </div>
        @empty
            <p>Aucune ressource disponible.</p>
        @endforelse
    </div>
    
    {{ $resources->links() }}
</div>
@endsection