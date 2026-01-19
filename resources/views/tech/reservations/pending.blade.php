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
                        <div class="bulk-actions">
                            <button class="btn btn-success" onclick="showBulkApproveModal()">
                                <i class="fas fa-check"></i>
                                Approuver la sélection
                            </button>
                            <button class="btn btn-danger" onclick="showBulkRejectModal()">
                                <i class="fas fa-times"></i>
                                Refuser la sélection
                            </button>
                            <span class="selection-info">
                                <span id="selectedCount">0</span> réservation(s) sélectionnée(s)
                            </span>
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
                                        <th>
                                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                        </th>
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
                                                <input type="checkbox" class="reservation-checkbox" value="{{ $reservation->id }}" onchange="updateSelectedCount()">
                                            </td>
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
                                                    {{ Str::limit($reservation->justification, 100) }}
                                                    @if(Str::length($reservation->justification) > 100)
                                                        <button class="btn btn-sm btn-link" onclick="showJustification({{ $reservation->id }})">
                                                            Voir plus
                                                        </button>
                                                    @endif
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
        <div class="modal-content">
            <div class="modal-header">
                <h3>Refuser la réservation</h3>
                <button class="modal-close" onclick="closeModal('rejectModal')">&times;</button>
            </div>
            <form id="rejectForm" method="POST" action="/tech/reservations/0/reject">
                @csrf
                <input type="hidden" name="_method" value="PUT">
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
    <div id="bulkApproveModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Approuver les réservations sélectionnées</h3>
                <button class="modal-close" onclick="closeModal('bulkApproveModal')">&times;</button>
            </div>
            <form id="bulkApproveForm" method="POST" action="/tech/reservations/bulk-approve">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <p>Vous êtes sur le point d'approuver <span id="bulkApproveCount">0</span> réservation(s).</p>
                    <p class="warning">Cette action est irréversible. Les utilisateurs seront notifiés.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('bulkApproveModal')">Annuler</button>
                    <button type="submit" class="btn btn-success">Approuver</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modale de refus groupé -->
    <div id="bulkRejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Refuser les réservations sélectionnées</h3>
                <button class="modal-close" onclick="closeModal('bulkRejectModal')">&times;</button>
            </div>
            <form id="bulkRejectForm" method="POST" action="/tech/reservations/bulk-reject">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-body">
                    <p>Vous êtes sur le point de refuser <span id="bulkRejectCount">0</span> réservation(s).</p>
                    <div class="form-group">
                        <label for="bulk_rejection_reason">Raison du refus *</label>
                        <textarea name="reason" id="bulk_rejection_reason" class="form-control" rows="4" required placeholder="Expliquez pourquoi ces réservations sont refusées..."></textarea>
                    </div>
                    <p class="warning">Cette action est irréversible. Les utilisateurs seront notifiés.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('bulkRejectModal')">Annuler</button>
                    <button type="submit" class="btn btn-danger">Refuser</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modale de justification complète -->
    <div id="justificationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Justification complète</h3>
                <button class="modal-close" onclick="closeModal('justificationModal')">&times;</button>
            </div>
            <div class="modal-body">
                <p id="fullJustification"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="closeModal('justificationModal')">Fermer</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/tech-reservations.js') }}"></script>
</body>
</html>
