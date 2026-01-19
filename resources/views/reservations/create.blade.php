<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Réservation - Data Center</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reservations.css') }}">
</head>
<body>
    <div class="app-container">
        <!-- Navigation -->
        @include('components.navigation')
        
        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">Nouvelle demande de réservation</h1>
                <div class="page-actions">
                    <a href="{{ route('reservations.index') }}" class="btn btn-outline">
                        ← Retour à mes réservations
                    </a>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="card">
                <div class="card-header">
                    <h2>Remplir le formulaire de demande</h2>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-error">
                            <span class="alert-icon">⚠️</span>
                            <div>
                                <strong>Erreurs de validation :</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-error">
                            <span class="alert-icon">✗</span>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('reservations.store') }}" method="POST" class="reservation-form" id="reservationForm">
                        @csrf
                        
                        <!-- Étape 1: Choix de la ressource -->
                        <div class="form-step" id="step1">
                            <h3>Étape 1: Choisir une ressource</h3>
                            
                            <div class="form-group">
                                <label for="resource_id" class="form-label required">
                                    Ressource souhaitée :
                                </label>
                                <select name="resource_id" id="resource_id" class="form-control" required>
                                    <option value="">-- Sélectionner une ressource --</option>
                                    @foreach($resources as $resource)
                                        <option value="{{ $resource->id }}" 
                                                data-location="{{ $resource->location ?? '' }}"
                                                data-category="{{ $resource->category->name ?? '' }}"
                                                data-status="{{ $resource->status }}"
                                                {{ old('resource_id') == $resource->id ? 'selected' : '' }}>
                                            {{ $resource->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-help">
                                    Choisissez la ressource que vous souhaitez réserver
                                </div>
                            </div>

                            <!-- Détails de la ressource sélectionnée -->
                            <div id="resourceDetails" class="resource-details" style="display: none;">
                                <div class="resource-info-card">
                                    <h4>Informations sur la ressource</h4>
                                    <div id="resourceInfo"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 2: Dates -->
                        <div class="form-step" id="step2">
                            <h3>Étape 2: Dates de réservation</h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="start_date" class="form-label required">
                                        Date et heure de début :
                                    </label>
                                    <input type="datetime-local" name="start_date" id="start_date" 
                                           class="form-control" value="{{ old('start_date') }}" required>
                                    <div class="form-help">
                                        La réservation doit commencer dans le futur
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="end_date" class="form-label required">
                                        Date et heure de fin :
                                    </label>
                                    <input type="datetime-local" name="end_date" id="end_date" 
                                           class="form-control" value="{{ old('end_date') }}" required>
                                    <div class="form-help">
                                        La fin doit être après le début
                                    </div>
                                </div>
                            </div>

                            <!-- Vérification de disponibilité -->
                            <div class="availability-check">
                                <button type="button" id="checkAvailability" class="btn btn-secondary">
                                    🔄 Vérifier la disponibilité
                                </button>
                                <div id="availabilityResult" class="availability-result"></div>
                            </div>
                        </div>

                        <!-- Étape 3: Justification -->
                        <div class="form-step" id="step3">
                            <h3>Étape 3: Justification de la demande</h3>
                            
                            <div class="form-group">
                                <label for="justification" class="form-label required">
                                    Justification de la demande :
                                </label>
                                <textarea name="justification" id="justification" rows="6" 
                                          class="form-control" 
                                          placeholder="Décrivez votre projet ou la raison pour laquelle vous avez besoin de cette ressource..."
                                          required>{{ old('justification') }}</textarea>
                                <div class="form-help">
                                    Expliquez brièvement l'usage prévu (Projet PFE, TP Réseaux, Recherche, etc.)
                                </div>
                                <div class="char-counter">
                                    <span id="charCount">0</span> / 1000 caractères
                                </div>
                            </div>

                            <!-- Suggestions de justifications -->
                            <div class="justification-suggestions">
                                <h4>Exemples de justifications :</h4>
                                <div class="suggestion-buttons">
                                    <button type="button" class="suggestion-btn" data-text="Projet PFE - Tests de performance sur serveur dédié">
                                        🎓 Projet PFE
                                    </button>
                                    <button type="button" class="suggestion-btn" data-text="TP Réseaux - Configuration et tests de connectivité">
                                        📚 TP Réseaux
                                    </button>
                                    <button type="button" class="suggestion-btn" data-text="Recherche - Expériences sur machines virtuelles">
                                        🔬 Recherche
                                    </button>
                                    <button type="button" class="suggestion-btn" data-text="Développement - Tests d'application sur environnement de staging">
                                        💻 Développement
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation entre étapes -->
                        <div class="form-navigation">
                            <button type="button" id="prevStep" class="btn btn-outline" style="display: none;">
                                ← Précédent
                            </button>
                            <button type="button" id="nextStep" class="btn btn-primary">
                                Suivant →
                            </button>
                            <button type="submit" id="submitForm" class="btn btn-success" style="display: none;">
                                📤 Soumettre la demande
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Aide -->
            <div class="help-section">
                <div class="card">
                    <div class="card-header">
                        <h3>💡 Aide</h3>
                    </div>
                    <div class="card-body">
                        <div class="help-item">
                            <h4>⏱️ Délais de traitement</h4>
                            <p>Les demandes sont généralement traitées dans les 24-48h par les gestionnaires de ressources.</p>
                        </div>
                        <div class="help-item">
                            <h4>📋 Conditions d'approbation</h4>
                            <p>Votre demande doit être justifiée et les dates ne doivent pas entrer en conflit avec d'autres réservations.</p>
                        </div>
                        <div class="help-item">
                            <h4>🔔 Notifications</h4>
                            <p>Vous recevrez une notification par email et dans votre espace personnel dès qu'une décision sera prise.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/reservations.js') }}"></script>
</body>
</html>