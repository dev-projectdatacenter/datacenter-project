@extends('layouts.guest')

@section('content')
    <div class="error-page">
        <div class="error-icon text-warning">
            <i class="fas fa-search"></i>
        </div>
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Page Introuvable</h2>
        <p class="error-description">
            Oups ! La page que vous recherchez semble avoir disparu ou n'existe pas.
        </p>
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
        </div>
    </div>
@endsection