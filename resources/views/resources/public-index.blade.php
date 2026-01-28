@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <h1>Toutes les Ressources</h1>
    
    <div class="resources-grid">
        @foreach($resources as $resource)
            <div class="resource-card">
                <div class="resource-image">
                    @if($resource->image_url) {{-- Utiliser l'image de la ressource si elle existe --}}
                        <img src="{{ asset($resource->image_url) }}" alt="{{ $resource->name }}">
                    @elseif($resource->category && $resource->category->image_url)
                        <img src="{{ asset($resource->category->image_url) }}" alt="{{ $resource->category->name }}">
                    @else
                        <div class="resource-icon">
                            <i class="fas fa-server"></i>
                        </div>
                    @endif
                </div>
                <div class="resource-content">
                    <h3>{{ $resource->name }}</h3>
                    <p class="category-name">{{ $resource->category->name ?? 'N/A' }}</p>
                    <span class="status-badge status-{{ strtolower($resource->status) }}">{{ $resource->status }}</span>
                    <p class="specs">{{ $resource->cpu }} / {{ $resource->ram }}</p>
                    <a href="{{ route('resources.public.show', $resource) }}" class="btn-view-more">Voir plus</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.resources-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

.resources-container h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 2rem;
    text-align: center;
}

.resources-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}


.resource-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
}

.resource-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.resource-image {
    width: 100%;
    height: 180px;
    background: #f0f2f5;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.resource-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.resource-card:hover .resource-image img {
    transform: scale(1.05);
}

.resource-icon {
    font-size: 4rem;
    color: white;
    opacity: 0.9;
}

.resource-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.resource-content h3 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 0.25rem 0;
}

.category-name {
    font-size: 0.85rem;
    color: #718096;
    margin: 0 0 1rem 0;
}

.specs {
    font-size: 0.85rem;
    color: #718096;
    margin: 0 0 1.5rem 0;
    flex-grow: 1;
}

.resource-content strong {
    color: #2d3748;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
    align-self: flex-start;
}

.status-available {
    background: #10b981;
    color: white;
}

.status-busy {
    background: #f59e0b;
    color: white;
}

.status-maintenance {
    background: #ef4444;
    color: white;
}

.status-out_of_service {
    background: #6b7280;
    color: white;
}

.btn-view-more {
    background: #1a1a1a;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    display: block;
    text-align: center;
    margin-top: auto;
}

.btn-view-more:hover {
    background: #2d2d2d;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 26, 26, 0.4);
}

.btn-filter {
    background: #1a1a1a;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-block;
    text-align: center;
}

.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26, 26, 26, 0.4);
    color: white;
    text-decoration: none;
    background: #2d2d2d;
}

/* Responsive (adjustments are now part of the main grid styles) */
@media (max-width: 768px) {
    
    .resources-container {
        padding: 1rem;
    }
    
    .resources-container h1 {
        font-size: 2rem;
    }
}
</style>
@endsection