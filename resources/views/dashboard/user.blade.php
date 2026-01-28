<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Utilisateur - DataCenter</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #194569;
            --primary-light: #e8f0fe;
            --secondary: #2c5282;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
            --light: #f8f9fa;
            --dark: #343a40;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --border-radius: 8px;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        
        body {
            background-color: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            padding: 1.5rem 0;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 100;
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
            background-color: rgba(108, 117, 125, 0.1);
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
            background-color: rgba(248, 37, 133, 0.1);
            color: #f72585;
        }
        
        /* Welcome Section */
        .welcome-section {
            background: white;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .welcome-icon {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        .welcome-title {
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .welcome-text {
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto 25px;
            line-height: 1.7;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            font-size: 2rem;
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
        
        /* Actions Grid */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .action-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--light-gray);
            cursor: pointer;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .action-card h3 {
            font-size: 1.2rem;
            color: var(--dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .action-card p {
            color: var(--gray);
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
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
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background-color: rgba(108, 117, 125, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar .logo span,
            .sidebar .nav-link span {
                display: none;
            }
            
            .sidebar .nav-link {
                justify-content: center;
                padding: 15px 0;
            }
            
            .sidebar .nav-link i {
                margin-right: 0;
                font-size: 1.2rem;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid,
            .actions-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .user-menu {
                margin-top: 10px;
            }
            
            .welcome-section {
                padding: 30px 20px;
            }
            
            .welcome-title {
                font-size: 1.5rem;
            }
        }
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
        
        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
            margin-right: 20px;
        }
        
        .profile-info h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
            color: var(--dark);
        }
        
        .profile-role {
            display: inline-block;
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--primary);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .profile-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .detail-item {
            margin-bottom: 10px;
        }
        
        .detail-label {
            font-size: 0.85rem;
            color: var(--gray);
            margin-bottom: 5px;
        }
        
        .detail-value {
            font-weight: 500;
            color: var(--dark);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar .logo span,
            .sidebar .nav-link span {
                display: none;
            }
            
            .sidebar .nav-link {
                justify-content: center;
                padding: 15px 0;
            }
            
            .sidebar .nav-link i {
                margin-right: 0;
                font-size: 1.2rem;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            
            .user-menu {
                margin-top: 10px;
            }
            
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-avatar {
                margin: 0 0 15px 0;
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
                        <a href="{{ route('dashboard.user') }}" class="nav-link {{ request()->routeIs('dashboard.user') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('resources.public') }}" class="nav-link {{ request()->routeIs('resources.*') ? 'active' : '' }}">
                            <i class="fas fa-server"></i>
                            <span>Ressources</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <i class="fas fa-tags"></i>
                            <span>Catégories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reservations.index') }}" class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Mes réservations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('incidents.index') }}" class="nav-link {{ request()->routeIs('incidents.*') ? 'active' : '' }}">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Incidents</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('maintenances.index') }}" class="nav-link {{ request()->routeIs('maintenances.*') ? 'active' : '' }}">
                            <i class="fas fa-tools"></i>
                            <span>Maintenances</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                            @php
                                $unreadCount = auth()->user()->unreadNotificationsCount();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="notification-badge">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="fas fa-cog"></i>
                            <span>Paramètres</span>
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
                    <h1>Tableau de bord</h1>
                    <p>Bienvenue, {{ Auth::user()->name }} ! Voici un aperçu de votre activité.</p>
                </div>
                <div class="user-menu">
                    <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </header>

            <!-- Welcome Section -->
            <section class="welcome-section">
                <div class="welcome-icon">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h1 class="welcome-title">Bienvenue sur votre espace personnel</h1>
                <p class="welcome-text">
                    Gérez facilement vos réservations, consultez vos notifications et accédez à toutes les fonctionnalités de la plateforme depuis ce tableau de bord.
                </p>
                <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nouvelle réservation
                </a>
            </section>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-value">{{ $statistics['activeReservations'] ?? 0 }}</div>
                    <div class="stat-label">Réservations actives</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value">{{ $statistics['pendingReservations'] ?? 0 }}</div>
                    <div class="stat-label">En attente</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ $statistics['completedReservations'] ?? 0 }}</div>
                    <div class="stat-label">Terminées</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="stat-value">{{ auth()->user()->unreadNotificationsCount() }}</div>
                    <div class="stat-label">Nouvelles notifications</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <h2 class="section-title" style="margin-bottom: 20px; font-size: 1.5rem; color: var(--dark);">Actions rapides</h2>
            <div class="actions-grid">
                <div class="action-card" onclick="window.location.href='{{ route('reservations.create') }}'">
                    <h3><i class="fas fa-desktop"></i> Réserver une ressource</h3>
                    <p>Consultez les disponibilités et réservez serveurs, VMs ou équipements</p>
                    <div class="btn btn-primary">Nouvelle réservation</div>
                </div>
                <div class="action-card" onclick="window.location.href='{{ route('reservations.index') }}'">
                    <h3><i class="fas fa-calendar"></i> Mes réservations</h3>
                    <p>Consultez l'état de vos réservations en cours, à venir ou passées</p>
                    <div class="btn btn-outline">Voir mes réservations</div>
                </div>
                <div class="action-card" onclick="window.location.href='{{ route('notifications.index') }}'">
                    <h3><i class="fas fa-bell"></i> Notifications</h3>
                    <p>Consultez vos notifications et restez informé des mises à jour</p>
                    <div class="btn btn-outline">Voir les notifications</div>
                </div>
                <div class="action-card" onclick="window.location.href='{{ route('incidents.create') }}'" style="border-left: 4px solid #f59e0b;">
                    <h3><i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i> Signaler un incident</h3>
                    <p>Signalez un problème technique ou une panne d'équipement</p>
                    <div class="btn" style="background-color: #fef3c7; color: #92400e; border: 1px solid #fcd34d;">Nouveau signalement</div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="recent-activity" style="margin-top: 40px;">
                <h2 class="section-title" style="margin-bottom: 20px; font-size: 1.5rem; color: var(--dark);">Activité récente</h2>
                <div class="activity-list" style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                    @if(isset($recentActivities) && count($recentActivities) > 0)
                        @foreach($recentActivities as $activity)
                            <div class="activity-item" style="display: flex; align-items: flex-start; padding: 15px 0; border-bottom: 1px solid var(--light-gray);">
                                <div class="activity-icon" style="width: 40px; height: 40px; background: rgba(67, 97, 238, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: var(--primary);">
                                    <i class="fas {{ $activity['icon'] ?? 'fa-bell' }}"></i>
                                </div>
                                <div class="activity-details" style="flex: 1;">
                                    <p class="activity-text" style="margin-bottom: 5px; color: var(--dark);">{{ $activity['text'] ?? 'Activité récente' }}</p>
                                    <span class="activity-time" style="font-size: 0.85rem; color: var(--gray);">{{ $activity['time'] ?? 'À l\'instant' }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="no-activity" style="text-align: center; padding: 20px; color: var(--gray);">Aucune activité récente à afficher.</p>
                    @endif
                </div>
            </div>
    </div>
</body>
</html>
