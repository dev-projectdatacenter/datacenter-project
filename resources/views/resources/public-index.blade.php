@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <h1>Nos Ressources Disponibles</h1>
    
    <div class="resources-grid">
        @foreach($resources as $resource)
            <div class="resource-card">
                <h3>{{ $resource->name }}</h3>
                <p><strong>{{ $resource->category->name }}</strong></p>
                <div style="margin: 15px 0;">
                    <span class="status-badge status-{{ $resource->status }}">{{ $resource->status }}</span>
                </div>
                <p><small>{{ $resource->cpu }} / {{ $resource->ram }}</small></p>
                <a href="{{ route('resources.show', $resource) }}" class="btn btn-filter" style="display: block; text-align: center; margin-top: 15px;">Voir plus</a>
            </div>
        @endforeach
    </div>
</div>
@endsection