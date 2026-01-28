{{-- resources/views/resources/index.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container" style="color: #0f1e3f;">
    <div class="resources-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #997953; padding-bottom: 1rem;">
        <h1 style="color: #0f1e3f; margin: 0;">
            @can('admin')
                Gestion de l'Inventaire
            @else
                Infrastructure du Data Center
            @endcan
        </h1>
        @can('create', App\Models\Resource::class)
            <a href="{{ route('resources.create') }}" class="btn btn-primary" style="background: #424665; color: white; padding: 0.6rem 1.2rem; border-radius: 10px; text-decoration: none; font-weight: bold; border: 1px solid #0f1e3f;"><i class="fas fa-plus-circle"></i> Ajouter</a>
        @endcan
    </div>
    
    <form method="GET" class="filters-bar" style="display: flex; gap: 10px; margin-bottom: 2rem; background: #fdfaf5; padding: 1rem; border-radius: 10px; border: 1px solid #e2d1b9;">
        <label style="position: relative; flex-grow: 1;">
            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #997953;"></i>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}" style="padding: 0.6rem 0.6rem 0.6rem 35px; width: 100%; border: 1px solid #e2d1b9; border-radius: 4px; color: #0f1e3f;">
        </label>
        <select name="category_id" style="padding: 0.6rem; border: 1px solid #e2d1b9; border-radius: 10px; background: white; color: #0f1e3f;">
            <option value="">Catégorie</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <select name="status" style="padding: 0.6rem; border: 1px solid #e2d1b9; border-radius: 10px; background: white; color: #0f1e3f;">
            <option value="">Statut</option>
            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
            <option value="busy" {{ request('status') == 'busy' ? 'selected' : '' }}>Occupée</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
        <button type="submit" class="btn-filter" style="background: #997953; color: white; border: none; padding: 0.6rem 1.2rem; border-radius: 4px; cursor: pointer; font-weight: bold;"><i class="fas fa-filter"></i> Filtrer</button>
    </form>
    
    <div class="table-container" style="background: white; border-radius: 8px; border: 1px solid #e2d1b9; overflow: hidden;">
        <table class="resource-table" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #7c89a7ff; color: white;">
                <tr>
                    <th style="padding: 1rem; border-bottom: 2px solid #997953;"><i class="fas fa-hashtag"></i> ID</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #997953;"><i class="fas fa-server"></i> Nom</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #997953;"><i class="fas fa-microchip"></i> CPU / <i class="fas fa-memory"></i> RAM</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #997953;"><i class="fas fa-signal"></i> Statut</th>
                    <th style="padding: 1rem; border-bottom: 2px solid #997953;"><i class="fas fa-tools"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                    <tr style="border-bottom: 1px solid #e2d1b9;">
                        <td style="padding: 1rem; color: #997953; font-weight: bold;">#{{ $resource->id }}</td>
                        <td style="padding: 1rem;"><strong style="color: #0f1e3f;">{{ $resource->name }}</strong></td>
                        <td style="padding: 1rem; color: #213a56;">{{ $resource->cpu }} / {{ $resource->ram }}</td>
                        <td style="padding: 1rem;">
                            @php
                                $statusColor = match($resource->status) {
                                    'available' => '#0c8528ff',
                                    'maintenance' => '#997953',
                                    'busy' => '#0f1e3f',
                                    default => '#666'
                                };
                            @endphp
                            <span class="status-badge status-{{ $resource->status }}" style="padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; background: #fdfaf5; border: 1px solid {{ $statusColor }}; color: {{ $statusColor }};">
                                {{ $resource->status }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <div class="table-actions" style="display: flex; gap: 10px; align-items: center;">
                                <a href="{{ route('resources.show', $resource) }}" class="btn btn-sm" style="color: #0f1e3f; text-decoration: none; font-weight: bold;"><i class="fas fa-eye"></i> Détails</a>
                                @can('update', $resource)
                                    <a href="{{ route('resources.edit', $resource) }}" class="btn btn-sm" style="color: #997953; text-decoration: none; font-weight: bold;"><i class="fas fa-edit"></i> Editer</a>
                                @endcan
                                @can('delete', $resource)
                                    <form action="{{ route('resources.destroy', $resource) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer cette ressource ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="color: #dc3545; background: none; border: none; cursor: pointer; padding: 0;" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection