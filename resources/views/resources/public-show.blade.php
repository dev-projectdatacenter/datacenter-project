@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resource-detail">
    <a href="{{ route('resources.public') }}" class="btn btn-back">← Retour à la liste</a>
    
    <div class="resource-card">
        <h1>{{ $resource->name }}</h1>
        <p class="resource-category">{{ $resource->category->name }}</p>
        
        <div class="resource-status">
            <span class="status-badge status-{{ $resource->status }}">
                {{ ucfirst($resource->status) }}
            </span>
        </div>
        
        <div class="resource-specs">
            <div class="spec">
                <h3>Processeur</h3>
                <p>{{ $resource->cpu }}</p>
            </div>
            <div class="spec">
                <h3>Mémoire RAM</h3>
                <p>{{ $resource->ram }}</p>
            </div>
            <div class="spec">
                <h3>Stockage</h3>
                <p>{{ $resource->storage }}</p>
            </div>
        </div>
        
        @if($resource->description)
            <div class="resource-description">
                <h3>Description</h3>
                <p>{{ $resource->description }}</p>
            </div>
        @endif
    </div>
    
    @auth
        <div class="resource-actions">
            <a href="{{ route('reservations.create', ['resource' => $resource->id]) }}" class="btn btn-primary">
                Réserver cette ressource
            </a>
        </div>
    @else
        <div class="alert alert-info">
            <p>Vous devez être connecté pour réserver cette ressource.</p>
            <a href="{{ route('login') }}" class="btn btn-secondary">Se connecter</a>
        </div>
    @endauth
</div>

<style>
.resource-detail {
    max-width: 800px;
    margin: 2rem auto;
    padding: 1rem;
}

.resource-card {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.resource-category {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}

.resource-status {
    margin: 1.5rem 0;
}

.status-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-available {
    background-color: #e3f9e5;
    color: #1b5e20;
}

.status-in_use {
    background-color: #fff3e0;
    color: #e65100;
}

.status-maintenance {
    background-color: #ffebee;
    color: #c62828;
}

.resource-specs {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
}

.spec {
    text-align: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 6px;
}

.spec h3 {
    margin-top: 0;
    color: #444;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.spec p {
    margin: 0.5rem 0 0;
    font-size: 1.2rem;
    font-weight: 600;
    color: #1a237e;
}

.resource-description {
    margin: 2rem 0;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 4px solid #3f51b5;
}

.resource-description h3 {
    margin-top: 0;
    color: #3f51b5;
}

.resource-actions {
    text-align: center;
    margin: 2rem 0;
}

.btn {
    display: inline-block;
    padding: 0.6rem 1.2rem;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-back {
    color: #3f51b5;
    margin-bottom: 1.5rem;
    display: inline-block;
}

.btn-back:hover {
    text-decoration: underline;
}

.btn-primary {
    background-color: #3f51b5;
    color: white;
    border: none;
    padding: 0.8rem 2rem;
    font-size: 1.1rem;
}

.btn-primary:hover {
    background-color: #303f9f;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.alert {
    padding: 1rem;
    border-radius: 4px;
    margin: 1.5rem 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.alert-info {
    background-color: #e3f2fd;
    color: #0d47a1;
}

.btn-secondary {
    background-color: #f5f5f5;
    color: #333;
    border: 1px solid #ddd;
}

.btn-secondary:hover {
    background-color: #e0e0e0;
}
</style>
@endsection
