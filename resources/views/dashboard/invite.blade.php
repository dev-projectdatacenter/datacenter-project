<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Invité - Data Center</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
            min-height: 100vh;
            padding: 2rem;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
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
        .welcome-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            border-left: 4px solid #718096;
            margin-bottom: 2rem;
        }
        .welcome-card h2 {
            color: #4a5568;
            margin-bottom: 1rem;
        }
        .welcome-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        .actions-grid {
            display: grid;
            grid-template-columns: 1fr;
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
            border-color: #718096;
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
            background: #718096;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #4a5568;
        }
        .btn-primary {
            background: #667eea;
        }
        .btn-primary:hover {
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
        .info-box {
            background: #e6fffa;
            border: 1px solid #81e6d9;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }
        .info-box h4 {
            color: #234e52;
            margin-bottom: 0.5rem;
        }
        .info-box p {
            color: #2c7a7b;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <a href="/logout" class="logout-btn">🚪 Déconnexion</a>
            <h1>👥 Dashboard Invité</h1>
            <p>Bienvenue {{ $user->name }} - Accès limité en consultation</p>
        </div>
        
        <div class="content">
            <div class="welcome-card">
                <h2>🌟 Bienvenue dans le Data Center Management</h2>
                <p>
                    Vous êtes actuellement connecté en tant qu'invité. Ce statut vous permet d'explorer 
                    les ressources disponibles et de comprendre le fonctionnement du système avant de demander 
                    un accès complet.
                </p>
                <p>
                    Le Data Center Management est une plateforme conçue pour faciliter la réservation 
                    et la gestion des ressources informatiques au sein de notre organisation. 
                    Vous pouvez réserver des serveurs, des machines virtuelles, et d'autres équipements 
                    pour vos projets et besoins professionnels.
                </p>
                <div class="info-box">
                    <h4>📋 Pourquoi demander un compte complet ?</h4>
                    <p>
                        Un compte complet vous permettra de réserver des ressources, 
                        suivre vos réservations, signaler des incidents, et accéder à 
                        des fonctionnalités avancées adaptées à votre profil.
                    </p>
                </div>
            </div>
            
            <div class="actions-grid">
                <div class="action-card">
                    <h3>🔍 Explorer les ressources</h3>
                    <p>Découvrez les serveurs, VMs et équipements disponibles dans notre Data Center</p>
                    <a href="#" class="btn">Explorer les ressources</a>
                </div>
                
                <div class="action-card">
                    <h3>📚 Documentation</h3>
                    <p>Consultez les guides d'utilisation et les procédures du Data Center</p>
                    <a href="#" class="btn">Voir la documentation</a>
                </div>
                
                <div class="action-card">
                    <h3>📝 Demander un compte</h3>
                    <p>Accédez à toutes les fonctionnalités en demandant un compte utilisateur complet</p>
                    <a href="/register" class="btn btn-primary">Demander un compte</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>