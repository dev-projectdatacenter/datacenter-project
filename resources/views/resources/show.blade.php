@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header">
        <h1><i class="fas fa-server"></i> Détails : {{ $resource->name }}</h1>
        <a href="{{ route('resources.index') }}" class="btn"><i class="fas fa-arrow-left"></i> Retour</a>
    </div>

    <div class="details-grid">
        <div class="info-card">
            <h3><i class="fas fa-info-circle"></i> Spécifications</h3>
            <ul class="specs-list">
                <li><i class="fas fa-microchip" style="width: 20px;"></i> <strong>Processeur :</strong> {{ $resource->cpu }}</li>
                <li><i class="fas fa-memory" style="width: 20px;"></i> <strong>RAM :</strong> {{ $resource->ram }}</li>
                <li><i class="fas fa-hdd" style="width: 20px;"></i> <strong>Stockage :</strong> {{ $resource->storage }}</li>
                <li><i class="fas fa-window-maximize" style="width: 20px;"></i> <strong>OS :</strong> {{ $resource->os }}</li>
            </ul>
            <p><i class="fas fa-map-marker-alt"></i> <strong>Localisation :</strong> {{ $resource->location }}</p>
        </div>

        <div>
            <div class="info-card" style="margin-bottom: 20px;">
                <h3><i class="fas fa-chart-line"></i> Statut</h3>
                <span class="status-badge status-{{ $resource->status }}">{{ $resource->status }}</span>
            </div>
            
            <a href="{{ route('incidents.report', $resource) }}" class="btn" style="background: #f39c12; color: white; display: block; text-align: center; margin-bottom: 10px;">
                <i class="fas fa-exclamation-triangle"></i> Signaler Problème
            </a>
            
            @can('update', $resource)
                <a href="{{ route('resources.edit', $resource) }}" class="btn" style="background: #3498db; color: white; display: block; text-align: center;">
                    <i class="fas fa-edit"></i> Modifier
                </a>
            @endcan
        </div>
    </div>
</div>
@endsection
