@extends('layouts.app')

@section('title', 'Tableau de Bord Invité')

@section('content')
<style>
    /* --- CONFIGURATION GLOBALE --- */
    :root {
        --primary-slate: #434861;   /* Bleu-gris des boutons et icônes */
        --sidebar-bg: #d1d5db;      /* Gris lilas de la sidebar */
        --sidebar-hover: #c4c9d4;
        --bg-main: #f3f4f6;
        --white: #ffffff;
        --text-dark: #2d3748;
        --text-gray: #718096;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    /* Masquer la navigation par défaut du layout Laravel */
    nav.navbar, header.main-header {
        display: none !important;
    }

    .dashboard-container {
        display: flex !important;
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: var(--bg-main);
        z-index: 9999;
    }

    /* --- SIDEBAR (Style Image 2/3) --- */
    .sidebar {
        width: 260px;
        min-width: 260px;
        background: var(--sidebar-bg);
        height: 100%;
        display: flex;
        flex-direction: column;
        padding: 2rem 0;
        border-right: 1px solid rgba(0,0,0,0.05);
    }

    .logo {
        padding: 0 25px 40px;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--primary-slate);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .nav-menu { list-style: none; padding: 0 10px; margin: 0; }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        color: var(--text-gray);
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        margin-bottom: 5px;
        transition: 0.2s ease;
    }

    .nav-link:hover, .nav-link.active {
        background-color: var(--sidebar-hover);
        color: var(--primary-slate) !important;
    }

    /* --- CONTENU PRINCIPAL --- */
    .main-content {
        flex: 1;
        height: 100vh;
        overflow-y: auto;
        padding: 25px 40px;
    }

    /* --- HEADER (Identique aux captures Chayma/Admin) --- */
    .header-card {
        background: var(--white);
        padding: 20px 30px;
        border-radius: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--shadow);
        margin-bottom: 25px;
    }

    .header-info h1 { font-size: 1.4rem; color: var(--text-dark); margin: 0; font-weight: 700; }
    .header-info p { color: var(--text-gray); margin: 5px 0 0 0; font-size: 0.9rem; }

    .user-profile { display: flex; align-items: center; gap: 15px; }

    .avatar-circle {
        width: 45px; height: 45px;
        background-color: var(--primary-slate);
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 1.2rem;
    }

    .user-name { font-weight: 600; color: var(--text-dark); }
    
    .contact-link {
        color: var(--text-gray);
        text-decoration: none;
        display: flex; align-items: center; gap: 5px;
        font-size: 0.9rem;
        transition: 0.2s;
    }
    .contact-link:hover { color: var(--primary-slate); }

    /* --- SECTION BIENVENUE --- */
    .welcome-box {
        background: var(--white);
        padding: 60px;
        border-radius: 20px;
        text-align: center;
        box-shadow: var(--shadow);
        margin-bottom: 30px;
    }

    .welcome-box i.cloud-icon { font-size: 4rem; color: var(--primary-slate); margin-bottom: 20px; }

    /* --- GRILLE DE STATISTIQUES (Style Capture 6) --- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .stat-card {
        background: var(--white);
        padding: 25px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: var(--shadow);
    }

    .icon-box {
        width: 50px; height: 50px;
        background: #f8fafc;
        color: var(--primary-slate);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
    }

    .stat-data .number { font-size: 1.8rem; font-weight: 700; color: var(--primary-slate); line-height: 1; }
    .stat-data .label { color: var(--text-gray); font-size: 0.9rem; margin-top: 5px; }
</style>

<div class="dashboard-container">
    <aside class="sidebar">
        <div class="logo">
            <i class="fas fa-server"></i>
            <span>DataCenter</span>
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="#" class="nav-link active"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
                <li><a href="{{ route('resources.public') }}" class="nav-link"><i class="fas fa-server"></i> <span>Ressources</span></a></li>
                <li><a href="{{ route('public.resources.available') }}" class="nav-link"><i class="fas fa-calendar-check"></i> <span>Disponibilités</span></a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header class="header-card">
            <div class="header-info">
                <h1>Bienvenue sur DataCenter</h1>
                <p>Découvrez nos ressources et services cloud professionnels</p>
            </div>
            <div class="user-profile">
                <div class="avatar-circle">I</div>
                <span class="user-name">Invité</span>
                <a href="javascript:void(0)" onclick="showContactModal()" class="contact-link">
                    <i class="fas fa-phone-alt"></i> Contact
                </a>
            </div>
        </header>

        <div class="welcome-box">
            <i class="fas fa-cloud cloud-icon"></i>
            <h2 style="color: var(--primary-slate); font-size: 2.2rem; margin-bottom: 15px;">DataCenter Cloud Services</h2>
            <p style="color: var(--text-gray); max-width: 650px; margin: 0 auto 30px; line-height: 1.6;">
                Découvrez notre infrastructure cloud de pointe, des ressources haute performance et des services adaptés à vos besoins professionnels.
            </p>
            <a href="{{ route('resources.public') }}" style="background: var(--primary-slate); color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
                Explorer la plateforme <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon-box"><i class="fas fa-server"></i></div>
                <div class="stat-data">
                    <div class="number">{{ $statistics['totalResources'] ?? 5 }}</div>
                    <div class="label">Ressources totales</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon-box"><i class="fas fa-check-circle"></i></div>
                <div class="stat-data">
                    <div class="number">{{ $statistics['availableResources'] ?? 1 }}</div>
                    <div class="label">Disponibles</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon-box"><i class="fas fa-users"></i></div>
                <div class="stat-data">
                    <div class="number">{{ $statistics['totalUsers'] ?? 14 }}</div>
                    <div class="label">Utilisateurs</div>
                </div>
            </div>
        </div>
    </main>
</div>

<div id="contactModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:10000;">
    <div style="background:white; width:400px; margin:15% auto; padding:30px; border-radius:15px; position:relative;">
        <span onclick="hideContactModal()" style="position:absolute; right:20px; top:15px; cursor:pointer; font-size:1.5rem;">&times;</span>
        <h3 style="color:var(--primary-slate); margin-top:0;">Nous contacter</h3>
        <p>Email: contact@datacenter.com</p>
        <p>Tél: +33 1 23 45 67 89</p>
    </div>
</div>

<script>
    function showContactModal() { document.getElementById('contactModal').style.display = 'block'; }
    function hideContactModal() { document.getElementById('contactModal').style.display = 'none'; }
</script>
@endsection