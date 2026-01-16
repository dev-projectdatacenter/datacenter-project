<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tech Manager - Data Center</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            min-height: 100vh;
            padding: 2rem;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        .content {
            padding: 2rem;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #48bb78;
        }
        .stat-card h3 {
            color: #48bb78;
            margin-bottom: 0.5rem;
        }
        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .action-card {
            background: white;
            border: 2px solid #e2e8f0;
            padding: 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .action-card:hover {
            border-color: #48bb78;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .action-card h3 {
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .action-card p {
            color: #666;
            margin-bottom: 1rem;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #48bb78;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #38a169;
        }
        .logout-btn {
            position: absolute;
            top: 2rem;
            right: 2rem;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <a href="/logout" class="logout-btn">🚪 Déconnexion</a>
            <h1>🛠️ Dashboard Responsable Technique</h1>
            <p>Bienvenue {{ $user->name }} - Supervision des ressources techniques</p>
        </div>
        
        <div class="content">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>🖥️ Serveurs actifs</h3>
                    <div class="number">0</div>
                </div>
                <div class="stat-card">
                    <h3>📅 Réservations en attente</h3>
                    <div class="number">0</div>
                </div>
                <div class="stat-card">
                    <h3>🔧 Maintenances planifiées</h3>
                    <div class="number">0</div>
                </div>
                <div class="stat-card">
                    <h3>⚠️ Incidents signalés</h3>
                    <div class="number">0</div>
                </div>
            </div>
            
            <div class="actions-grid">
                <div class="action-card">
                    <h3>🖥️ Gestion des ressources</h3>
                    <p>Ajouter, modifier et superviser les serveurs, VMs et équipements</p>
                    <a href="#" class="btn">Gérer les ressources</a>
                </div>
                
                <div class="action-card">
                    <h3>📅 Validation des réservations</h3>
                    <p>Approuver ou rejeter les demandes de réservation des utilisateurs</p>
                    <a href="#" class="btn">Valider les réservations</a>
                </div>
                
                <div class="action-card">
                    <h3>🔧 Planification des maintenances</h3>
                    <p>Programmer et suivre les opérations de maintenance</p>
                    <a href="#" class="btn">Planifier maintenances</a>
                </div>
                
                <div class="action-card">
                    <h3>📊 Rapports techniques</h3>
                    <p>Statistiques d'utilisation et performance des ressources</p>
                    <a href="#" class="btn">Voir les rapports</a>
                </div>
                
                <div class="action-card">
                    <h3>⚠️ Gestion des incidents</h3>
                    <p>Traiter les signalements et les pannes matérielles</p>
                    <a href="#" class="btn">Gérer les incidents</a>
                </div>
                
                <div class="action-card">
                    <h3>📈 Monitoring</h3>
                    <p>Surveillance en temps réel des infrastructures</p>
                    <a href="#" class="btn">Monitoring</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
