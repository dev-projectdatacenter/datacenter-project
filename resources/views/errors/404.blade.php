@extends('layouts.guest')

@section('title', 'Page non trouvée')

@push('styles')
<style>
    .error-page-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-color: #f3f4f6;
        font-family: 'Inter', sans-serif, system-ui;
        padding: 1rem;
    }
    .error-card-content {
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        max-width: 550px;
        width: 100%;
        text-align: center;
        padding: 3rem 2.5rem;
        border: 1px solid #e5e7eb;
    }
    .error-code {
        font-size: 6rem;
        font-weight: 800;
        color: #434861;
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    .error-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.75rem;
    }
    .error-message {
        color: #6b7280;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    .error-url {
        font-family: 'Courier New', Courier, monospace;
        background-color: #e5e7eb;
        color: #4b5563;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        word-break: break-all;
        margin-bottom: 2rem;
        display: inline-block;
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
        background-color: #434861;
        color: white;
    }
    .btn-error:hover {
        background-color: #2d3748;
    }
</style>
@endpush

@section('content')
<div class="error-page-container">
    <div class="error-card-content">
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Page non trouvée</h2>
        <p class="error-message">
            Désolé, la page que vous recherchez n'a pas pu être trouvée. Il est possible qu'elle ait été déplacée ou supprimée.
        </p>
        <div class="error-url">
            <strong>URL demandée :</strong> {{ request()->url() }}
        </div>
        <div>
            <a href="{{ url()->previous(route('home')) }}" class="btn-error">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Retour à la page précédente
            </a>
        </div>
    </div>
</div>
@endsection