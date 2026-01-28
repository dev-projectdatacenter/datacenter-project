<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Réservation - Data Center</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reservations.css') }}">
</head>
<body>
    <div class="app-container">
        <!-- Navigation -->
        @include('components.navigation')
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">Détails de la Réservation</h1>
                <div class="page-actions">
                    <a href="{{ route('reservations.index') }}" class="btn btn-outline">
                        ← Retour à la liste
                    </a>
                </div>
            </div>

            <!-- Messages Flash -->
            @if(session('success'))
                <div class="alert alert-success">
                    <span class="alert-icon">✓</span>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <span class="alert-icon">✗</span>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Détails de la réservation -->
            <div class="card">
                <div class="card-header">
                    <h2>Informations de la réservation</h2>
                </div>
                <div class="card-body">
                    <div class="reservation-details">
                        <!-- Informations principales -->
                        <div class="detail-section">
                            <h3>Informations générales</h3>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <label>Référence:</label>
                                    <span>#{{ $reservation->id }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>Statut:</label>
                                    <span class="status-badge status-{{ $reservation->status }}">
                                        @if($reservation->status === 'pending')
                                            En attente
                                        @elseif($reservation->status === 'approved')
                                            Approuvée
                                        @elseif($reservation->status === 'active')
                                            En cours
                                        @elseif($reservation->status === 'completed')
                                            Terminée
                                        @elseif($reservation->status === 'cancelled')
                                            Annulée
                                        @else
                                            {{ $reservation->status }}
                                        @endif
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <label>Date de création:</label>
                                    <span>{{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Ressource -->
                        <div class="detail-section">
                            <h3>Ressource réservée</h3>
                            <div class="resource-card">
                                <div class="resource-info">
                                    <h4>{{ $reservation->resource->name ?? 'Ressource Inconnue' }}</h4>
                                    <p class="resource-category">
                                        {{ $reservation->resource->category->name ?? '' }}
                                    </p>
                                    @if($reservation->resource->location)
                                        <p class="resource-location">
                                            📍 {{ $reservation->resource->location }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="detail-section">
                            <h3>Période de réservation</h3>
                            <div class="date-range">
                                <div class="date-item">
                                    <label>Début:</label>
                                    <span class="date-value">
                                        {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <div class="date-item">
                                    <label>Fin:</label>
                                    <span class="date-value">
                                        {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <div class="date-item">
                                    <label>Durée:</label>
                                    <span class="duration">
                                        {{ $reservation->start_date->diffInHours($reservation->end_date) }} heures
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Justification -->
                        <div class="detail-section">
                            <h3>Justification</h3>
                            <div class="justification-box">
                                <p>{{ $reservation->justification }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($reservation->status === 'pending' || $reservation->status === 'approved')
                <div class="card">
                    <div class="card-header">
                        <h2>Actions</h2>
                    </div>
                    <div class="card-body">
                        <div class="action-buttons">
                            @if($reservation->status === 'pending')
                                <a href="{{ route('reservations.edit', $reservation->id) }}" 
                                   class="btn btn-secondary">
                                     Modifier
                                </a>
                            @endif
                            
                            <form method="POST" action="{{ route('reservations.cancel', $reservation->id) }}" 
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                     Annuler
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/reservations.js') }}"></script>
</body>
</html>
