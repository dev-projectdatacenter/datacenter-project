<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Demandes en attente - Data Center</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reservations.css') }}">
</head>
<body>
    <div class="app-container">
        <!-- Navigation -->
        @include('components.navigation', ['title' => 'Demandes en attente'])
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">Réservations en attente d'approbation</h1>
                <div class="page-actions">
                    <a href="{{ route('tech.reservations.stats') }}" class="btn btn-outline">
                        <i class="fas fa-chart-bar"></i>
                        Statistiques
                    </a>
                </div>
            </div>

            <!-- Filtres -->
            <div class="card">
                <div class="card-header">
                    <h2>Filtres</h2>
                </div>
                <div class="card-body">
                    <form method="GET" class="filter-form">
                        <div class="filter-row">
                            <div class="form-group">
                                <label for="resource_id">Ressource</label>
                                <select name="resource_id" id="resource_id" class="form-control">
                                    <option value="">Toutes les ressources</option>
                                    @foreach($resources as $resource)
                                        <option value="{{ $resource->id }}" {{ request('resource_id') == $resource->id ? 'selected' : '' }}>
                                            {{ $resource->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="user_id">Utilisateur</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">Tous les utilisateurs</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="date_from">Date début</label>
                                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="date_to">Date fin</label>
                                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="filter-buttons">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter"></i>
                                        Filtrer
                                    </button>
                                    <a href="{{ route('tech.reservations.pending') }}" class="btn btn-outline">
                                        <i class="fas fa-times"></i>
                                        Réinitialiser
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Actions groupées -->
            @if($reservations->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="bulk-info">
                            <p><strong>Traitement des réservations en attente</strong></p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Liste des réservations -->
            <div class="card">
                <div class="card-header">
                    <h2>Liste des demandes ({{ $reservations->total() }})</h2>
                </div>
                <div class="card-body">
                    @if($reservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th>Ressource</th>
                                        <th>Période</th>
                                        <th>Justification</th>
                                        <th>Date de demande</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td>
                                                <div class="user-info">
                                                    <strong>{{ $reservation->user->name }}</strong>
                                                    <br>
                                                    <small>{{ $reservation->user->email }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="resource-info">
                                                    <strong>{{ $reservation->resource->name }}</strong>
                                                    <br>
                                                    <small>{{ $reservation->resource->category->name ?? 'N/A' }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="period-info">
                                                    <div><i class="fas fa-calendar"></i> {{ $reservation->start_date->format('d/m/Y H:i') }}</div>
                                                    <div><i class="fas fa-calendar"></i> {{ $reservation->end_date->format('d/m/Y H:i') }}</div>
                                                    <div class="duration">
                                                        {{ $reservation->start_date->diffInHours($reservation->end_date) }}h
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="justification">
                                                    {{ $reservation->justification }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="date-info">
                                                    <div>{{ $reservation->created_at->format('d/m/Y') }}</div>
                                                    <small>{{ $reservation->created_at->diffForHumans() }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn btn-success btn-sm" onclick="approveReservation({{ $reservation->id }})">
                                                        <i class="fas fa-check"></i>
                                                        Approuver
                                                    </button>
                                                    <button class="btn btn-danger btn-sm" onclick="showRejectModal({{ $reservation->id }})">
                                                        <i class="fas fa-times"></i>
                                                        Refuser
                                                    </button>
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
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h3>Aucune demande en attente</h3>
                            <p>Toutes les réservations ont été traitées.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <!-- Modale de refus -->
    <div id="rejectModal" class="modal">
        <div class="modal-content" style="margin: 20px;">
            <div class="modal-header">
                <h3>Refuser la réservation</h3>
            </div>
            <form id="rejectForm" method="POST" action="/tech/reservations/0/reject">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason">Raison du refus *</label>
                        <textarea name="reason" id="rejection_reason" class="form-control" rows="4" required placeholder="Expliquez pourquoi cette réservation est refusée..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('rejectModal')">Annuler</button>
                    <button type="submit" class="btn btn-danger">Refuser la réservation</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modale d'approbation groupée -->
    <!-- Supprimée pour plus de simplicité -->

    <!-- Modale de refus groupé -->
    <!-- Supprimée pour plus de simplicité -->

    <!-- Modale de justification complète -->
    <!-- Supprimée car inutile -->

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/tech-reservations.js') }}"></script>
</body>
</html>
