<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Invité - DataCenter</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #194569;
            --secondary: #5a6268;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
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
            min-height: 100vh;
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
        
        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--light-gray);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .contact-info {
            margin: 20px 0;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: #e0e0e0;
            font-size: 0.9rem;
        }
        
        .contact-item:last-child {
            margin-bottom: 0;
        }
        
        .contact-item i {
            width: 20px;
            margin-right: 10px;
            color: var(--primary);
        }
        
        .contact-item span {
            flex: 1;
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        .feature-title {
            font-size: 1.3rem;
            color: var(--dark);
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .feature-text {
            color: var(--gray);
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
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
        
        /* Upgrade Banner */
        .upgrade-banner {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 30px;
            margin-top: 40px;
            text-align: center;
            border: 1px solid var(--light-gray);
        }
        
        .upgrade-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .upgrade-title {
            font-size: 1.8rem;
            color: var(--dark);
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .upgrade-text {
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto 25px;
            line-height: 1.7;
        }
        
        .benefits-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin: 25px 0;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            background: white;
            padding: 10px 20px;
            border-radius: 50px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            font-size: 0.9rem;
            color: var(--dark);
        }
        
        .benefit-item i {
            color: var(--success);
            margin-right: 8px;
            font-size: 1.1rem;
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
            .features-grid {
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
            
            .benefits-list {
                flex-direction: column;
                align-items: center;
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
                            <i class="fas fa-home"></i>
                            <span>Tableau de bord</span>
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
                            <i class="fas fa-calendar"></i>
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
                    <h1>Tableau de bord invité</h1>
                </div>
                <div class="user-menu">
                    <span class="user-name">Invité</span>
                    <div class="user-avatar">I</div>
                    <a href="{{ route('login') }}" class="logout-btn" title="Se connecter">
                        <i class="fas fa-sign-in-alt"></i>
                    </a>
                </div>
            </header>
            
            <!-- Welcome Section -->
            <section class="welcome-section">
                <div class="welcome-icon">
                    <i class="fas fa-hand-wave"></i>
                </div>
                <h1 class="welcome-title">Bienvenue, Invité !</h1>
            </section>
            
            <!-- Features Grid -->
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <h3 class="feature-title">Ressources disponibles</h3>
                    <p class="feature-text">
                        Parcourez et consultez les ressources disponibles sur notre plateforme.
                        Visualisez les détails et les spécifications techniques.
                    </p>
                    <a href="{{ route('resources.public') }}" class="btn btn-outline">
                        <i class="fas fa-eye"></i> Voir les ressources
                    </a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="feature-title">Disponibilités</h3>
                    <p class="feature-text">
                        Consultez les créneaux disponibles pour les ressources partagées.
                        Parfait pour planifier vos futures réservations.
                    </p>
                    <a href="{{ route('public.resources.available') }}" class="btn btn-outline">
                        <i class="far fa-calendar"></i> Voir les disponibilités
                    </a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="feature-title">Support & Assistance</h3>
                    <p class="feature-text">
                        Notre équipe est là pour vous accompagner.
                    </p>
                    <a href="#" onclick="showContactModal()" class="btn btn-outline">
                        <i class="fas fa-envelope"></i> Nous contacter
                    </a>
                </div>
            </div>
        </main>
    </div>

    <!-- Contact Modal -->
    <div id="contactModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Informations de Contact</h3>
                <span class="close" onclick="closeContactModal()">&times;</span>
            </div>
            <div class="modal-body">
                @php
                    $settings = \App\Models\Setting::all()->pluck('value', 'key');
                    $contactEmail = $settings['contact_email'] ?? 'contact@example.com';
                    $siteName = $settings['site_name'] ?? 'Data Center Manager';
                @endphp
                <div class="contact-modal-item">
                    <i class="fas fa-envelope"></i>
                    <span>{{ $contactEmail }}</span>
                </div>
                <div class="contact-modal-item">
                    <i class="fas fa-building"></i>
                    <span>{{ $siteName }}</span>
                </div>
                <div class="contact-modal-item">
                    <i class="fas fa-phone"></i>
                    <span>+33 1 23 45 67 89</span>
                </div>
                <div class="contact-modal-item">
                    <i class="fas fa-clock"></i>
                    <span>Lun-Ven: 9h-18h</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showContactModal() {
            document.getElementById('contactModal').style.display = 'block';
        }

        function closeContactModal() {
            document.getElementById('contactModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('contactModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>

    <style>
        .modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            border-bottom: 1px solid #e9ecef;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1.3rem;
        }

        .close {
            color: white;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }

        .close:hover {
            opacity: 0.7;
        }

        .modal-body {
            padding: 30px 25px;
        }

        .contact-modal-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid var(--primary);
        }

        .contact-modal-item:last-child {
            margin-bottom: 0;
        }

        .contact-modal-item i {
            width: 24px;
            margin-right: 15px;
            color: var(--primary);
            font-size: 1.1rem;
        }

        .contact-modal-item span {
            font-size: 1rem;
            color: #333;
            font-weight: 500;
        }
    </style>
    
    <script>
        // Script pour les interactions utilisateur (optionnel)
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Tableau de bord invité chargé');
            
            // Animation au survol des cartes de fonctionnalités
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px)';
                    this.style.boxShadow = '0 15px 30px rgba(0, 0, 0, 0.1)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
                });
            });
        });
    </script>
</body>
</html>
