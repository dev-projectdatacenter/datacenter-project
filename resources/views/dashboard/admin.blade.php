@extends('layouts.app')

@section('title', 'Tableau de Bord Admin')

@section('content')
<style>
    /* 1. ON FORCE LE CONTENEUR À PRENDRE TOUTE LA LARGEUR */
    /* On utilise fixed et top:0 left:0 pour ignorer les marges du layout app.blade */
    .dashboard-fixed-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        display: flex;
        background-color: #f3f4f6;
        z-index: 9999; /* Passe au dessus de la navbar par défaut s'il y en a une */
    }

    /* 2. SIDEBAR - GRIS LILAS (Image 2) */
    .sidebar {
        width: 280px;
        min-width: 280px;
        background-color: #d1d5db; /* Ton gris lilas exact */
        height: 100%;
        display: flex;
        flex-direction: column;
        padding: 2rem 0;
        box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    }

    .logo-container {
        padding: 0 30px 40px;
        font-size: 1.8rem;
        font-weight: 700;
        color: #434861;
        text-align: center;
    }

    .nav-menu { list-style: none; padding: 0 15px; }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 14px 20px;
        color: #4a5568;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 500;
        margin-bottom: 5px;
        transition: all 0.2s;
    }

    .nav-link:hover, .nav-link.active {
        background-color: #c4c9d4;
        color: #434861 !important;
    }

    /* 3. MAIN CONTENT - PREND TOUT LE RESTE DE L'ESPACE */
    .main-content {
        flex-grow: 1;
        overflow-y: auto;
        padding: 40px;
        background-color: #f3f4f6;
    }

    /* HEADER STYLE IMAGE 2 */
    .header-card {
        background: white;
        padding: 25px 35px;
        border-radius: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        margin-bottom: 30px;
    }

    /* BOUTON STYLE IMAGE 1 */
    .btn-action-slate {
        background-color: #434861; /* Ton bleu-gris exact */
        color: white;
        padding: 12px 28px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-weight: 500;
        border: none;
        cursor: pointer;
    }

    .user-badge {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar-circle {
        width: 40px;
        height: 40px;
        background: #434861;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    /* Masquer les éléments parasites du layout parent */
    #app > nav { display: none !important; }
</style>

<div class="dashboard-fixed-wrapper">
    <aside class="sidebar">
        <div class="logo-container">DataCenter</div>
        <nav class="nav-menu">
            <a href="#" class="nav-link active"><i class="fas fa-home"></i> <span>Tableau de bord</span></a>
            <a href="{{ route('admin.resources.index') }}" class="nav-link"><i class="fas fa-server"></i> <span>Ressources</span></a>
            <a href="{{ route('admin.users.index') }}" class="nav-link"><i class="fas fa-users"></i> <span>Utilisateurs</span></a>
            <a href="{{ route('admin.reservations.index') }}" class="nav-link"><i class="fas fa-calendar-alt"></i> <span>Réservations</span></a>
            <a href="{{ route('admin.logs.index') }}" class="nav-link"><i class="fas fa-terminal"></i> <span>Logs système</span></a>
            <a href="{{ route('admin.settings.index') }}" class="nav-link"><i class="fas fa-cog"></i> <span>Paramètres</span></a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="header-card">
            <div>
                <h1 style="color: #434861; margin:0;">Tableau de bord Administrateur</h1>
                <p style="color: #718096; margin-top:5px;">Bienvenue, {{ auth()->user()->name }} !</p>
            </div>
            <div class="user-badge">
                <div class="avatar-circle">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <span style="font-weight: 600;">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="margin-left:15px;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#718096; cursor:pointer;">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>

        <div style="background: white; padding: 60px; border-radius: 20px; text-align: center; border: 1px solid #edf2f7;">
            <div style="font-size: 4rem; color: #434861; margin-bottom: 25px;">
                <i class="fas fa-user-shield"></i>
            </div>
            <h2 style="color: #434861; font-size: 2.2rem; margin-bottom: 20px;">Gestion du Parc & Ressources</h2>
            <p style="color: #718096; max-width: 650px; margin: 0 auto 35px; line-height: 1.6;">
                Interface d'administration centralisée pour la surveillance des serveurs, la gestion des utilisateurs et le suivi des réservations d'accès pour vos équipements.
            </p>
            <a href="{{ route('admin.resources.index') }}" class="btn-action-slate">
                Gérer les ressources <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </main>
</div>
@endsection