@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container" style="max-width: 1400px; margin: 0 auto; padding: 2rem;">
    <div class="resources-header" style="border-bottom: 2px solid #997953; margin-bottom: 2rem; padding-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
        <h1 style="color: #0f1e3f; margin: 0; font-size: 2.5rem; font-weight: 700;"><i class="fas fa-server"></i> Détails : {{ $resource->name }}</h1>
        <a href="{{ route('resources.index') }}" class="btn" style="color: #997953; text-decoration: none; font-weight: 600; padding: 0.8rem 1.5rem; border: 1px solid #997953; border-radius: 8px; transition: all 0.3s ease;"><i class="fas fa-arrow-left"></i>Retour</a>
    </div>

    <div class="details-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2rem;">
        <div class="info-card" style="background: white; padding: 2rem; border: 1px solid #e2d1b9; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
            @if($resource->category->image_url)
                <div style="text-align: center; margin-bottom: 2rem;">
                    <img src="{{ asset($resource->category->image_url) }}" alt="{{ $resource->category->name }}" style="width: 100%; max-height: 300px; object-fit: cover; border-radius: 12px;">
                </div>
            @endif
            
            <h3 style="color: #0f1e3f; font-size: 1.5rem; margin-bottom: 1.5rem;"><i class="fas fa-info-circle"></i> Spécifications</h3>
            <ul class="specs-list" style="list-style: none; padding: 0;">
                <li style="padding: 0.8rem 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center;"><i class="fas fa-microchip" style="width: 24px; color: #997953; margin-right: 12px;"></i> <strong style="min-width: 120px;">Processeur :</strong> {{ $resource->cpu }}</li>
                <li style="padding: 0.8rem 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center;"><i class="fas fa-memory" style="width: 24px; color: #997953; margin-right: 12px;"></i> <strong style="min-width: 120px;">RAM :</strong> {{ $resource->ram }}</li>
                <li style="padding: 0.8rem 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center;"><i class="fas fa-network-wired" style="width: 24px; color: #997953; margin-right: 12px;"></i> <strong style="min-width: 120px;">Bande Passante :</strong> {{ $resource->bandwidth ?? 'N/A' }}</li>
                <li style="padding: 0.8rem 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center;"><i class="fas fa-hdd" style="width: 24px; color: #997953; margin-right: 12px;"></i> <strong style="min-width: 120px;">Stockage :</strong> {{ $resource->storage }}</li>
                <li style="padding: 0.8rem 0; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center;"><i class="fas fa-window-maximize" style="width: 24px; color: #997953; margin-right: 12px;"></i> <strong style="min-width: 120px;">OS :</strong> {{ $resource->os }}</li>
            </ul>
            <p style="margin-top: 1.5rem; border-top: 1px solid #fdfaf5; padding-top: 1rem; display: flex; align-items: center;"><i class="fas fa-map-marker-alt" style="color: #997953; margin-right: 12px;"></i> <strong>Localisation :</strong> {{ $resource->location }}</p>
        </div>

        <div>
            <div class="info-card" style="margin-bottom: 1.5rem; background: white; padding: 2rem; border: 1px solid #0f1e3f; border-radius: 16px; text-align: center; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
                <h3 style="color: #0f1e3f; font-size: 1.5rem; margin-bottom: 1rem;"><i class="fas fa-chart-line"></i> Statut</h3>
                @php
                    $statusColor = match($resource->status) {
                        'available' => '#0c8528ff',
                        'maintenance' => '#997953',
                        'busy' => '#0f1e3f',
                        default => '#666'
                    };
                @endphp
                <span class="status-badge status-{{ $resource->status }}" style="padding: 8px 20px; border-radius: 25px; background: #fdfaf5; border: 2px solid {{ $statusColor }}; color: {{ $statusColor }}; font-weight: 600; font-size: 1rem; display: inline-block;">{{ $resource->status }}</span>
            </div>
            
            <a href="{{ route('incidents.report', $resource) }}" class="btn" style="background: #a58b6cff; color: white; display: block; text-align: center; margin-bottom: 1rem; padding: 1rem; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
                <i class="fas fa-exclamation-triangle"></i> Signaler Problème
            </a>
            
            @can('update', $resource)
                <a href="{{ route('resources.edit', $resource) }}" class="btn" style="background: #424665; color: white; display: block; text-align: center; padding: 1rem; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
                    <i class="fas fa-edit"></i> Modifier
                </a>
            @endcan
        </div>
    </div>

    <!-- Comments section -->
    <div class="info-card" style="margin-top: 2rem; background: white; padding: 2rem; border: 1px solid #e2d1b9; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
        <h3 style="color: #0f1e3f; font-size: 1.5rem; margin-bottom: 1.5rem;"><i class="fas fa-comments"></i> Discussions et Questions</h3>
        
        <form action="{{ route('comments.store', $resource) }}" method="POST" style="background: #fdfaf5; padding: 2rem; border-radius: 12px; border: 1px solid #e2d1b9;">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.8rem; font-weight: 600; color: #0f1e3f; font-size: 1.1rem;">Poser une question ou laisser une alerte :</label>
                <textarea name="content" rows="4" style="width: 100%; padding: 1rem; border: 1px solid #e2d1b9; border-radius: 8px; font-family: inherit; color: #0f1e3f; font-size: 1rem; resize: vertical;" required placeholder="Écrivez votre message ici..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="background: #0f1e3f; color: white; border: none; padding: 1rem 2rem; border-radius: 8px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;"><i class="fas fa-paper-plane"></i> Envoyer le message</button>
        </form>
    </div>
    </div>
</div>

<style>
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-primary:hover {
    background: #1a2f5a !important;
}

/* Responsive */
@media (max-width: 768px) {
    .resources-container {
        padding: 1rem;
    }
    
    .details-grid {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }
    
    .resources-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .resources-header h1 {
        font-size: 2rem !important;
    }
}
</style>
@endsection