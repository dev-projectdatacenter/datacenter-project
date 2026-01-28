@extends('layouts.guest')

@section('content')
    <div class="error-page">
        <div class="error-icon text-danger">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h1 class="error-code">500</h1>
        <h2 class="error-message">Erreur Serveur</h2>
        <p class="error-description">
            Une erreur interne s'est produite. Nos équipes techniques ont été notifiées.
        </p>
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
        </div>
    </div>
@endsection