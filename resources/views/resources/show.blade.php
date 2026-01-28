@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resources.css') }}">
@endpush

@section('content')
<div class="resources-container">
    <div class="resources-header" style="border-bottom: 2px solid #997953; margin-bottom: 2rem; padding-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
        <h1 style="color: #0f1e3f; margin: 0;"><i class="fas fa-server"></i> Détails : {{ $resource->name }}</h1>
        <a href="{{ route('resources.index') }}" class="btn" style="color: #997953; text-decoration: none; font-weight: bold;"><i class="fas fa-arrow-left"></i>Retour</a>
    </div>

    <div class="details-grid">
        <div class="info-card" style="background: white; padding: 20px; border: 1px solid #e2d1b9; border-radius: 8px;">
            <h3 style="color: #0f1e3f;"><i class="fas fa-info-circle"></i> Spécifications</h3>
            <ul class="specs-list" style="list-style: none; padding: 0;">
                <li style="padding: 5px 0;"><i class="fas fa-microchip" style="width: 20px; color: #997953;"></i> <strong>Processeur :</strong> {{ $resource->cpu }}</li>
                <li style="padding: 5px 0;"><i class="fas fa-memory" style="width: 20px; color: #997953;"></i> <strong>RAM :</strong> {{ $resource->ram }}</li>
                <li style="padding: 5px 0;"><i class="fas fa-network-wired" style="width: 20px; color: #997953;"></i> <strong>Bande Passante :</strong> {{ $resource->bandwidth ?? 'N/A' }}</li>
                <li style="padding: 5px 0;"><i class="fas fa-hdd" style="width: 20px; color: #997953;"></i> <strong>Stockage :</strong> {{ $resource->storage }}</li>
                <li style="padding: 5px 0;"><i class="fas fa-window-maximize" style="width: 20px; color: #997953;"></i> <strong>OS :</strong> {{ $resource->os }}</li>
            </ul>
            <p style="margin-top: 15px; border-top: 1px solid #fdfaf5; padding-top: 10px;"><i class="fas fa-map-marker-alt" style="color: #997953;"></i> <strong>Localisation :</strong> {{ $resource->location }}</p>
        </div>

        <div>
            <div class="info-card" style="margin-bottom: 20px; background: white; padding: 20px; border: 1px solid #0f1e3f; border-radius: 8px; text-align: center;">
                <h3 style="color: #0f1e3f;"><i class="fas fa-chart-line"></i> Statut</h3><br>
                <span class="status-badge status-{{ $resource->status }}" style="padding: 5px 15px; border-radius: 15px; background: #fdfaf5; border: 1px solid #997953; color: #0f1e3f; font-weight: bold;">{{ $resource->status }}</span>
            </div>
            
            <a href="{{ route('incidents.report', $resource) }}" class="btn" style="background: #a58b6cff; color: white; display: block; text-align: center; margin-bottom: 10px; padding: 10px; border-radius: 10px; text-decoration: none; font-weight: bold;">
                <i class="fas fa-exclamation-triangle"></i> Signaler Problème
            </a>
            
            @can('update', $resource)
                <a href="{{ route('resources.edit', $resource) }}" class="btn" style="background: #424665; color: white; display: block; text-align: center; padding: 10px; border-radius: 10px; text-decoration: none; font-weight: bold;">
                    <i class="fas fa-edit"></i> Modifier
                </a>
            @endcan
        </div>
    </div>

    <div class="info-card" style="margin-top: 30px; background: white; padding: 20px; border: 1px solid #e2d1b9; border-radius: 8px;">
        <h3 style="color: #0f1e3f;"><i class="fas fa-comments"></i> Discussions et Questions</h3>
        
        <div class="comments-list" style="margin-bottom: 25px;">
            @forelse($resource->comments as $comment)
                <div class="comment-item" style="border-bottom: 1px dashed #e2d1b9; padding: 15px 0; display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <strong style="color: #0f1e3f;">{{ $comment->user->name }}</strong>
                        <small style="color: #997953; margin-left: 10px; font-weight: bold;">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                        <p style="margin: 10px 0 0 0; color: #213a56;">{{ $comment->content }}</p>
                    </div>
                    
                    @if(auth()->user()->role->name === 'admin' || auth()->user()->id === $resource->managed_by)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer;" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p style="text-align: center; color: #997953; padding: 20px;">Aucune question pour le moment.</p>
            @endforelse
        </div>

        <form action="{{ route('comments.store', $resource) }}" method="POST" style="background: #fdfaf5; padding: 20px; border-radius: 8px; border: 1px solid #e2d1b9;">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #0f1e3f;">Poser une question ou laisser une alerte :</label>
                <textarea name="content" rows="3" style="width: 100%; padding: 12px; border: 1px solid #e2d1b9; border-radius: 8px; font-family: inherit; color: #0f1e3f;" required placeholder="Écrivez votre message ici..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="background: #0f1e3f; color: white; border: none; padding: 10px 20px; border-radius: 10px; cursor: pointer; font-weight: bold;"><i class="fas fa-paper-plane"></i> Envoyer le message</button>
        </form>
    </div>
</div>
@endsection