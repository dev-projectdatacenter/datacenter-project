<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - Data Center</title>
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
                <h1 class="page-title">Mes Statistiques</h1>
                <div class="page-actions">
                    <a href="{{ route('reservations.index') }}" class="btn btn-outline">
                        ← Mes réservations
                    </a>
                    <a href="{{ route('reservations.history') }}" class="btn btn-outline">
                         Historique
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

            <!-- Statistiques principales -->
            <div class="stats-overview">
                <h2>Vue d'ensemble</h2>
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-icon"></div>
                        <div class="stat-info">
                            <h3>{{ $stats['total'] }}</h3>
                            <p>Total des réservations</p>
                        </div>
                    </div>
                    <div class="stat-card warning">
                        <div class="stat-icon"></div>
                        <div class="stat-info">
                            <h3>{{ $stats['pending'] }}</h3>
                            <p>En attente</p>
                        </div>
                    </div>
                    <div class="stat-card success">
                        <div class="stat-icon"></div>
                        <div class="stat-info">
                            <h3>{{ $stats['approved'] }}</h3>
                            <p>Approuvées</p>
                        </div>
                    </div>
                    <div class="stat-card info">
                        <div class="stat-icon"></div>
                        <div class="stat-info">
                            <h3>{{ $stats['active'] }}</h3>
                            <p>En cours</p>
                        </div>
                    </div>
                    <div class="stat-card success">
                        <div class="stat-icon">🎉</div>
                        <div class="stat-info">
                            <h3>{{ $stats['completed'] }}</h3>
                            <p>Terminées</p>
                        </div>
                    </div>
                    <div class="stat-card danger">
                        <div class="stat-icon"></div>
                        <div class="stat-info">
                            <h3>{{ $stats['cancelled'] }}</h3>
                            <p>Annulées</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphique mensuel -->
            <div class="card">
                <div class="card-header">
                    <h2>Activité mensuelle</h2>
                </div>
                <div class="card-body">
                    @if($monthlyStats->isEmpty())
                        <div class="empty-state">
                            <div class="empty-icon"></div>
                            <h3>Aucune donnée mensuelle</h3>
                            <p>Commencez à faire des réservations pour voir vos statistiques.</p>
                        </div>
                    @else
                        <div class="monthly-chart">
                            <div class="chart-container">
                                @foreach($monthlyStats as $stat)
                                    <div class="chart-bar">
                                        <div class="bar" style="height: {{ min($stat->count * 20, 200) }}px;"></div>
                                        <div class="bar-label">
                                            {{ \Carbon\Carbon::createFromDate($stat->year, $stat->month, 1)->format('M Y') }}
                                        </div>
                                        <div class="bar-value">{{ $stat->count }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Répartition par statut -->
            <div class="card">
                <div class="card-header">
                    <h2>Répartition par statut</h2>
                </div>
                <div class="card-body">
                    <div class="status-distribution">
                        @foreach($stats as $status => $count)
                            @if($status !== 'total' && $count > 0)
                                <div class="status-item">
                                    <div class="status-label">
                                        @if($status === 'pending')
                                            En attente
                                        @elseif($status === 'approved')
                                            Approuvées
                                        @elseif($status === 'active')
                                            En cours
                                        @elseif($status === 'completed')
                                            Terminées
                                        @elseif($status === 'cancelled')
                                            Annulées
                                        @endif
                                    </div>
                                    <div class="status-bar">
                                        <div class="status-fill status-{{ $status }}" 
                                             style="width: {{ ($count / $stats['total']) * 100 }}%;"></div>
                                    </div>
                                    <div class="status-count">{{ $count }} ({{ round(($count / $stats['total']) * 100, 1) }}%)</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card">
                <div class="card-header">
                    <h2>Actions rapides</h2>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                            + Nouvelle réservation
                        </a>
                        <a href="{{ route('reservations.history') }}" class="btn btn-outline">
                             Voir l'historique
                        </a>
                        <a href="{{ route('notifications.index') }}" class="btn btn-outline">
                             Mes notifications
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/reservations.js') }}"></script>
</body>
</html>
