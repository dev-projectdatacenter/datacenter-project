<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
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
    <div class="dashboard-container">
                
                <div class="action-card">
                    <h3>📚 Documentation</h3>
                    <p>Consultez les guides d'utilisation et les procédures du Data Center</p>
                    <a href="#" class="btn">Voir la documentation</a>
                </div>
                
                <div class="action-card">
                    <h3>📝 Demander un compte</h3>
                    <p>Accédez à toutes les fonctionnalités en demandant un compte utilisateur complet</p>
                    <a href="/register" class="btn btn-primary">Demander un compte</a>
=======
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
>>>>>>> feature/backend/-database
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
=======

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
>>>>>>> feature/backend/-database
</body>
</html>
