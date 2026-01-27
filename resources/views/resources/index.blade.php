{{-- resources/views/resources/index.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1>
            @can('admin')
                Gestion de l'Inventaire
            @else
                Infrastructure du Data Center
            @endcan
        </h1>
        @can('create', App\Models\Resource::class)
            <a href="{{ route('resources.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Ajouter</a>
        @endcan
    </div>
    
    <form method="GET" class="filters-bar">
        <label style="position: relative; flex-grow: 1;">
            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #888;"></i>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}" style="padding-left: 35px; width: 100%;">
        </label>
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
        <button type="submit" class="btn-filter"><i class="fas fa-filter"></i> Filtrer</button>
    </form>
    
    <div class="table-container">
        <table class="resource-table">
            <thead>
                <tr>
                    <th><i class="fas fa-hashtag"></i> ID</th>
                    <th><i class="fas fa-server"></i> Nom</th>
                    <th><i class="fas fa-microchip"></i> CPU / <i class="fas fa-memory"></i> RAM</th>
                    <th><i class="fas fa-signal"></i> Statut</th>
                    <th><i class="fas fa-tools"></i> Actions</th>
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
                        </td>
                        <td>
                            <a href="{{ route('resources.show', $resource) }}" class="btn btn-sm"><i class="fas fa-eye"></i> Détails</a>
                            @can('update', $resource)
                                <a href="{{ route('resources.edit', $resource) }}" class="btn btn-sm" style="color: #3498db;"><i class="fas fa-edit"></i> Editer</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection