<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Technique - DataCenter</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #194569;
            --secondary: #2c5282;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #6c757d;
            --light-gray: #e9ecef;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            line-height: 1.6;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            padding: 20px 0;
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }
        
        .logo {
            text-align: center;
            padding: 20px 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            border-bottom: 1px solid var(--light-gray);
            margin-bottom: 20px;
        }
        
        .nav-menu {
            list-style: none;
            padding: 0 15px;
        }
        
        .nav-item {
            margin-bottom: 5px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--gray);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }
        
        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }
        
        .header-title h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .header-subtitle {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: 500;
        }
        
        .user-name {
            margin-right: 15px;
            font-weight: 500;
        }
        
        .logout-btn {
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            border-left: 4px solid var(--primary);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card i {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: var(--primary);
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            border: none;
            font-size: 0.9rem;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }
        
        .btn-warning {
            background-color: var(--warning);
            color: white;
        }
        
        .btn-warning:hover {
            background-color: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }
        
        .btn-info {
            background-color: var(--info);
            color: white;
        }
        
        .btn-info:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        /* Table */
        .table-responsive {
            overflow-x: auto;
            margin-top: 15px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }
        
        th {
            background-color: var(--light);
            font-weight: 600;
            color: var(--dark);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        tr:hover {
            background-color: var(--light);
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
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
</body>
</html>
