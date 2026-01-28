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
            <div class="specs-grid">
                <div class="spec-item">
                    <i class="fas fa-microchip"></i>
                    <div>
                        <strong>Processeur</strong>
                        <p>{{ $resource->cpu ?? 'Non spécifié' }}</p>
                    </div>
                </div>
                <div class="spec-item">
                    <i class="fas fa-memory"></i>
                    <div>
                        <strong>RAM</strong>
                        <p>{{ $resource->ram ?? 'Non spécifiée' }}</p>
                    </div>
                </div>
                <div class="spec-item">
                    <i class="fas fa-hdd"></i>
                    <div>
                        <strong>Stockage</strong>
                        <p>{{ $resource->storage ?? 'Non spécifié' }}</p>
                    </div>
                </div>
                <div class="spec-item">
                    <i class="fas fa-network-wired"></i>
                    <div>
                        <strong>Bande passante</strong>
                        <p>{{ $resource->bandwidth ?? 'Non spécifiée' }}</p>
                    </div>
                </div>
                <div class="spec-item">
                    <i class="fas fa-desktop"></i>
                    <div>
                        <strong>Système d'exploitation</strong>
                        <p>{{ $resource->os ?? 'Non spécifié' }}</p>
                    </div>
                </div>
                <div class="spec-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <strong>Localisation</strong>
                        <p>{{ $resource->location ?? 'Non spécifiée' }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($resource->description)
        <div class="resource-description">
            <h3>Description</h3>
            <p>{{ $resource->description }}</p>
        </div>
        @endif

        <div class="resource-meta">
            <div class="meta-item">
                <i class="fas fa-calendar-plus"></i>
                <span>Ajoutée le {{ $resource->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-clock"></i>
                <span>Dernière mise à jour {{ $resource->updated_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <div class="guest-notice">
            <div class="notice-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="notice-content">
                <h4>Vue Invité</h4>
                <p>Vous consultez cette ressource en mode lecture seule. Pour réserver cette ressource, 
                   <a href="{{ route('guest.request-account') }}">demandez un compte</a>.</p>
            </div>
        </div>

        <div class="action-links">
            <a href="{{ route('resources.public') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> Voir toutes les ressources
            </a>
            <a href="{{ route('guest.rules') }}" class="btn btn-secondary">
                <i class="fas fa-book"></i> Consulter les règles
            </a>
            <a href="{{ route('guest.request-account') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Demander un compte
            </a>
        </div>
    </div>
</div>

<style>
.resource-detail {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.resource-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border-left: 5px solid var(--primary);
}

.resource-card h1 {
    color: var(--dark);
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.resource-category {
    color: var(--gray);
    font-size: 1.2rem;
    margin-bottom: 20px;
}

.resource-status {
    margin-bottom: 30px;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
}

.status-available {
    background: rgba(39, 174, 96, 0.1);
    color: var(--success);
}

.status-maintenance {
    background: rgba(243, 156, 18, 0.1);
    color: var(--warning);
}

.status-unavailable {
    background: rgba(231, 76, 60, 0.1);
    color: var(--danger);
}

.resource-specs {
    margin-bottom: 30px;
}

.specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.spec-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: var(--light);
    border-radius: 8px;
    border-left: 3px solid var(--accent);
}

.spec-item i {
    font-size: 1.5rem;
    color: var(--accent);
    width: 30px;
    text-align: center;
}

.spec-item strong {
    color: var(--dark);
    font-size: 0.9rem;
    display: block;
    margin-bottom: 5px;
}

.spec-item p {
    color: var(--gray);
    margin: 0;
}

.resource-description {
    margin-bottom: 30px;
    padding: 20px;
    background: rgba(52, 152, 219, 0.05);
    border-radius: 8px;
    border-left: 3px solid var(--accent);
}

.resource-description h3 {
    color: var(--dark);
    margin-bottom: 15px;
}

.resource-description p {
    color: var(--gray);
    line-height: 1.6;
}

.resource-meta {
    display: flex;
    gap: 30px;
    margin-bottom: 30px;
    padding: 15px;
    background: var(--light);
    border-radius: 8px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--gray);
}

.meta-item i {
    color: var(--accent);
}

.guest-notice {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: rgba(52, 152, 219, 0.1);
    border: 1px solid rgba(52, 152, 219, 0.2);
    border-radius: 8px;
    margin-bottom: 30px;
}

.notice-icon {
    font-size: 2rem;
    color: var(--accent);
}

.notice-content h4 {
    color: var(--dark);
    margin-bottom: 10px;
}

.notice-content p {
    color: var(--gray);
    margin: 0;
}

.notice-content a {
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
}

.notice-content a:hover {
    text-decoration: underline;
}

.action-links {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    justify-content: center;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: var(--accent);
    color: white;
}

.btn-primary:hover {
    background: var(--info);
    transform: translateY(-2px);
}

.btn-secondary {
    background: var(--light);
    color: var(--dark);
    border: 1px solid var(--light-gray);
}

.btn-secondary:hover {
    background: var(--light-gray);
    transform: translateY(-2px);
}

.btn-success {
    background: var(--success);
    color: white;
}

.btn-success:hover {
    background: #229954;
    transform: translateY(-2px);
}

.btn-back {
    background: var(--gray);
    color: white;
    margin-bottom: 20px;
}

.btn-back:hover {
    background: var(--dark);
}

@media (max-width: 768px) {
    .resource-detail {
        padding: 10px;
    }
    
    .resource-card {
        padding: 20px;
    }
    
    .resource-card h1 {
        font-size: 2rem;
    }
    
    .specs-grid {
        grid-template-columns: 1fr;
    }
    
    .resource-meta {
        flex-direction: column;
        gap: 10px;
    }
    
    .guest-notice {
        flex-direction: column;
        text-align: center;
    }
    
    .action-links {
        flex-direction: column;
    }
}
</style>
@endsection
