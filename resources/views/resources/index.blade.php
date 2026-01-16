{{-- resources/views/resources/index.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1>Gestion des ressources</h1>
        <a href="{{ route('resources.create') }}" class="btn btn-primary">+ Ajouter</a>
    </div>
    
    <form method="GET" class="filters-bar">
        <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}">
        <select name="category_id">
            <option value="">Catégorie</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <select name="status">
            <option value="">Statut</option>
            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
            <option value="busy" {{ request('status') == 'busy' ? 'selected' : '' }}>Occupée</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
        <button type="submit" class="btn-filter">Filtrer</button>
    </form>
    
    <div class="table-container">
        <table class="resource-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>CPU / RAM</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                    <tr>
                        <td>#{{ $resource->id }}</td>
                        <td><strong>{{ $resource->name }}</strong></td>
                        <td>{{ $resource->cpu }} / {{ $resource->ram }}</td>
                        <td>
                            <span class="status-badge status-{{ $resource->status }}">
                                {{ $resource->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('resources.show', $resource) }}" class="btn btn-sm">Détails</a>
                            <a href="{{ route('resources.edit', $resource) }}" class="btn btn-sm" style="color: #3498db;">Editer</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection