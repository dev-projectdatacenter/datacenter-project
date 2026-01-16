<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - Data Center Management</title>
    
    <!-- Styles -->
    <style>
        /* Reset et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #2d3748;
            background-color: #f7fafc;
        }

        /* Variables CSS */
        :root {
            --primary-color: #667eea;
            --primary-dark: #5a67d8;
            --secondary-color: #764ba2;
            --success-color: #48bb78;
            --danger-color: #e53e3e;
            --warning-color: #ed8936;
            --info-color: #4299e1;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
            --background-light: #f7fafc;
            --background-white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1);
        }

        /* Layout Admin */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 250px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .admin-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-header h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .admin-header .user-role {
            font-size: 14px;
            opacity: 0.9;
        }

        .admin-nav {
            padding: 20px 0;
        }

        .admin-nav-item {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .admin-nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .admin-nav-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left-color: white;
        }

        .admin-nav-section {
            margin-bottom: 30px;
        }

        .admin-nav-title {
            padding: 0 20px;
            margin-bottom: 10px;
            font-size: 12px;
            text-transform: uppercase;
            opacity: 0.7;
            font-weight: 600;
        }

        .admin-main {
            flex: 1;
            margin-left: 250px;
            background-color: var(--background-light);
        }

        .admin-topbar {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
        }

        .admin-topbar-left h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .admin-topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            background: var(--background-light);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .admin-user-menu:hover {
            background: var(--border-color);
        }

        .admin-user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .admin-user-info {
            display: flex;
            flex-direction: column;
        }

        .admin-user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .admin-user-role {
            font-size: 12px;
            color: var(--text-secondary);
        }

        .admin-content {
            padding: 30px;
        }

        /* Alertes */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #f0fff4;
            border-color: #48bb78;
            color: #22543d;
        }

        .alert-danger {
            background-color: #fff5f5;
            border-color: #e53e3e;
            color: #742a2a;
        }

        .alert-warning {
            background-color: #fffbf0;
            border-color: #ed8936;
            color: #7c2d12;
        }

        .alert-info {
            background-color: #ebf8ff;
            border-color: #4299e1;
            color: #2a4e7c;
        }

        /* Boutons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .btn-secondary {
            background-color: var(--text-secondary);
            color: white;
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-warning {
            background-color: var(--warning-color);
            color: white;
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-lg {
            padding: 14px 28px;
            font-size: 16px;
        }

        .btn-full {
            width: 100%;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-sidebar.active {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .admin-content {
                padding: 20px 15px;
            }

            .admin-topbar {
                padding: 15px;
            }

            .admin-topbar-left h1 {
                font-size: 20px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-header">
                <h2>Data Center</h2>
                <div class="user-role">
                    {{ auth()->user()->role->name ?? 'Inconnu' }}
                </div>
            </div>

            <nav class="admin-nav">
                <div class="admin-nav-section">
                    <div class="admin-nav-title">Principal</div>
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-item">
                        📊 Dashboard
                    </a>
                </div>

                <div class="admin-nav-section">
                    <div class="admin-nav-title">Gestion</div>
                    <a href="{{ route('admin.users.index') }}" class="admin-nav-item">
                        👥 Utilisateurs
                    </a>
                    <a href="{{ route('admin.account-requests.index') }}" class="admin-nav-item">
                        📋 Demandes de compte
                    </a>
                    <a href="#" class="admin-nav-item">
                        🖥️ Ressources
                    </a>
                    <a href="#" class="admin-nav-item">
                        📅 Réservations
                    </a>
                </div>

                <div class="admin-nav-section">
                    <div class="admin-nav-title">Système</div>
                    <a href="{{ route('admin.logs.index') }}" class="admin-nav-item">
                        📝 Logs d'activité
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="admin-nav-item">
                        ⚙️ Paramètres
                    </a>
                </div>

                <div class="admin-nav-section">
                    <a href="{{ route('logout') }}" class="admin-nav-item" style="color: #ff6b6b;">
                        🚪 Déconnexion
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div class="admin-topbar-left">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
                    <h1>@yield('title', 'Administration')</h1>
                </div>

                <div class="admin-topbar-right">
                    <div class="admin-user-menu">
                        <div class="admin-user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="admin-user-info">
                            <span class="admin-user-name">{{ auth()->user()->name }}</span>
                            <span class="admin-user-role">{{ auth()->user()->role->name ?? 'Inconnu' }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        // Protection CSRF
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.csrfToken = token.getAttribute('content');
        }

        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const adminSidebar = document.getElementById('adminSidebar');

        if (mobileMenuToggle && adminSidebar) {
            mobileMenuToggle.addEventListener('click', function() {
                adminSidebar.classList.toggle('active');
            });
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                if (!adminSidebar.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                    adminSidebar.classList.remove('active');
                }
            }
        });

        // Fonctions utilitaires
        window.app = {
            // Afficher une alerte temporaire
            showAlert: function(message, type = 'info') {
                const alert = document.createElement('div');
                alert.className = `alert alert-${type} fade-in`;
                alert.textContent = message;
                
                // Insérer au début du content
                const content = document.querySelector('.admin-content');
                content.insertBefore(alert, content.firstChild);
                
                // Supprimer après 3 secondes
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.style.opacity = '0';
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.parentNode.removeChild(alert);
                            }
                        }, 300);
                    }
                }, 3000);
            },

            // Gérer les requêtes fetch avec CSRF
            fetch: function(url, options = {}) {
                const defaultOptions = {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken,
                        ...options.headers
                    }
                };
                
                return fetch(url, { ...defaultOptions, ...options });
            }
        };

        // Auto-fermeture des alertes de succès
        document.addEventListener('DOMContentLoaded', function() {
            const successAlerts = document.querySelectorAll('.alert-success');
            successAlerts.forEach(function(alert) {
                setTimeout(function() {
                    if (alert.parentNode) {
                        alert.style.opacity = '0';
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.parentNode.removeChild(alert);
                            }
                        }, 300);
                    }
                }, 5000);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
