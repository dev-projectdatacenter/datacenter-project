@extends('layouts.admin')

@section('title', 'Configuration Système')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Configuration Système</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
            ← Retour au dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-card">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="settings-form">
            @csrf
            @method('PUT')
            
            <div class="settings-grid">
                <div class="settings-section">
                    <h3>Informations générales</h3>
                    <div class="form-group">
                        <label for="app_name">Nom de l'application</label>
                        <input type="text" id="app_name" name="app_name" 
                               value="{{ $settings['app_name'] }}" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label>Environnement</label>
                        <input type="text" value="{{ $settings['app_env'] }}" readonly class="form-input readonly">
                    </div>
                    
                    <div class="form-group">
                        <label>Fuseau horaire</label>
                        <input type="text" name="app_timezone" 
                               value="{{ $settings['app_timezone'] }}" class="form-input">
                    </div>
                </div>

                <div class="settings-section">
                    <h3>Configuration technique</h3>
                    <div class="form-group">
                        <label>Base de données</label>
                        <input type="text" value="{{ $settings['database_connection'] }}" readonly class="form-input readonly">
                    </div>
                    
                    <div class="form-group">
                        <label>Driver email</label>
                        <input type="text" value="{{ $settings['mail_driver'] }}" readonly class="form-input readonly">
                    </div>
                    
                    <div class="form-group">
                        <label>Queue</label>
                        <input type="text" value="{{ $settings['queue_connection'] }}" readonly class="form-input readonly">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
}

.settings-section {
    background: #f8fafc;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.settings-section h3 {
    color: #2d3748;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e2e8f0;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #4a5568;
}

.form-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
}

.form-input.readonly {
    background: #f1f5f9;
    color: #64748b;
    cursor: not-allowed;
}

.form-actions {
    display: flex;
    gap: 15px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    border-left: 4px solid #28a745;
}
</style>
@endpush
@endsection
