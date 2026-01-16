@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1>Détails : {{ $resource->name }}</h1>
        <a href="{{ route('resources.index') }}" class="btn">&larr; Retour</a>
    </div>

    <div class="details-grid">
        <div class="info-card">
            <h3>Spécifications</h3>
            <ul class="specs-list">
                <li><strong>Processeur :</strong> {{ $resource->cpu }}</li>
                <li><strong>RAM :</strong> {{ $resource->ram }}</li>
                <li><strong>Stockage :</strong> {{ $resource->storage }}</li>
                <li><strong>OS :</strong> {{ $resource->os }}</li>
            </ul>
            <p><strong>Localisation :</strong> {{ $resource->location }}</p>
        </div>

        <div>
            <div class="info-card" style="margin-bottom: 20px;">
                <h3>Statut</h3>
                <span class="status-badge status-{{ $resource->status }}">{{ $resource->status }}</span>
            </div>
            
            <a href="{{ route('incidents.report', $resource) }}" class="btn" style="background: #f39c12; color: white; display: block; text-align: center; margin-bottom: 10px;">Signaler Problème</a>
            <a href="{{ route('resources.edit', $resource) }}" class="btn" style="background: #3498db; color: white; display: block; text-align: center;">Modifier</a>
        </div>
    </div>
</div>
@endsection
