@extends('layouts.app')

@section('title', 'Tableau de Bord Technique')

@section('content')
</head>
<body>
<<<<<<< HEAD
    <div class="container">
        <div class="header">
            <a href="/logout" class="logout-btn">🚪 Déconnexion</a>
            <h1>🛠️ Dashboard Responsable Technique</h1>
            <p>Bienvenue {{ $user->name }} - Supervision des ressources techniques</p>
        </div>
        
        <div class="content">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>🖥️ Serveurs actifs</h3>
                    <div class="number">{{ $statistics['totalResources'] ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <h3>📅 Réservations en attente</h3>
                    <div class="number">{{ $statistics['pendingReservations'] ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <h3>🔧 Maintenances planifiées</h3>
                    <div class="number">{{ $statistics['criticalResources'] ?? 0 }}</div>
                </div>
                <div class="stat-card">
                    <h3>⚠️ Incidents signalés</h3>
                    <div class="number">{{ is_array($incidents) ? count($incidents) : ($incidents->count() ?? 0) }}</div>
                </div>
            </div>
            
            <div class="actions-grid">
                <div class="action-card" onclick="window.location.href='{{ route('resources.index') }}'">
                    <h3>🖥️ Gestion des ressources</h3>
                    <p>Ajouter, modifier et superviser les serveurs, VMs et équipements</p>
                    <button class="btn">Gérer les ressources</button>
                </div>
                
                <div class="action-card" onclick="window.location.href='{{ route('tech.reservations.pending') }}'">
                    <h3>📅 Validation des réservations</h3>
                    <p>Approuver ou rejeter les demandes de réservation des utilisateurs</p>
                    <button class="btn">Valider les réservations</button>
                </div>
                
                <div class="action-card" onclick="window.location.href='{{ route('maintenances.index') }}'">
                    <h3>🔧 Planification des maintenances</h3>
                    <p>Programmer et suivre les opérations de maintenance</p>
                    <button class="btn">Planifier maintenances</button>
                </div>
                
                <div class="action-card" onclick="window.location.href='{{ route('statistics.index') }}'">
                    <h3>📊 Rapports techniques</h3>
                    <p>Statistiques d'utilisation et performance des ressources</p>
                    <button class="btn">Voir les rapports</button>
                </div>
                
                <div class="action-card" onclick="window.location.href='{{ route('incidents.index') }}'">
                    <h3>⚠️ Gestion des incidents</h3>
                    <p>Traiter les signalements et les pannes matérielles</p>
                    <button class="btn">Gérer les incidents</button>
                </div>
               
            </div>
        </div>
    </div>
    <script>
        // Script pour gérer les clics sur les cartes
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('[onclick*="window.location"]');
            cards.forEach(card => {
                card.style.cursor = 'pointer';
                card.addEventListener('click', function(e) {
                    // Ne pas suivre le lien si on clique sur un bouton à l'intérieur de la carte
                    if (!e.target.closest('button, a')) {
                        window.location = this.getAttribute('onclick').match(/'(.*?)'/)[1];
                    }
                });
            });
        });
    </script>
=======
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <span>DataCenter</span>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('resources.index') }}" class="nav-link">
                            <i class="fas fa-server"></i>
                            <span>Ressources</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('maintenances.index') }}" class="nav-link">
                            <i class="fas fa-tools"></i>
                            <span>Maintenances</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('incidents.index') }}" class="nav-link">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Incidents</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('statistics.index') }}" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Statistiques</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-title">
                    <h1>Tableau de bord technique</h1>
                    <p class="header-subtitle">Gestion des ressources et maintenance du datacenter</p>
                </div>
                <div class="user-menu">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn" title="Déconnexion">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </header>
            
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card" onclick="window.location.href='{{ route('resources.index') }}'">
                    <i class="fas fa-server"></i>
                    <div class="stat-value">{{ $statistics['totalResources'] ?? 0 }}</div>
                    <div class="stat-label">Ressources gérées</div>
                </div>
                <div class="stat-card" onclick="window.location.href='{{ route('maintenances.index') }}'">
                    <i class="fas fa-tools"></i>
                    <div class="stat-value">{{ $statistics['pendingMaintenance'] ?? 0 }}</div>
                    <div class="stat-label">Maintenances en attente</div>
                </div>
                <div class="stat-card" onclick="window.location.href='{{ route('incidents.index') }}'">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div class="stat-value">{{ $statistics['openIncidents'] ?? 0 }}</div>
                    <div class="stat-label">Incidents ouverts</div>
                </div>
                <div class="stat-card" onclick="window.location.href='{{ route('incidents.index') }}?status=resolved'">
                    <i class="fas fa-check-circle"></i>
                    <div class="stat-value">{{ $statistics['resolvedIncidents'] ?? 0 }}</div>
                    <div class="stat-label">Incidents résolus (7j)</div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt"></i>
                        Actions rapides
                    </h3>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="{{ route('resources.index') }}" class="btn btn-primary">
                        <i class="fas fa-server"></i> Voir les ressources
                    </a>
                    <a href="{{ route('maintenances.index') }}" class="btn btn-warning">
                        <i class="fas fa-tools"></i> Planifier maintenance
                    </a>
                    <a href="{{ route('incidents.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus"></i> Nouvel incident
                    </a>
                    <a href="{{ route('statistics.index') }}" class="btn btn-info">
                        <i class="fas fa-file-export"></i> Voir les statistiques
                    </a>
                </div>
            </div>
            
            <!-- Recent Reservations -->
            @if(isset($reservations) && $reservations->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check"></i>
                        Réservations récentes
                    </h3>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Ressource</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations->take(5) as $reservation)
                            <tr>
                                <td>{{ $reservation->user->name }}</td>
                                <td>{{ $reservation->resource->name }}</td>
                                <td>{{ $reservation->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge badge-{{ $reservation->status == 'validated' ? 'success' : ($reservation->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ $reservation->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            <!-- Recent Incidents -->
            @if(isset($incidents) && $incidents->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        Incidents en attente
                    </h3>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Priorité</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incidents->take(5) as $incident)
                            <tr>
                                <td>{{ $incident->user->name }}</td>
                                <td>{{ Str::limit($incident->description, 50) }}</td>
                                <td>{{ $incident->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge badge-warning">
                                        {{ $incident->priority ?? 'Moyenne' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </main>
    </div>
>>>>>>> feature/backend/-database
</body>
</html>
