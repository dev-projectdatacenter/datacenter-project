<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Data Center</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            border-left: 4px solid #667eea;
        }
        .stat-card h3 {
            color: #667eea;
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
            border-color: #667eea;
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
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5a67d8;
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
            <h1>👑 Dashboard Administrateur</h1>
            <p>Bienvenue {{ $user->name }} - Gestion complète du Data Center</p>
        </div>
        
        <div class="content">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>👥 Utilisateurs</h3>
                    <div class="number">{{ \App\Models\User::count() }}</div>
                </div>
                <div class="stat-card">
                    <h3>🖥️ Ressources</h3>
                    <div class="number">0</div>
                </div>
                <div class="stat-card">
                    <h3>📅 Réservations</h3>
                    <div class="number">0</div>
                </div>
                <div class="stat-card">
                    <h3>🔧 Maintenances</h3>
                    <div class="number">0</div>
                </div>
            </div>
            
            <div class="actions-grid">
                <div class="action-card">
                    <h3>👥 Gestion des utilisateurs</h3>
                    <p>Créer, modifier, supprimer des comptes utilisateurs et gérer les rôles</p>
                    <a href="#" class="btn">Gérer les utilisateurs</a>
                </div>
                
                <div class="action-card">
                    <h3>🔐 Permissions et rôles</h3>
                    <p>Configurer les droits d'accès et les permissions par rôle</p>
                    <a href="#" class="btn">Gérer les rôles</a>
                </div>
                
                <div class="action-card">
                    <h3>📊 Statistiques globales</h3>
                    <p>Voir les rapports d'utilisation et les métriques du système</p>
                    <a href="#" class="btn">Voir les statistiques</a>
                </div>
                
                <div class="action-card">
                    <h3>📝 Logs d'activité</h3>
                    <p>Consulter l'historique des actions et les audits de sécurité</p>
                    <a href="#" class="btn">Voir les logs</a>
                </div>
                
                <div class="action-card">
                    <h3>🖥️ Gestion des ressources</h3>
                    <p>Administrer les serveurs, VMs et équipements réseau</p>
                    <a href="#" class="btn">Gérer les ressources</a>
                </div>
                
                <div class="action-card">
                    <h3>⚙️ Configuration système</h3>
                    <p>Paramètres généraux et configuration du Data Center</p>
                    <a href="#" class="btn">Configuration</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
