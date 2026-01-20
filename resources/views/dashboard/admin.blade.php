<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
        .dashboard-container { max-width: 1200px; margin: 0 auto; }
        .header { background: #4a6fa5; color: white; padding: 20px; text-align: center; position: relative; }
        .content { padding: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin: 15px 0; }
        .stat-card { background: white; padding: 15px; border: 1px solid #ddd; text-align: center; }
        .action-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; }
        .btn { display: inline-block; background: #4a6fa5; color: white; padding: 8px 15px; text-decoration: none; }
        .logout-btn { color: white; text-decoration: none; }
        @media (max-width: 768px) { .stats-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <div class="header-content">
                <h1>👑 Tableau de Bord Administrateur</h1>
                <p>Bienvenue, {{ Auth::user()->name }}</p>
            </div>
            <a href="/logout" class="logout-btn">🚪 Déconnexion</a>
        </div>
        
        <div class="content">
            <h2 class="section-title">📊 Vue d'ensemble</h2>
            <div class="stats-grid">
                <div class="stat-card" onclick="window.location.href='{{ route('admin.resources.index') }}'">
                    <i>💻</i>
                    <div class="stat-value">{{ $statistics['totalResources'] ?? 0 }}</div>
                    <div class="stat-label">Ressources totales</div>
                </div>
                <div class="stat-card" onclick="window.location.href='{{ route('admin.resources.index') }}?status=available'">
                    <i>✅</i>
                    <div class="stat-value">{{ $statistics['availableResources'] ?? 0 }}</div>
                    <div class="stat-label">Ressources disponibles</div>
                </div>
                <div class="stat-card" onclick="window.location.href='{{ route('admin.users.index') }}'">
                    <i>👥</i>
                    <div class="stat-value">{{ $statistics['totalUsers'] ?? 0 }}</div>
                    <div class="stat-label">Utilisateurs</div>
                </div>
                <div class="stat-card" onclick="window.location.href='{{ route('admin.reservations.index') }}'">
                    <i>📅</i>
                    <div class="stat-value">{{ $statistics['totalReservations'] ?? 0 }}</div>
                    <div class="stat-label">Réservations</div>
                </div>
            </div>

            @if(isset($statistics['reservationsByStatus']) && count($statistics['reservationsByStatus']) > 0)
            <h2 class="section-title">📊 Statut des réservations</h2>
            <div class="stats-grid">
                @foreach($statistics['reservationsByStatus'] as $status => $count)
                    <div class="stat-card" 
                         onclick="window.location.href='{{ route('admin.reservations.index') }}?status={{ $status }}'"
                         style="border-left-color: {{ 
                             $status === 'confirmed' ? '#38a169' : 
                             ($status === 'pending' ? '#d69e2e' : 
                             ($status === 'cancelled' ? '#e53e3e' : '#718096')) 
                         }};">
                        <i>
                            @if($status === 'confirmed') ✅
                            @elseif($status === 'pending') ⏳
                            @elseif($status === 'cancelled') ❌
                            @elseif($status === 'completed') ✔️
                            @else 📊
                            @endif
                        </i>
                        <div class="stat-value">{{ $count }}</div>
                        <div class="stat-label">{{ __("reservation.status.$status") }}</div>
                    </div>
                @endforeach
            </div>
            @endif
            
            <div class="actions-grid">
                <div class="action-card" onclick="window.location.href='{{ route('admin.users.index') }}'">
                    <h3>👥 Gestion des utilisateurs</h3>
                    <p>Créer, modifier, supprimer des comptes utilisateurs et gérer les rôles</p>
                    <div class="btn">Gérer les utilisateurs</div>
                </div>
                
                
                <div class="action-card" onclick="window.location.href='{{ route('admin.statistics.index') }}'">
                    <h3>📊 Statistiques globales</h3>
                    <p>Voir les rapports d'utilisation et les métriques du système</p>
                    <div class="btn">Voir les statistiques</div>
                </div>
                
                <div class="action-card" onclick="window.location.href='{{ route('admin.logs.index') }}'">
                    <h3>📝 Logs d'activité</h3>
                    <p>Consulter l'historique des actions et les audits de sécurité</p>
                    <div class="btn">Voir les logs</div>
                </div>
                
                <div class="action-card" onclick="window.location.href='{{ route('admin.resources.index') }}'">
                    <h3>🖥️ Gestion des ressources</h3>
                    <p>Administrer les serveurs, VMs et équipements réseau</p>
                    <div class="btn">Gérer les ressources</div>
                </div>
                
                <div class="action-card" onclick="window.location.href='{{ route('admin.settings.index') }}'">
                    <h3>⚙️ Configuration système</h3>
                    <p>Paramètres généraux et configuration du Data Center</p>
                    <div class="btn">Configuration</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
