@extends('layouts.admin')

@section('title', 'Paramètres du système')

@section('content')
<div class="settings-container">
    <h1>Configuration du système</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <form action="{{ route('admin.settings.update') }}" method="POST" class="settings-form">
        @csrf
        @method('PUT')
        
        <div class="settings-section">
            <h2>Informations générales</h2>
            <div class="form-group">
                <label for="site_name">Nom du site</label>
                <input type="text" id="site_name" name="site_name" 
                       value="{{ old('site_name', $settings['site_name'] ?? '') }}" required>
            </div>
            
            <div class="form-group">
                <label for="contact_email">Email de contact</label>
                <input type="email" id="contact_email" name="contact_email" 
                       value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" required>
            </div>
            
            <div class="form-group">
                <label for="timezone">Fuseau horaire</label>
                <select id="timezone" name="timezone" required>
                    @foreach(timezone_identifiers_list() as $timezone)
                        <option value="{{ $timezone }}" 
                            {{ (old('timezone', $settings['timezone'] ?? 'UTC') === $timezone) ? 'selected' : '' }}>
                            {{ $timezone }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="settings-section">
            <h2>Paramètres de réservation</h2>
            <div class="form-group">
                <label for="max_booking_days">Durée maximale de réservation (jours)</label>
                <input type="number" id="max_booking_days" name="max_booking_days" 
                       value="{{ old('max_booking_days', $settings['max_booking_days'] ?? '7') }}" 
                       min="1" required>
            </div>
            
            <div class="form-group">
                <label for="min_booking_notice">Préavis minimum (heures)</label>
                <input type="number" id="min_booking_notice" name="min_booking_notice" 
                       value="{{ old('min_booking_notice', $settings['min_booking_notice'] ?? '24') }}" 
                       min="1" required>
            </div>
            
            <div class="form-group">
                <label for="max_concurrent_bookings">Réservations simultanées max par utilisateur</label>
                <input type="number" id="max_concurrent_bookings" name="max_concurrent_bookings" 
                       value="{{ old('max_concurrent_bookings', $settings['max_concurrent_bookings'] ?? '3') }}" 
                       min="1" required>
            </div>
        </div>
        
        <div class="settings-section">
            <h2>Maintenance</h2>
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="hidden" name="maintenance_mode" value="0">
                    <input type="checkbox" name="maintenance_mode" value="1" 
                           {{ (old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '') }}>
                    Activer le mode maintenance
                </label>
                <p class="hint">En mode maintenance, seuls les administrateurs pourront accéder au site.</p>
            </div>
            
            <div class="form-group">
                <label for="maintenance_message">Message de maintenance</label>
                <textarea id="maintenance_message" name="maintenance_message" rows="3">{{ old('maintenance_message', $settings['maintenance_message'] ?? '') }}</textarea>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" style="border-radius: 10px;" class="btn btn-primary">Enregistrer les modifications</button>
        </div>
    </form>
</div>

<style>
.settings-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.settings-section {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
}

.settings-section h2 {
    color: #2c3e50;
    margin-top: 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #2c3e50;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="number"],
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: 16px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: auto;
    margin: 0;
}

.hint {
    font-size: 14px;
    color: #7f8c8d;
    margin: 5px 0 0 25px;
}

.form-actions {
    text-align: right;
    margin-top: 30px;
}

.btn {
    padding: 10px 20px;
    background: #424665;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.btn:hover {
    background: #424665;
}

textarea {
    min-height: 100px;
    resize: vertical;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
</style>
@endsection
