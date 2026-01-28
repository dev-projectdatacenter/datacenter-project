<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Invité - DataCenter</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem 0;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            z-index: 1000;
        }

        .logo {
            text-align: center;
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }

        .logo i {
            font-size: 2.5rem;
            color: #4fc3f7;
            margin-bottom: 0.5rem;
        }

        .logo span {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
        }

        .nav-menu {
            list-style: none;
            padding: 0 1rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateX(5px);
        }

        .nav-link i {
            margin-right: 1rem;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-title h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .header-title p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(79, 195, 247, 0.3);
        }

        .user-name {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }

        .contact-btn {
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 195, 247, 0.3);
        }

        .contact-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 195, 247, 0.4);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border-color: rgba(79, 195, 247, 0.5);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        /* Actions Section */
        .actions-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .action-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border-color: rgba(79, 195, 247, 0.5);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .action-card h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .action-card p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* Info Section */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #ffa726 0%, #ff9800 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }

        .info-content h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .info-content p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            line-height: 1.4;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border-radius: 16px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #fff;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .contact-details h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #fff;
        }

        .contact-details p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .actions-grid {
                grid-template-columns: 1fr;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <i class="fas fa-server"></i>
                <span>DataCenter</span>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('resources.public') }}" class="nav-link">
                            <i class="fas fa-server"></i>
                            <span>Ressources</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('public.resources.available') }}" class="nav-link">
                            <i class="fas fa-calendar-check"></i>
                            <span>Disponibilités</span>
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
                    <h1>Bienvenue sur DataCenter</h1>
                    <p>Découvrez nos ressources et services cloud professionnels</p>
                </div>
                <div class="user-menu">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="user-name">Invité</span>
                    <button class="contact-btn" onclick="showContactModal()">
                        <i class="fas fa-phone"></i>
                        Contact
                    </button>
                </div>
            </header>

            <!-- Stats Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <div class="stat-value">{{ $statistics['totalResources'] ?? 0 }}</div>
                    <div class="stat-label">Ressources totales</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ $statistics['availableResources'] ?? 0 }}</div>
                    <div class="stat-label">Disponibles</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-value">{{ $statistics['totalUsers'] ?? 0 }}</div>
                    <div class="stat-label">Utilisateurs</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="actions-section">
                <h2 class="section-title">Actions rapides</h2>
                <div class="actions-grid">
                    <a href="{{ route('resources.public') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="action-content">
                            <h3>Voir les ressources</h3>
                            <p>Explorez notre infrastructure cloud</p>
                        </div>
                    </a>
                    <a href="{{ route('public.resources.available') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="action-content">
                            <h3>Disponibilités</h3>
                            <p>Vérifiez les ressources disponibles</p>
                        </div>
                    </a>
                    <div class="action-card" onclick="showContactModal()">
                        <div class="action-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="action-content">
                            <h3>Nous contacter</h3>
                            <p>Obtenez de l'aide ou des informations</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3>Sécurité garantie</h3>
                        <p>Infrastructure sécurisée avec monitoring 24/7</p>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <div class="info-content">
                        <h3>Haute performance</h3>
                        <p>Équipements de dernière génération pour des performances optimales</p>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="info-content">
                        <h3>Support technique</h3>
                        <p>Équipe d'experts disponible pour vous accompagner</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Contact Modal -->
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Nous contacter</h3>
                <button class="modal-close" onclick="hideContactModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p>contact@datacenter.com</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Téléphone</h4>
                            <p>+33 1 234 567 890</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Adresse</h4>
                            <p>123 Rue de la Tech, 75001 Paris</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Horaires</h4>
                            <p>Lun-Ven: 9h-18h</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showContactModal() {
            document.getElementById('contactModal').classList.add('show');
        }

        function hideContactModal() {
            document.getElementById('contactModal').classList.remove('show');
        }

        // Close modal when clicking outside
        document.getElementById('contactModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideContactModal();
            }
        });
    </script>
</body>
</html>
