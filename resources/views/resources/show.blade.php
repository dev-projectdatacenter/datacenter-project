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
                <li><i class="fas fa-network-wired" style="width: 20px;"></i> <strong>Bande Passante :</strong> {{ $resource->bandwidth ?? 'N/A' }}</li>
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

    <!-- ════════════════════════════════════════════════════════════ -->
    <!-- SECTION DISCUSSION (MODÉRATION) -->
    <!-- ════════════════════════════════════════════════════════════ -->
    <div class="info-card" style="margin-top: 30px;">
        <h3><i class="fas fa-comments"></i> Discussions et Questions</h3>
        
        <div class="comments-list" style="margin-bottom: 25px;">
            @forelse($resource->comments as $comment)
                <div class="comment-item" style="border-bottom: 1px dashed #ddd; padding: 15px 0; display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <strong style="color: #2c3e50;">{{ $comment->user->name }}</strong>
                        <small style="color: #999; margin-left: 10px;">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                        <p style="margin: 10px 0 0 0; color: #444;">{{ $comment->content }}</p>
                    </div>
                    
                    @if(auth()->user()->role->name === 'admin' || auth()->user()->id === $resource->managed_by)
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer;" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <p style="text-align: center; color: #999; padding: 20px;">Aucune question pour le moment. Soyez le premier à en poser une !</p>
            @endforelse
        </div>

        <form action="{{ route('comments.store', $resource) }}" method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 12px;">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">Poser une question ou laisser une alerte :</label>
                <textarea name="content" rows="3" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit;" required placeholder="Écrivez votre message ici..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="background: #2a2d4f;"><i class="fas fa-paper-plane"></i> Envoyer le message</button>
        </form>
    </div>
</div>
@endsection
