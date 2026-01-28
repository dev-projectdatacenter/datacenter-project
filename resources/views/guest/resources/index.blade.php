@extends('layouts.app')

@section('title', 'Ressources du Data Center')

@section('content')
<div class="guest-resources">
    <div class="guest-header">
        <h1>Ressources du Data Center</h1>
        <p>Découvrez notre catalogue de ressources disponibles</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="resources-stats">
        <div class="stat-item">
            <span class="stat-number">{{ $resources->total() }}</span>
            <span class="stat-label">Ressources affichées</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">{{ \App\Models\Resource::where('status', 'active')->count() }}</span>
            <span class="stat-label">Disponibles</span>
        </div>
    </div>

    <div class="resources-grid">
        @forelse($resources as $resource)
            <div class="resource-card">
                <div class="resource-header">
                    <h3>{{ $resource->name }}</h3>
                    <span class="category-badge">{{ $resource->category->name ?? 'Non catégorisé' }}</span>
                </div>
                
                <div class="resource-specs">
                    @if($resource->cpu)
                        <div class="spec-item">
                            <span class="spec-label">CPU:</span>
                            <span class="spec-value">{{ $resource->cpu }}</span>
                        </div>
                    @endif
                    
                    @if($resource->ram)
                        <div class="spec-item">
                            <span class="spec-label">RAM:</span>
                            <span class="spec-value">{{ $resource->ram }}</span>
                        </div>
                    @endif
                    
                    @if($resource->storage)
                        <div class="spec-item">
                            <span class="spec-label">Stockage:</span>
                            <span class="spec-value">{{ $resource->storage }}</span>
                        </div>
                    @endif
                    
                    @if($resource->os)
                        <div class="spec-item">
                            <span class="spec-label">OS:</span>
                            <span class="spec-value">{{ $resource->os }}</span>
                        </div>
                    @endif
                </div>
                
                @if($resource->description)
                    <div class="resource-description">
                        <p>{{ Str::limit($resource->description, 100) }}</p>
                    </div>
                @endif
                
                <div class="resource-footer">
                    <div class="status-indicator">
                        <span class="status-dot active"></span>
                        <span class="status-text">Disponible</span>
                    </div>
                    <a href="{{ route('guest.resources.show', $resource) }}" class="view-btn">
                        Voir les détails →
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">🖥️</div>
                <h3>Aucune ressource disponible</h3>
                <p>Les ressources du Data Center seront bientôt disponibles.</p>
            </div>
        @endforelse
    </div>

    @if($resources->hasPages())
        <div class="pagination-wrapper">
            {{ $resources->links() }}
        </div>
    @endif
</div>

@push('styles')
<style>
.guest-resources {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.guest-header {
    text-align: center;
    margin-bottom: 40px;
}

.guest-header h1 {
    color: #2d3748;
    font-size: 36px;
    margin-bottom: 10px;
}

.guest-header p {
    color: #718096;
    font-size: 18px;
}

.resources-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-bottom: 40px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 12px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 32px;
    font-weight: bold;
    color: #3b82f6;
}

.stat-label {
    color: #718096;
    font-size: 14px;
}

.resources-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.resource-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.resource-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.resource-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.resource-header h3 {
    color: #2d3748;
    font-size: 20px;
    margin: 0;
}

.category-badge {
    background: #e0e7ff;
    color: #3730a3;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.resource-specs {
    margin-bottom: 20px;
}

.spec-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
}

.spec-item:last-child {
    border-bottom: none;
}

.spec-label {
    color: #64748b;
    font-weight: 600;
}

.spec-value {
    color: #2d3748;
}

.resource-description {
    margin-bottom: 20px;
    color: #4a5568;
    line-height: 1.6;
}

.resource-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.status-dot.active {
    background: #10b981;
}

.status-text {
    color: #059669;
    font-size: 14px;
    font-weight: 600;
}

.view-btn {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.view-btn:hover {
    color: #2563eb;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #718096;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.empty-state h3 {
    color: #4a5568;
    margin-bottom: 10px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    border-left: 4px solid #28a745;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

@media (max-width: 768px) {
    .guest-resources {
        padding: 15px;
    }
    
    .resources-stats {
        flex-direction: column;
        gap: 20px;
    }
    
    .resources-grid {
        grid-template-columns: 1fr;
    }
    
    .resource-footer {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
}
</style>
@endpush
@endsection
