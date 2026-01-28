@extends('layouts.admin')

@section('title', 'Gestion des Ressources')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Gestion des Ressources</h1>
        <a href="{{ route('admin.resources.create') }}" class="btn btn-primary">
            + Ajouter une ressource
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Caractéristiques</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resources as $resource)
                        <tr>
                            <td>
                                <div class="resource-info">
                                    <strong>{{ $resource->name }}</strong>
                                    @if($resource->description)
                                        <br><small class="text-muted">{{ Str::limit($resource->description, 50) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="category-badge">
                                    {{ $resource->category->name ?? 'Non définie' }}
                                </span>
                            </td>
                            <td>
                                <div class="specs-list">
                                    @if($resource->cpu)<span>CPU: {{ $resource->cpu }}</span>@endif
                                    @if($resource->ram)<span>RAM: {{ $resource->ram }}</span>@endif
                                    @if($resource->storage)<span>Stockage: {{ $resource->storage }}</span>@endif
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $resource->status }}">
                                    {{ $resource->status == 'active' ? 'Actif' : 
                                       ($resource->status == 'inactive' ? 'Inactif' : 'Maintenance') }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.resources.edit', $resource) }}" 
                                       class="btn btn-sm btn-outline">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('admin.resources.destroy', $resource) }}" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette ressource ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="empty-state">
                                    <h4>Aucune ressource trouvée</h4>
                                    <p>Commencez par ajouter une ressource au système.</p>
                                    <a href="{{ route('admin.resources.create') }}" class="btn btn-primary">
                                        Ajouter une ressource
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($resources->hasPages())
            <div class="pagination-wrapper">
                {{ $resources->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.resource-info strong {
    color: #2d3748;
    font-weight: 600;
}

.resource-info .text-muted {
    color: #718096;
    font-size: 12px;
}

.category-badge {
    background: #e0e7ff;
    color: #3730a3;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.specs-list {
    display: flex;
    flex-direction: column;
    gap: 2px;
    font-size: 12px;
    color: #4a5568;
}

.specs-list span {
    background: #f7fafc;
    padding: 2px 6px;
    border-radius: 4px;
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-active {
    background: #c6f6d5;
    color: #22543d;
}

.status-inactive {
    background: #fed7d7;
    color: #742a2a;
}

.status-maintenance {
    background: #feebc8;
    color: #7c2d12;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #718096;
}

.empty-state h4 {
    color: #4a5568;
    margin-bottom: 10px;
}

.empty-state p {
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    border-left: 4px solid #28a745;
}
</style>
@endpush
@endsection
