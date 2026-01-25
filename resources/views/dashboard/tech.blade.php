<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tech Manager</title>
    <style>
        /* Styles de base */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        
        /* Conteneur principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* En-tête */
        .header {
            background: #2e7d32;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            position: relative;
            text-align: center;
        }
        
        /* Boutons */
        .btn {
            display: inline-block;
            background: #2e7d32;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #1b5e20;
        }
        
        /* Bouton de déconnexion */
        .logout-btn {
            position: absolute;
            right: 20px;
            top: 20px;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <form action="{{ route('logout') }}" method="POST" class="logout-btn" style="border: none; padding: 0;">
                @csrf
                <button type="submit" style="background: none; border: none; color: white; cursor: pointer; font-size: 16px;">🚪 Déconnexion</button>
            </form>
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
</body>
</html>
