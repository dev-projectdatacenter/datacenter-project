@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-slate: #434861;
        --bg-main: #f3f4f6;
        --accent-orange: #e67e22;
        --white: #ffffff;
        --text-dark: #2d3748;
        --text-gray: #718096;
        --danger: #e74c3c;
        --success: #27ae60;
        --warning: #f39c12;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .details-container {
        padding: 30px 20px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .btn-back {
        text-decoration: none;
        color: var(--text-gray);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }

    .btn-back:hover { color: var(--primary-slate); }

    /* --- LAYOUT --- */
    .details-grid {
        display: grid;
        grid-template-columns: 1.8fr 1.2fr;
        gap: 25px;
        margin-top: 20px;
    }

    @media (max-width: 850px) {
        .details-grid { grid-template-columns: 1fr; }
    }

    /* --- CARDS --- */
    .card-detail {
        background: var(--white);
        border-radius: 12px;
        padding: 25px;
        box-shadow: var(--shadow);
        border: 1px solid #edf2f7;
    }

    .description-box {
        background: #f8fafc;
        padding: 20px;
        border-radius: 10px;
        border-left: 5px solid var(--danger);
        color: var(--text-dark);
        line-height: 1.7;
        white-space: pre-wrap;
    }

    /* --- STATUS INDICATORS --- */
    .status-banner {
        text-align: center;
        padding: 12px;
        border-radius: 8px;
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 20px;
        text-transform: uppercase;
    }
    .status-open-banner { background: #fee2e2; color: #b91c1c; }
    .status-resolved-banner { background: #d1fae5; color: #065f46; }

    /* --- BUTTONS --- */
    .btn-full {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        margin-bottom: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
    .btn-resolve { background: var(--success); color: white; }
    .btn-resolve:hover { background: #219150; transform: translateY(-2px); }
    .btn-maint { background: var(--warning); color: white; }
    .btn-maint:hover { background: #d68910; transform: translateY(-2px); }

</style>

<div class="details-container">
    <div style="margin-bottom: 25px;">
        <a href="{{ route('incidents.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour au tableau de bord
        </a>
        <h1 style="color: var(--primary-slate); margin-top: 15px;">Dossier Incident #{{ $incident->id }}</h1>
    </div>

    @can('user')
        <div style="background: #ebf8ff; border-left: 4px solid #3182ce; padding: 15px; border-radius: 8px; margin-bottom: 25px; color: #2c5282;">
            <i class="fas fa-info-circle"></i> En tant qu'utilisateur, vous consultez le suivi de votre signalement.
        </div>
    @endcan

    {{-- Vérification des accès --}}
    @if(auth()->user()->role->name === 'user' && $incident->user_id !== auth()->id())
        <div class="card-detail" style="text-align:center; border: 2px solid #fed7d7;">
            <i class="fas fa-lock" style="font-size: 3rem; color: #e53e3e; margin-bottom: 15px;"></i>
            <h2 style="color: #c53030;">Accès restreint</h2>
            <p>Vous n'êtes pas l'auteur de ce signalement.</p>
        </div>
    @elseif(auth()->user()->role->name === 'tech_manager' && (!$incident->resource || $incident->resource->managed_by !== auth()->id()))
        <div class="card-detail" style="text-align:center; border: 2px solid #fed7d7;">
            <i class="fas fa-shield-alt" style="font-size: 3rem; color: #e53e3e; margin-bottom: 15px;"></i>
            <h2 style="color: #c53030;">Accès non autorisé</h2>
            <p>Cet équipement n'est pas sous votre supervision technique.</p>
        </div>
    @else

    <div class="details-grid">
        {{-- COLONNE GAUCHE : INFOS --}}
        <div class="card-detail">
            <h3 style="margin-bottom: 20px; color: var(--primary-slate);"><i class="fas fa-file-alt"></i> Détails de l'anomalie</h3>
            
            <div class="description-box">
                {{ $incident->description }}
            </div>
            
            @if($incident->notes)
                <div style="margin-top: 25px;">
                    <h4 style="color: var(--warning);"><i class="fas fa-comment-dots"></i> Note de suivi technique</h4>
                    <div style="background: #fffbeb; padding: 15px; border-radius: 8px; border: 1px solid #fef3c7; color: #92400e;">
                        {{ $incident->notes }}
                    </div>
                </div>
            @endif
            
            <div style="margin-top: 30px; display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-gray); border-top: 1px solid #eee; padding-top: 15px;">
                <span><i class="far fa-user"></i> Émis par : <strong>{{ $incident->user ? $incident->user->name : 'Système' }}</strong></span>
                <span><i class="far fa-calendar-alt"></i> Le {{ $incident->created_at->format('d/m/Y à H:i') }}</span>
            </div>
        </div>

        {{-- COLONNE DROITE : ACTIONS & RESSOURCE --}}
        <div>
            {{-- Carte Ressource --}}
            <div class="card-detail" style="margin-bottom: 20px;">
                <h4 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px;">Équipement concerné</h4>
                <div style="padding: 15px 0;">
                    <div style="font-size: 1.1rem; font-weight: 700; color: var(--primary-slate);">{{ $incident->resource->name ?? 'N/A' }}</div>
                    <div style="color: var(--text-gray); margin-bottom: 12px;">{{ $incident->resource->category->name ?? 'Sans catégorie' }}</div>
                    
                    <span class="severity-badge severity-{{ $incident->severity }}" style="padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                        Gravité : {{ ucfirst($incident->severity) }}
                    </span>
                </div>
                @if($incident->resource)
                    <a href="{{ route('resources.show', $incident->resource) }}" class="btn-back" style="font-size: 0.85rem; color: #3498db;">
                        Consulter la fiche technique <i class="fas fa-external-link-alt"></i>
                    </a>
                @endif
            </div>

            {{-- Carte Statut --}}
            <div class="card-detail">
                <h4 style="margin-top: 0; margin-bottom: 15px;">Suivi du traitement</h4>
                
                <div class="status-banner {{ $incident->status == 'open' ? 'status-open-banner' : 'status-resolved-banner' }}">
                    {{ $incident->status == 'open' ? '🚨 Incident Ouvert' : '✅ Incident Résolu' }}
                </div>

                @can('admin')
                    @if($incident->status == 'open')
                        <div style="margin-top: 20px;">
                            <form action="{{ route('incidents.resolve', $incident) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-full btn-resolve">
                                    <i class="fas fa-check"></i> Clôturer l'incident
                                </button>
                            </form>
                            
                            <form action="{{ route('incidents.convert-to-maintenance', $incident) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-full btn-maint" onclick="return confirm('Mettre la ressource en maintenance ?')">
                                    <i class="fas fa-tools"></i> Passer en maintenance
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <div style="text-align: center; color: var(--text-gray); font-size: 0.9rem; padding: 10px;">
                        <i class="fas fa-spinner fa-spin"></i> Traitement en cours par l'administration.
                    </div>
                @endcan
            </div>
        </div>
    </div>
    @endif
</div>
@endsection