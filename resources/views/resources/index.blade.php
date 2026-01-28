{{-- resources/views/resources/index.blade.php --}}
@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container" style="color: #0f1e3f; max-width: 1400px; margin: 0 auto; padding: 2rem;">
    <div class="resources-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #997953; padding-bottom: 1rem;">
        <h1 style="color: #0f1e3f; margin: 0; font-size: 2.5rem; font-weight: 700;">
            @can('admin')
                Gestion de l'Inventaire
            @else
                Infrastructure du Data Center
            @endcan
        </h1>
        @can('create', App\Models\Resource::class)
            <a href="{{ route('resources.create') }}" class="btn btn-primary" style="background: #424665; color: white; padding: 0.8rem 1.5rem; border-radius: 12px; text-decoration: none; font-weight: 600; border: 1px solid #0f1e3f; transition: all 0.3s ease;"><i class="fas fa-plus-circle"></i> Ajouter</a>
        @endcan
    </div>
    
    <form method="GET" class="filters-bar" style="display: flex; gap: 15px; margin-bottom: 2rem; background: #fdfaf5; padding: 1.5rem; border-radius: 12px; border: 1px solid #e2d1b9; flex-wrap: wrap;">
        <label style="position: relative; flex-grow: 1; min-width: 250px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #997953;"></i>
            <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}" style="padding: 0.8rem 0.8rem 0.8rem 45px; width: 100%; border: 1px solid #e2d1b9; border-radius: 8px; color: #0f1e3f; font-size: 1rem;">
        </label>
        <select name="category_id" style="padding: 0.8rem; border: 1px solid #e2d1b9; border-radius: 8px; background: white; color: #0f1e3f; font-size: 1rem; min-width: 150px;">
            <option value="">Catégorie</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <select name="status" style="padding: 0.8rem; border: 1px solid #e2d1b9; border-radius: 8px; background: white; color: #0f1e3f; font-size: 1rem; min-width: 150px;">
            <option value="">Statut</option>
            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
            <option value="busy" {{ request('status') == 'busy' ? 'selected' : '' }}>Occupée</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
        <button type="submit" class="btn-filter" style="background: #997953; color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;"><i class="fas fa-filter"></i> Filtrer</button>
    </form>
    
    <div class="table-container" style="background: white; border-radius: 12px; border: 1px solid #e2d1b9; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
        <table class="resource-table" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #7c89a7ff; color: white;">
                <tr>
                    <th style="padding: 1.2rem 1rem; border-bottom: 2px solid #997953; font-weight: 600;"><i class="fas fa-hashtag"></i> ID</th>
                    <th style="padding: 1.2rem 1rem; border-bottom: 2px solid #997953; font-weight: 600;"><i class="fas fa-server"></i> Nom</th>
                    <th style="padding: 1.2rem 1rem; border-bottom: 2px solid #997953; font-weight: 600;"><i class="fas fa-microchip"></i> CPU / <i class="fas fa-memory"></i> RAM</th>
                    <th style="padding: 1.2rem 1rem; border-bottom: 2px solid #997953; font-weight: 600;"><i class="fas fa-signal"></i> Statut</th>
                    <th style="padding: 1.2rem 1rem; border-bottom: 2px solid #997953; font-weight: 600;"><i class="fas fa-tools"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                    <tr style="border-bottom: 1px solid #e2d1b9; transition: background-color 0.3s ease;">
                        <td style="padding: 1.2rem 1rem; color: #997953; font-weight: 600; font-size: 0.9rem;">#{{ $resource->id }}</td>
                        <td style="padding: 1.2rem 1rem;">
                            <strong style="color: #0f1e3f; font-size: 1.1rem; display: block; margin-bottom: 0.3rem;">{{ $resource->name }}</strong>
                            <small style="color: #666; font-size: 0.85rem;">{{ $resource->category->name ?? 'Non catégorisé' }}</small>
                        </td>
                        <td style="padding: 1.2rem 1rem; color: #213a56; font-size: 0.95rem;">
                            <div style="display: flex; flex-direction: column; gap: 0.2rem;">
                                <span><i class="fas fa-microchip" style="color: #997953; margin-right: 5px;"></i>{{ $resource->cpu }}</span>
                                <span><i class="fas fa-memory" style="color: #997953; margin-right: 5px;"></i>{{ $resource->ram }}</span>
                            </div>
                        </td>
                        <td style="padding: 1.2rem 1rem;">
                            @php
                                $statusColor = match($resource->status) {
                                    'available' => '#0c8528ff',
                                    'maintenance' => '#997953',
                                    'busy' => '#0f1e3f',
                                    default => '#666'
                                };
                            @endphp
                            <span class="status-badge status-{{ $resource->status }}" style="padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; background: #fdfaf5; border: 1px solid {{ $statusColor }}; color: {{ $statusColor }}; display: inline-block;">
                                {{ $resource->status }}
                            </span>
                        </td>
                        <td style="padding: 1.2rem 1rem;">
                            <div class="table-actions" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                <a href="{{ route('resources.show', $resource) }}" class="btn btn-sm" style="color: #0f1e3f; text-decoration: none; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 6px; border: 1px solid #e2d1b9; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 5px;"><i class="fas fa-eye"></i> Détails</a>
                                @can('update', $resource)
                                    <a href="{{ route('resources.edit', $resource) }}" class="btn btn-sm" style="color: #997953; text-decoration: none; font-weight: 600; padding: 0.4rem 0.8rem; border-radius: 6px; border: 1px solid #997953; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 5px;"><i class="fas fa-edit"></i> Editer</a>
                                @endcan
                                @can('delete', $resource)
                                    <form action="{{ route('resources.destroy', $resource) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer cette ressource ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="color: #dc3545; background: none; border: 1px solid #dc3545; cursor: pointer; padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600; transition: all 0.3s ease;" title="Supprimer">
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

<style>
.btn-primary:hover {
    background: #0f1e3f !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(66, 70, 101, 0.3);
}

.btn-filter:hover {
    background: #0f1e3f !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(153, 121, 83, 0.3);
}

.btn-sm:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

tr:hover {
    background-color: #fdfaf5;
}

.resource-table {
    font-size: 0.95rem;
}

/* Responsive */
@media (max-width: 768px) {
    .resources-container {
        padding: 1rem;
    }
    
    .resources-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .filters-bar {
        flex-direction: column;
    }
    
    .table-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .resource-table {
        font-size: 0.85rem;
    }
    
    th, td {
        padding: 0.8rem 0.5rem !important;
    }
}
</style>
@endsection