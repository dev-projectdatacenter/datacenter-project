@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-slate: #434861;
        --bg-main: #f3f4f6;
        --accent-orange: #d17c31ff;
        --white: #ffffff;
        --text-dark: #2d3748;
        --text-gray: #718096;
        --error-red: #e74c3c;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .incident-container {
        padding: 40px 20px;
        max-width: 800px;
        margin: 0 auto;
    }

    /* --- HEADER --- */
    .incident-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .incident-header h1 {
        font-size: 1.8rem;
        color: var(--primary-slate);
        font-weight: 700;
        margin-bottom: 10px;
    }

    .resource-badge {
        display: inline-block;
        background: #edf2f7;
        color: var(--primary-slate);
        padding: 6px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* --- CARD & FORM --- */
    .incident-card {
        background: var(--white);
        padding: 40px;
        border-radius: 15px;
        box-shadow: var(--shadow);
        border: 1px solid #edf2f7;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent-orange);
        box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    /* --- ALERTS --- */
    .alert-error {
        background: #fff5f5;
        border-left: 4px solid var(--error-red);
        color: #c53030;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .info-note {
        background: #fffbeb;
        border-radius: 10px;
        padding: 15px;
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 30px;
        border: 1px solid #fef3c7;
    }

    .info-note i {
        color: #d97706;
        font-size: 1.2rem;
    }

    .info-note p {
        margin: 0;
        font-size: 0.85rem;
        color: #92400e;
        line-height: 1.4;
    }

    /* --- BUTTONS --- */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
        margin-top: 30px;
    }

    .btn-cancel {
        color: var(--text-gray);
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-cancel:hover {
        color: var(--text-dark);
    }

    .btn-submit {
        background: var(--accent-orange);
        color: white;
        padding: 14px 30px;
        border-radius: 10px;
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-submit:hover {
        background: #d35400;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(230, 126, 34, 0.3);
    }
</style>

<div class="incident-container">
    <div class="incident-header">
        <h1><i class="fas fa-exclamation-circle"></i> Signaler un incident</h1>
        @if($resource)
            <div class="resource-badge">
                <i class="fas fa-server"></i> {{ $resource->name }} 
                <span style="opacity: 0.7; font-weight: 400; margin-left: 5px;">({{ $resource->category->name ?? 'N/A' }})</span>
            </div>
        @else
            <p style="color: var(--text-gray);">Identifiez l'équipement ou le service en panne.</p>
        @endif
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="incident-card">
        <form action="{{ route('incidents.store') }}" method="POST">
            @csrf
            
            @if($resource)
                <input type="hidden" name="resource_id" value="{{ $resource->id }}">
            @else
                <div class="form-group">
                    <label class="form-label">Ressource concernée</label>
                    <select name="resource_id" required class="form-control">
                        <option value="">-- Sélectionner l'équipement --</option>
                        @foreach($resources as $res)
                            <option value="{{ $res->id }}" {{ old('resource_id') == $res->id ? 'selected' : '' }}>
                                {{ $res->name }} ({{ $res->category->name ?? 'Sans catégorie' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="form-group">
                <label class="form-label">Niveau de gravité</label>
                <select name="severity" required class="form-control">
                    <option value="">-- Évaluer l'impact --</option>
                    <option value="low" {{ old('severity') == 'low' ? 'selected' : '' }}>🟢 Faible (Usage non bloqué)</option>
                    <option value="medium" {{ old('severity') == 'medium' ? 'selected' : '' }}>🟡 Moyenne (Usage perturbé)</option>
                    <option value="high" {{ old('severity') == 'high' ? 'selected' : '' }}>🟠 Élevée (Service critique dégradé)</option>
                    <option value="critical" {{ old('severity') == 'critical' ? 'selected' : '' }}>🔴 Critique (Arrêt total du service)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Description précise</label>
                <textarea name="description" rows="5" required 
                    placeholder="Quels sont les symptômes ? (ex: Code erreur 502, plus de réseau sur la baie 4...)" 
                    class="form-control">{{ old('description') }}</textarea>
                <div style="display: flex; justify-content: space-between; margin-top: 8px;">
                    <small style="color: var(--text-gray);">Soyez le plus factuel possible.</small>
                    <small style="color: var(--text-gray);">Min. 10 caractères</small>
                </div>
            </div>

            <div class="info-note">
                <i class="fas fa-bolt"></i>
                <p>
                    <strong>Alerte automatique :</strong> Ce rapport sera notifié aux techniciens d'astreinte. 
                    Si la situation l'exige, la ressource sera verrouillée en mode <strong>Maintenance</strong>.
                </p>
            </div>

            <div class="form-actions">
                <a href="{{ $resource ? route('resources.show', $resource) : route('incidents.index') }}" class="btn-cancel">
                    Annuler
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Envoyer le rapport
                </button>
            </div>
        </form>
    </div>
</div>
@endsection