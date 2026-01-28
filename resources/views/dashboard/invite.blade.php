@extends('layouts.app')

@section('title', 'Tableau de Bord Invité')

@section('content')
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
                <button class="logout-btn" onclick="showContactModal()">
                    <i class="fas fa-phone"></i>
                    Contact
                </button>
            </div>
        </header>

        <!-- Welcome Section -->
        <section class="welcome-section">
            <div class="welcome-icon">
                <i class="fas fa-cloud"></i>
            </div>
            <h2 class="welcome-title">DataCenter Cloud Services</h2>
            <p class="welcome-text">
                Découvrez notre infrastructure cloud de pointe, des ressources haute performance 
                et des services adaptés à vos besoins professionnels.
            </p>
        </section>

        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-server"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $statistics['totalResources'] ?? 0 }}</div>
                    <div class="stat-label">Ressources totales</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $statistics['availableResources'] ?? 0 }}</div>
                    <div class="stat-label">Disponibles</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $statistics['totalUsers'] ?? 0 }}</div>
                    <div class="stat-label">Utilisateurs</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="actions-section">
            <h2 class="section-title">Actions rapides</h2>
            <div class="quick-actions">
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
    margin-bottom: 10px;
}

.logo i {
    margin-right: 10px;
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
    margin-left: 260px;
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

.header-title p {
    color: var(--gray);
    font-size: 0.9rem;
    margin-top: 5px;
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

.logout-btn i {
    margin-right: 5px;
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
    display: flex;
    align-items: center;
    gap: 20px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    font-size: 2rem;
    color: var(--primary);
}

.stat-content {
    flex: 1;
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

/* Actions Section */
.actions-section {
    margin-bottom: 30px;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 20px;
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
}

.action-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    text-decoration: none;
    color: inherit;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-left: 4px solid var(--secondary);
    text-align: left;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.action-icon {
    font-size: 2rem;
    color: var(--secondary);
    margin-bottom: 15px;
}

.action-card h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 10px;
}

.action-card p {
    color: var(--gray);
    font-size: 0.9rem;
    line-height: 1.5;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.info-card {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 20px;
    background: var(--light);
    border-radius: 10px;
}

.info-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-card h3 {
    color: var(--dark);
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.info-card p {
    color: var(--gray);
    font-size: 0.85rem;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 2000;
    align-items: center;
    justify-content: center;
}

.modal.show {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 10px;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid var(--light-gray);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    color: var(--dark);
    font-size: 1.2rem;
    font-weight: 600;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--gray);
    cursor: pointer;
    padding: 5px;
}

.modal-close:hover {
    color: var(--dark);
}

.modal-body {
    padding: 20px;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.contact-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(25, 69, 105, 0.1);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.contact-details h4 {
    color: var(--dark);
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.contact-details p {
    color: var(--gray);
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
        gap: 15px;
        text-align: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

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
@endsection
