<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations - Data Center</title>
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
                <h1 class="page-title">Mes Réservations</h1>
                <div class="page-actions">
                    <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                        <span class="btn-icon">+</span>
                        Nouvelle Réservation
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

            <!-- Filtres -->
            <div class="filters-section">
                <form method="GET" action="{{ route('reservations.index') }}" class="filters-form">
                    <div class="filter-group">
                        <label for="status">Statut:</label>
                        <select name="status" id="status" class="filter-select">
                            <option value="">Tous</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvées</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>En cours</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminées</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulées</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="date_range">Période:</label>
                        <input type="text" name="date_range" id="date_range" 
                               class="filter-input" 
                               placeholder="JJ/MM/AAAA - JJ/MM/AAAA"
                               value="{{ request('date_range') }}">
                    </div>
                    
                    <button type="submit" class="btn btn-secondary">Filtrer</button>
                    <a href="{{ route('reservations.index') }}" class="btn btn-outline">Réinitialiser</a>
                </form>
            </div>

            <!-- Tableau des Réservations -->
            <div class="card">
                <div class="card-header">
                    <h2>Liste de vos réservations</h2>
                </div>
                <div class="card-body">
                    @if($reservations->isEmpty())
                        <div class="empty-state">
                            <div class="empty-icon">📅</div>
                            <h3>Aucune réservation</h3>
                            <p>Vous n'avez pas encore de réservation. Commencez par en créer une !</p>
                            <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                                Créer ma première réservation
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Ressource</th>
                                        <th>Dates</th>
                                        <th>Justification</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td>
                                                <div class="resource-info">
                                                    <div class="resource-name">
                                                        {{ $reservation->resource->name ?? 'Ressource Inconnue' }}
                                                    </div>
                                                    <div class="resource-category">
                                                        {{ $reservation->resource->category->name ?? '' }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="date-info">
                                                    <div class="date-start">
                                                        <strong>Début:</strong> 
                                                        {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y H:i') }}
                                                    </div>
                                                    <div class="date-end">
                                                        <strong>Fin:</strong> 
                                                        {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y H:i') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="justification" title="{{ $reservation->justification }}">
                                                    {{ Str::limit($reservation->justification, 50) }}
                                                </div>
                                            </td>
                                            <td>
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
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('reservations.show', $reservation->id) }}" 
                                                       class="btn btn-sm btn-outline" title="Voir">
                                                        👁️
                                                    </a>
                                                    
                                                    @if($reservation->status === 'pending')
                                                        <a href="{{ route('reservations.edit', $reservation->id) }}" 
                                                           class="btn btn-sm btn-secondary" title="Éditer">
                                                            ✏️
                                                        </a>
                                                        
                                                        <form method="POST" action="{{ route('reservations.cancel', $reservation->id) }}" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                                    title="Annuler" 
                                                                    onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                                                🗑️
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-wrapper">
                            {{ $reservations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/reservations.js') }}"></script>
</body>
</html>