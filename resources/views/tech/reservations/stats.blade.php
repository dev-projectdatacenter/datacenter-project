<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des approbations - Data Center</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reservations.css') }}">
</head>
<body>
    <div class="app-container">
        <!-- Navigation -->
        @include('components.navigation', ['title' => 'Statistiques'])
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">Statistiques des approbations</h1>
                <div class="page-actions">
                    <a href="{{ route('tech.reservations.pending') }}" class="btn btn-outline">
                        <i class="fas fa-list"></i>
                        Demandes en attente
                    </a>
                </div>
            </div>

            <!-- Cartes de statistiques -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $stats['pending'] }}</h3>
                        <p>Demandes en attente</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $stats['approved_today'] }}</h3>
                        <p>Approuvées aujourd'hui</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $stats['rejected_today'] }}</h3>
                        <p>Refusées aujourd'hui</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon info">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $stats['total_approved'] + $stats['total_rejected'] }}</h3>
                        <p>Total traitées</p>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="card">
                <div class="card-header">
                    <h2>Répartition des décisions</h2>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <div class="chart-row">
                            <div class="chart-item">
                                <div class="chart-label">Approuvées</div>
                                <div class="chart-bar">
                                    <div class="chart-fill success" style="width: {{ $stats['total_approved'] > 0 ? ($stats['total_approved'] / ($stats['total_approved'] + $stats['total_rejected'])) * 100 : 0 }}%"></div>
                                </div>
                                <div class="chart-value">{{ $stats['total_approved'] }}</div>
                            </div>
                            
                            <div class="chart-item">
                                <div class="chart-label">Refusées</div>
                                <div class="chart-bar">
                                    <div class="chart-fill danger" style="width: {{ $stats['total_rejected'] > 0 ? ($stats['total_rejected'] / ($stats['total_approved'] + $stats['total_rejected'])) * 100 : 0 }}%"></div>
                                </div>
                                <div class="chart-value">{{ $stats['total_rejected'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card">
                <div class="card-header">
                    <h2>Actions rapides</h2>
                </div>
                <div class="card-body">
                    <div class="action-grid">
                        <a href="{{ route('tech.reservations.pending') }}" class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="action-content">
                                <h3>Traiter les demandes</h3>
                                <p>{{ $stats['pending'] }} demande(s) en attente</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('reservations.index') }}" class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="action-content">
                                <h3>Voir toutes les réservations</h3>
                                <p>Gestion complète</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('notifications.index') }}" class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="action-content">
                                <h3>Notifications</h3>
                                <p>Gérer les alertes</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="card">
                <div class="card-header">
                    <h2>Informations système</h2>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Taux d'approbation</div>
                            <div class="info-value">
                                @if($stats['total_approved'] + $stats['total_rejected'] > 0)
                                    {{ round(($stats['total_approved'] / ($stats['total_approved'] + $stats['total_rejected'])) * 100, 1) }}%
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Activité aujourd'hui</div>
                            <div class="info-value">
                                {{ $stats['approved_today'] + $stats['rejected_today'] }} décision(s)
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Demandes en attente</div>
                            <div class="info-value">
                                {{ $stats['pending'] }} demande(s)
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Dernière mise à jour</div>
                            <div class="info-value">
                                {{ now()->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Rafraîchir les statistiques toutes les 30 secondes
        setInterval(function() {
            location.reload();
        }, 30000);
        
        // Animation des chiffres au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const statValues = document.querySelectorAll('.stat-content h3');
            statValues.forEach(value => {
                const finalValue = parseInt(value.textContent);
                let currentValue = 0;
                const increment = Math.ceil(finalValue / 20);
                
                const counter = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        currentValue = finalValue;
                        clearInterval(counter);
                    }
                    value.textContent = currentValue;
                }, 50);
            });
        });
    </script>
</body>
</html>
