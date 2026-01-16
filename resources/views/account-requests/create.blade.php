@extends('layouts.guest')

@section('title', 'Demande de compte')

@section('content')
<div class="request-container">
    <div class="request-card">
        <div class="request-header">
            <h1>📋 Demande de compte</h1>
            <p>Remplissez ce formulaire pour demander un accès au système de gestion du Data Center</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                ❌ {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('account.request.store') }}" class="request-form">
            @csrf
            
            <div class="form-section">
                <h3>👤 Informations personnelles</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nom complet *</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               placeholder="Jean Dupont">
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email professionnel *</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               placeholder="jean.dupont@entreprise.com">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               placeholder="+212600000000">
                        @error('phone')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>🎯 Demande d'accès</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="role_requested">Type de compte demandé *</label>
                        <select id="role_requested" name="role_requested" required>
                            <option value="">-- Sélectionnez le type de compte --</option>
                            <option value="user" {{ old('role_requested') == 'user' ? 'selected' : '' }}>
                                👤 Utilisateur interne (Ingénieur/Enseignant/Doctorant)
                            </option>
                            <option value="tech_manager" {{ old('role_requested') == 'tech_manager' ? 'selected' : '' }}>
                                🔧 Responsable technique de ressources
                            </option>
                            <option value="admin" {{ old('role_requested') == 'admin' ? 'selected' : '' }}>
                                👑 Administrateur du système
                            </option>
                        </select>
                        @error('role_requested')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    📤 Envoyer la demande
                </button>
            </div>
        </form>

        <div class="request-info">
            <div class="info-card">
                <h4>ℹ️ Informations importantes</h4>
                <ul>
                    <li>Les demandes sont traitées par les administrateurs</li>
                    <li>Vous recevrez une réponse par email dans les 24-48h</li>
                    <li>Les comptes administrateurs nécessitent une justification</li>
                    <li>En cas d'approbation, vous recevrez vos identifiants par email</li>
                </ul>
            </div>
        </div>

        <div class="request-links">
            <a href="{{ route('login') }}" class="link-back">
                🔙 Retour à la connexion
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.request-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.request-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    padding: 40px;
    max-width: 600px;
    width: 100%;
}

.request-header {
    text-align: center;
    margin-bottom: 30px;
}

.request-header h1 {
    color: #2d3748;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 10px;
}

.request-header p {
    color: #718096;
    font-size: 16px;
    margin: 0;
}

.request-form {
    margin-bottom: 30px;
}

.form-section {
    margin-bottom: 30px;
}

.form-section h3 {
    color: #4a5568;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e2e8f0;
}

.form-row {
    margin-bottom: 20px;
}

.form-group {
    width: 100%;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #4a5568;
    font-size: 14px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background-color: white;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-actions {
    text-align: center;
    margin-top: 30px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 15px 40px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.request-info {
    margin-bottom: 20px;
}

.info-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
}

.info-card h4 {
    color: #2b6cb0;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
}

.info-card ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-card li {
    color: #4a5568;
    font-size: 14px;
    margin-bottom: 8px;
    padding-left: 20px;
    position: relative;
}

.info-card li:before {
    content: "•";
    position: absolute;
    left: 0;
    color: #667eea;
    font-weight: bold;
}

.request-links {
    text-align: center;
}

.link-back {
    color: #667eea;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    padding: 10px 20px;
    border: 1px solid #667eea;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.link-back:hover {
    background: #667eea;
    color: white;
}

.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-success {
    background-color: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.alert-danger {
    background-color: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.error {
    display: block;
    margin-top: 6px;
    color: #e53e3e;
    font-size: 12px;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .request-container {
        padding: 20px 15px;
    }
    
    .request-card {
        padding: 30px 20px;
    }
    
    .request-header h1 {
        font-size: 28px;
    }
}
</style>
@endpush
