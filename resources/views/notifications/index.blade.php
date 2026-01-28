<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Data Center Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
</head>
<body>
    <!-- En-tête personnalisé sans Bootstrap -->
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <h1 class="logo">Data Center</h1>
                <nav class="nav">
                    <a href="{{ route('reservations.index') }}" class="nav-link">Réservations</a>
                    <a href="{{ route('notifications.index') }}" class="nav-link active">Notifications</a>
                    <span class="notification-badge" id="notification-badge" style="display: none;">0</span>
                </nav>
            </div>
            <div class="header-right">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn" style="background: none; border: none; color: white; cursor: pointer; text-decoration: none;">Déconnexion</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="main-content">
        <div class="container">
            <!-- En-tête de page -->
            <div class="page-header">
                <h1 class="page-title">Mes Notifications</h1>
                <div class="page-actions">
                    @if($notifications->where('read', false)->count() > 0)
                        <button class="btn btn-secondary" onclick="markAllAsRead()">
                            ✓ Tout marquer comme lu
                        </button>
                    @endif
                    <a href="{{ route('reservations.index') }}" class="btn btn-outline">
                        ← Mes réservations
                    </a>
                </div>
            </div>

            <!-- Messages Flash -->
            @if(session('success'))
                <div class="alert alert-success" id="flash-message">
                    <span class="alert-icon">✓</span>
                    {{ session('success') }}
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">×</button>
                </div>
            @endif

            <!-- Filtres personnalisés -->
            <div class="filters-section">
                <form method="GET" class="filter-form" id="filter-form">
                    <div class="filter-row">
                        <div class="form-group">
                            <label for="type-filter">Type</label>
                            <select name="type" id="type-filter" class="form-control">
                                <option value="">Tous les types</option>
                                <option value="info" {{ request('type') == 'info' ? 'selected' : '' }}>Information</option>
                                <option value="success" {{ request('type') == 'success' ? 'selected' : '' }}>Succès</option>
                                <option value="warning" {{ request('type') == 'warning' ? 'selected' : '' }}>Avertissement</option>
                                <option value="error" {{ request('type') == 'error' ? 'selected' : '' }}>Erreur</option>
                                <option value="reservation_approved" {{ request('type') == 'reservation_approved' ? 'selected' : '' }}>Réservation approuvée</option>
                                <option value="reservation_rejected" {{ request('type') == 'reservation_rejected' ? 'selected' : '' }}>Réservation refusée</option>
                                <option value="reservation_cancelled" {{ request('type') == 'reservation_cancelled' ? 'selected' : '' }}>Réservation annulée</option>
                                <option value="reservation_reminder" {{ request('type') == 'reservation_reminder' ? 'selected' : '' }}>Rappel de réservation</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="status-filter">Statut</label>
                            <select name="status" id="status-filter" class="form-control">
                                <option value="">Tous les statuts</option>
                                <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Lues</option>
                                <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Non lues</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="filter-buttons">
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                                <a href="{{ route('notifications.index') }}" class="btn btn-outline">Réinitialiser</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Statistiques des notifications -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🔔</div>
                    <div class="stat-info">
                        <h3>{{ $notifications->count() }}</h3>
                        <p>Total des notifications</p>
                    </div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-icon">📬</div>
                    <div class="stat-info">
                        <h3>{{ $notifications->where('read', false)->count() }}</h3>
                        <p>Non lues</p>
                    </div>
                </div>
                <div class="stat-card success">
                    <div class="stat-icon">✓</div>
                    <div class="stat-info">
                        <h3>{{ $notifications->where('read', true)->count() }}</h3>
                        <p>Déjà lues</p>
                    </div>
                </div>
            </div>

            <!-- Actions groupées -->
            <div class="bulk-actions" id="bulk-actions" style="display: none;">
                <div class="bulk-actions-content">
                    <span id="selected-count">0</span> notification(s) sélectionnée(s)
                    <button class="btn btn-success" onclick="markSelectedAsRead()">Marquer comme lues</button>
                    <button class="btn btn-danger" onclick="deleteSelected()">Supprimer</button>
                    <button class="btn btn-outline" onclick="clearSelection()">Désélectionner</button>
                </div>
            </div>

            <!-- Liste des notifications -->
            <div class="notifications-container">
                @if($notifications->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">🔔</div>
                        <h3>Aucune notification</h3>
                        <p>Vous n'avez pas encore de notifications.</p>
                        <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                            Créer une réservation
                        </a>
                    </div>
                @else
                    <div class="notifications-list" id="notifications-list">
                        @foreach($notifications as $notification)
                            <div class="notification-item {{ !$notification->read ? 'unread' : 'read' }}" 
                                 data-notification-id="{{ $notification->id }}"
                                 data-type="{{ $notification->type }}">
                                <div class="notification-checkbox">
                                    <input type="checkbox" 
                                           class="notification-select" 
                                           value="{{ $notification->id }}"
                                           onchange="updateBulkActions()">
                                </div>
                                
                                <div class="notification-icon">
                                    @if($notification->type === 'reservation_approved')
                                        ✅
                                    @elseif($notification->type === 'reservation_rejected')
                                        ❌
                                    @elseif($notification->type === 'reservation_cancelled')
                                        🗑️
                                    @elseif($notification->type === 'reservation_reminder')
                                        ⏰
                                    @elseif($notification->type === 'success')
                                        ✅
                                    @elseif($notification->type === 'error')
                                        ❌
                                    @elseif($notification->type === 'warning')
                                        ⚠️
                                    @else
                                        🔔
                                    @endif
                                </div>
                                
                                <div class="notification-content">
                                    <div class="notification-message">
                                        {{ $notification->message }}
                                    </div>
                                    <div class="notification-meta">
                                        <span class="notification-date">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y H:i') }}
                                        </span>
                                        <span class="notification-status">
                                            @if($notification->read)
                                                <span class="badge badge-success">Lue</span>
                                            @else
                                                <span class="badge badge-warning">Non lue</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="notification-actions">
                                    @if(!$notification->read)
                                        <button class="btn btn-sm btn-outline" 
                                                onclick="markAsRead({{ $notification->id }})"
                                                title="Marquer comme lu">
                                            ✓
                                        </button>
                                    @endif
                                    
                                    <button class="btn btn-sm btn-danger" 
                                            onclick="deleteNotification({{ $notification->id }})"
                                            title="Supprimer">
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination personnalisée -->
                    <div class="pagination">
                        @if($notifications->hasPages())
                            <div class="pagination-links">
                                {{-- Lien précédent --}}
                                @if($notifications->onFirstPage())
                                    <span class="pagination-link disabled">← Précédent</span>
                                @else
                                    <a href="{{ $notifications->previousPageUrl() }}" class="pagination-link">← Précédent</a>
                                @endif

                                {{-- Numéros de page --}}
                                @foreach($notifications->links() as $link)
                                    @if($link['active'])
                                        <span class="pagination-link active">{{ $link['label'] }}</span>
                                    @else
                                        <a href="{{ $link['url'] }}" class="pagination-link">{{ $link['label'] }}</a>
                                    @endif
                                @endforeach

                                {{-- Lien suivant --}}
                                @if($notifications->hasMorePages())
                                    <a href="{{ $notifications->nextPageUrl() }}" class="pagination-link">Suivant →</a>
                                @else
                                    <span class="pagination-link disabled">Suivant →</span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer personnalisé -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} Data Center Management. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Conteneur pour les notifications toast -->
    <div id="toast-container" class="toast-container"></div>

    <!-- JavaScript pur (sans jQuery) -->
    <script src="{{ asset('js/notifications.js') }}"></script>
</body>
</html>