<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utilisateur - Data Center</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
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
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
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
            border-left: 4px solid #4299e1;
        }
        .stat-card h3 {
            color: #4299e1;
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
            border-color: #4299e1;
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
            background: #4299e1;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #3182ce;
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
            <h1>👤 Dashboard Utilisateur</h1>
            <p>Bienvenue {{ $user->name }} - Réservation de ressources informatiques</p>
        </div>
        
        <div class="content">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>📅 Mes réservations</h3>
                    <div class="number">0</div>
                </div>
                <div class="stat-card">
                    <h3>🖥️ Ressources disponibles</h3>
                    <div class="number">0</div>
                </div>
                <div class="stat-card">
                    <h3>⏰ Réservations en cours</h3>
                    <div class="number">0</div>
                </div>
                <div class="stat-card">
                    <h3>📊 Utilisation ce mois</h3>
                    <div class="number">0h</div>
                </div>
            </div>
            
            <div class="actions-grid">
                <div class="action-card">
                    <h3>🖥️ Réserver une ressource</h3>
                    <p>Consultez les disponibilités et réservez serveurs, VMs ou équipements</p>
                    <a href="{{ route('reservations.create') }}" class="btn">Nouvelle réservation</a>
                </div>
                
                <div class="action-card">
                    <h3>📋 Mes réservations</h3>
                    <p>Gérez vos réservations actuelles et consultez l'historique</p>
                    <a href="{{ route('reservations.index') }}" class="btn">Voir mes réservations</a>
                </div>
                
                <div class="action-card">
                    <h3>📊 Mes statistiques</h3>
                    <p>Suivez votre utilisation des ressources et vos rapports personnels</p>
                    <a href="{{ route('statistics.my_resources') }}" class="btn">Mes statistiques</a>
                </div>
                
                <div class="action-card">
                    <h3>⚠️ Signaler un incident</h3>
                    <p>Signalez des problèmes techniques ou des pannes sur les ressources</p>
                    <a href="{{ route('incidents.index') }}" class="btn">Signaler un incident</a>
                </div>
                
                <div class="action-card">
                    <h3>📚 Documentation</h3>
                    <p>Consultez les guides d'utilisation et les bonnes pratiques</p>
                    <a href="/resources" class="btn">Documentation</a>
                </div>
                
                <div class="action-card">
                    <h3>👥 Support technique</h3>
                    <p>Contactez l'équipe technique pour obtenir de l'aide</p>
                    <a href="/notifications" class="btn">Contacter le support</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>