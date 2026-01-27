<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resource->name }} - Data Center</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 28px;
        }
        .back-link {
            background: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .back-link:hover {
            background: #2980b9;
        }
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        .info-card {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        .info-card h3 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .specs-list {
            list-style: none;
            padding: 0;
        }
        .specs-list li {
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
        }
        .specs-list li:last-child {
            border-bottom: none;
        }
        .specs-list strong {
            color: #2c3e50;
            min-width: 120px;
        }
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        .status-available { background: #d4edda; color: #155724; }
        .status-maintenance { background: #fff3cd; color: #856404; }
        .status-unavailable { background: #f8d7da; color: #721c24; }
        .guest-notice {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }
        .guest-notice h4 {
            color: #1976d2;
            margin-top: 0;
        }
        .action-links {
            text-align: center;
            margin-top: 30px;
        }
        .action-links a {
            display: inline-block;
            margin: 0 10px;
            padding: 12px 24px;
            background: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .action-links a:hover {
            background: #229954;
        }
        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
            .header {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🖥️ {{ $resource->name }}</h1>
            <a href="/all-resources" class="back-link">← Retour aux ressources</a>
        </div>

        <div class="guest-notice">
            <h4>👋 Vue Invité</h4>
            <p>Vous consultez cette ressource en mode lecture seule. Pour réserver cette ressource, 
               <a href="/request-account">demandez un compte</a>.</p>
        </div>

        <div class="details-grid">
            <div class="info-card">
                <h3>📋 Spécifications techniques</h3>
                <ul class="specs-list">
                    <li><strong>Catégorie :</strong> {{ $resource->category->name ?? 'Non définie' }}</li>
                    <li><strong>Processeur :</strong> {{ $resource->cpu ?? 'Non spécifié' }}</li>
                    <li><strong>RAM :</strong> {{ $resource->ram ?? 'Non spécifiée' }}</li>
                    <li><strong>Stockage :</strong> {{ $resource->storage ?? 'Non spécifié' }}</li>
                    <li><strong>Bande passante :</strong> {{ $resource->bandwidth ?? 'Non spécifiée' }}</li>
                    <li><strong>OS :</strong> {{ $resource->os ?? 'Non spécifié' }}</li>
                    <li><strong>Localisation :</strong> {{ $resource->location ?? 'Non spécifiée' }}</li>
                </ul>
            </div>

            <div class="info-card">
                <h3>📊 État actuel</h3>
                <p><strong>Statut :</strong> 
                    <span class="status-badge status-{{ $resource->status }}">
                        {{ $resource->status }}
                    </span>
                </p>
                <p><strong>Ajoutée le :</strong> {{ $resource->created_at->format('d/m/Y') }}</p>
                <p><strong>Dernière mise à jour :</strong> {{ $resource->updated_at->format('d/m/Y H:i') }}</p>
                
                @if($resource->description)
                <h4 style="margin-top: 20px;">📝 Description</h4>
                <p>{{ $resource->description }}</p>
                @endif
            </div>
        </div>

        <div class="action-links">
            <a href="/all-resources">📚 Voir toutes les ressources</a>
            <a href="/rules">📋 Consulter les règles</a>
            <a href="/request-account">👤 Demander un compte</a>
        </div>
    </div>
</body>
</html>
