@extends('layouts.guest')

@section('title', 'Accès Refusé')

@push('styles')
<style>
    :root {
        --primary-color: #434861; /* Bleu Ardoise */
        --primary-darker: #2d3748; /* Gris foncé */
        --text-dark: #1F2937; 
        --text-medium: #4B5563; 
        --text-light: #6B7280; 
        --bg-color: #f3f4f6; /* Gris Perle */
        --card-bg: #FFFFFF;
        --border-color: #E5E7EB; 
    }

    .error-page-container {
        background-color: var(--bg-color);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        font-family: 'Inter', sans-serif, system-ui;
        padding: 1rem;
    }

    .error-card-content {
        background-color: var(--card-bg);
        border-radius: 1rem; 
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        max-width: 550px;
        width: 100%;
        text-align: center;
        padding: 3rem 2.5rem; 
        border: 1px solid var(--border-color);
    }

    .error-code {
        font-size: 6rem; /* 96px */
        font-weight: 800;
        color: var(--primary-color);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .error-title {
        font-size: 1.5rem; /* 24px */
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
    }

    .error-message {
        color: var(--text-medium);
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .error-actions-group {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-bottom: 2.5rem;
    }

    .btn-error {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }

    .btn-primary-error {
        background-color: var(--primary-color);
        color: white;
    }
    .btn-primary-error:hover {
        background-color: var(--primary-darker);
    }

    .btn-secondary-error {
        background-color: transparent;
        color: var(--text-light);
        border: none;
    }
    .btn-secondary-error:hover {
        background-color: #FEF2F2; /* Rouge très clair */
        color: #D90429; /* Rouge plus foncé */
    }

    .error-details-wrapper summary {
        cursor: pointer;
        color: var(--text-light);
        font-weight: 500;
        padding: 0.5rem;
        display: inline-block;
    }
    
    .error-details-wrapper .details-content {
        background-color: var(--bg-color);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-top: 1rem;
        text-align: left;
        font-size: 0.8rem;
        color: var(--text-medium);
        word-break: break-all;
    }

    .error-details-wrapper p {
        margin-bottom: 0.5rem;
    }

</style>
@endpush

@section('content')
<div class="error-page-container">
    <div class="error-card-content">
        <h1 class="error-code">403</h1>
        <h2 class="error-title">Accès Refusé</h2>

        <p class="error-message">
            Vous n'avez pas les permissions nécessaires pour accéder à cette ressource. 
            Si vous pensez qu'il s'agit d'une erreur, veuillez contacter un administrateur.
        </p>

        <div class="error-actions-group">
            @if(auth()->check())
                @if(auth()->user()->role->name === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-error btn-primary-error">Retour au Dashboard</a>
                @elseif(auth()->user()->role->name === 'tech_manager')
                    <a href="{{ route('dashboard.tech') }}" class="btn-error btn-primary-error">Retour au Dashboard</a>
                @else
                    <a href="{{ route('dashboard.user') }}" class="btn-error btn-primary-error">Retour au Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-error btn-secondary-error"><i class="fas fa-sign-out-alt"></i> Se déconnecter</button>
                </form>
            @else
                <a href="{{ route('home') }}" class="btn-error btn-primary-error">Page d'accueil</a>
                <a href="{{ route('login') }}" class="btn-error btn-secondary-error">Se connecter</a>
            @endif
        </div>

        <details class="error-details-wrapper">
            <summary>Détails techniques</summary>
            <div class="details-content">
                <p><strong>Code:</strong> 403 Forbidden</p>
                <p><strong>URL:</strong> {{ request()->fullUrl() }}</p>
                <p><strong>Méthode:</strong> {{ request()->method() }}</p>
                @if(auth()->check())
                    <p><strong>Utilisateur:</strong> {{ auth()->user()->name }} (ID: {{ auth()->user()->id }})</p>
                    <p><strong>Rôle:</strong> {{ auth()->user()->role->name ?? 'N/A' }}</p>
                @endif
            </div>
        </details>
    </div>
</div>
@endsection
