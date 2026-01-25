@extends('layouts.guest')

@section('content')
    <div class="error-page">
        <div class="error-icon text-danger">
            <i class="fas fa-ban"></i>
        </div>
        <h1 class="error-code">403</h1>
        <h2 class="error-message">Accès Refusé</h2>
        <p class="error-description">
            Désolé, vous n'avez pas la permission d'accéder à cette page.
        </p>
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
        </div>
    </div>
@endsection