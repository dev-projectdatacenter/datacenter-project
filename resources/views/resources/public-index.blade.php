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
                    @if($resource->category->image_url)
                        <img src="{{ asset($resource->category->image_url) }}" alt="{{ $resource->category->name }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                    @else
                        <div class="resource-icon">
                            <i class="fas fa-server"></i>
                        </div>
                    @endif
                </div>
                <div class="resource-content">
                    <h3>{{ $resource->name }}</h3>
                    <p><strong>{{ $resource->category->name }}</strong></p>
                    <div style="margin: 15px 0;">
                        <span class="status-badge status-{{ $resource->status }}">{{ $resource->status }}</span>
                    </div>
                    <p><small>{{ $resource->cpu }} / {{ $resource->ram }}</small></p>
                    <a href="{{ route('resources.public.show', $resource) }}" class="btn btn-filter" style="display: block; text-align: center; margin-top: 15px;">Voir plus</a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.resource-image {
    width: 100%;
    height: 150px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 8px 8px 0 0;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.resource-icon {
    font-size: 3rem;
    color: white;
}

.resource-content {
    padding: 20px;
}

.resource-card {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.resource-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}
</style>
@endsection