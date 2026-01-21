@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="resources-header">
        <h1>Toutes les réservations</h1>
        <div class="header-actions">
            <a href="{{ route('tech.reservations.pending') }}" class="btn btn-outline">
                <i class="fas fa-clock"></i>
                Demandes en attente
            </a>
            <a href="{{ route('tech.reservations.stats') }}" class="btn btn-outline">
                <i class="fas fa-chart-bar"></i>
                Statistiques
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-card">
        <form method="GET" action="{{ route('tech.reservations.all') }}">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Ressource</label>
                    <select name="resource_id" class="form-control">
                        <option value="">Toutes les ressources</option>
                        @foreach($resources as $resource)
                            <option value="{{ $resource->id }}" {{ request('resource_id') == $resource->id ? 'selected' : '' }}>
                                {{ $resource->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label>Utilisateur</label>
                    <select name="user_id" class="form-control">
                        <option value="">Tous les utilisateurs</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label>Statut</label>
                    <select name="status" class="form-control">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvées</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Refusées</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actives</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminées</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label>Date début</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>
                
                <div class="filter-group">
                    <label>Date fin</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>
                
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tableau des réservations -->
    <div class="table-container">
        <table class="reservations-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Ressource</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->resource->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="status-badge status-{{ $reservation->status }}">
                                @switch($reservation->status)
                                    @case('pending')
                                        <span class="status-pending">⏳ En attente</span>
                                        @break
                                    @case('approved')
                                        <span class="status-approved">✅ Approuvée</span>
                                        @break
                                    @case('rejected')
                                        <span class="status-rejected">❌ Refusée</span>
                                        @break
                                    @case('active')
                                        <span class="status-active">🔄 Active</span>
                                        @break
                                    @case('completed')
                                        <span class="status-completed">✅ Terminée</span>
                                        @break
                                @endswitch
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Aucune réservation trouvée</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $reservations->links() }}
    </div>

    <!-- Modal info -->
    <div class="modal-info">
        <p><i class="fas fa-info-circle"></i> Cette page affiche toutes les réservations. Pour approuver ou refuser les demandes en attente, utilisez la page <a href="{{ route('tech.reservations.pending') }}">Demandes en attente</a>.</p>
    </div>
</div>
@push('scripts')
@endsection
