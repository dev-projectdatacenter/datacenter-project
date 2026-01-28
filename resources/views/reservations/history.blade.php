<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Réservations - Data Center</title>
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
                <h1 class="page-title">Historique des Réservations</h1>
                <div class="page-actions">
                    <a href="{{ route('reservations.index') }}" class="btn btn-outline">
                        ← Mes réservations actives
                    </a>
                    <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                        + Nouvelle réservation
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

            <!-- Statistiques rapides -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon"></div>
                    <div class="stat-info">
                        <h3>{{ $historyStats['total'] ?? $reservations->total() }}</h3>
                        <p>Total des réservations</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"></div>
                    <div class="stat-info">
                        <h3>{{ $historyStats['completed'] ?? $reservations->where('status', 'completed')->count() }}</h3>
                        <p>Réservations terminées</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"></div>
                    <div class="stat-info">
                        <h3>{{ $historyStats['cancelled'] ?? $reservations->where('status', 'cancelled')->count() }}</h3>
                        <p>Réservations annulées</p>
                    </div>
                </div>
            </div>

            <!-- Filtres -->
            <div class="filters-section">
                <form method="GET" action="{{ route('reservations.history') }}" class="filters-form">
                    <div class="filter-group">
                        <label for="status">Statut:</label>
                        <select name="status" id="status" class="filter-select">
                            <option value="">Tous</option>
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
                    <a href="{{ route('reservations.history') }}" class="btn btn-outline">Réinitialiser</a>
                </form>
            </div>

            <!-- Tableau des réservations -->
            <div class="card">
                <div class="card-header">
                    <h2>Historique complet</h2>
                </div>
                <div class="card-body">
                    @if($reservations->isEmpty())
                        <div class="empty-state">
                            <div class="empty-icon"></div>
                            <h3>Aucune réservation dans l'historique</h3>
                            <p>Vous n'avez pas encore de réservations terminées ou annulées.</p>
                            <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                                Créer une réservation
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Référence</th>
                                        <th>Ressource</th>
                                        <th>Période</th>
                                        <th>Statut</th>
                                        <th>Durée</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td>
                                                <span class="reservation-id">#{{ $reservation->id }}</span>
                                            </td>
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
                                                        {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y H:i') }}
                                                    </div>
                                                    <div class="date-end">
                                                        {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y H:i') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="status-badge status-{{ $reservation->status }}">
                                                    @if($reservation->status === 'completed')
                                                        Terminée
                                                    @elseif($reservation->status === 'cancelled')
                                                        Annulée
                                                    @else
                                                        {{ $reservation->status }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <span class="duration-badge">
                                                    {{ $reservation->start_date->diffInHours($reservation->end_date) }}h
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('reservations.show', $reservation->id) }}" 
                                                       class="btn btn-sm btn-outline" title="Voir les détails">
                                                        
                                                    </a>
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
