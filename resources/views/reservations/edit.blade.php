<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Réservation - Data Center</title>
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
                <h1 class="page-title">Modifier la Réservation</h1>
                <div class="page-actions">
                    <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-outline">
                        ← Annuler
                    </a>
                </div>
            </div>

            <!-- Messages Flash -->
            @if(session('success'))
                <div class="alert alert-success">
                    <span class="alert-icon">✓</span>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <span class="alert-icon">✗</span>
                    <div>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Formulaire de modification -->
            <div class="card">
                <div class="card-header">
                    <h2>Modifier la réservation #{{ $reservation->id }}</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('reservations.update', $reservation->id) }}" class="reservation-form">
                        @csrf
                        @method('PUT')
                        
                        <!-- Ressource -->
                        <div class="form-group">
                            <label for="resource_id">Ressource *</label>
                            <select name="resource_id" id="resource_id" class="form-control" required>
                                <option value="">Sélectionner une ressource</option>
                                @foreach($resources as $resource)
                                    <option value="{{ $resource->id }}" 
                                            {{ $reservation->resource_id == $resource->id ? 'selected' : '' }}
                                            data-location="{{ $resource->location ?? '' }}"
                                            data-category="{{ $resource->category->name ?? '' }}">
                                        {{ $resource->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('resource_id')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Détails de la ressource -->
                        <div id="resourceDetails" class="resource-details" style="display: none;">
                            <div class="resource-info-card">
                                <h4>Détails de la ressource</h4>
                                <div id="resourceInfo"></div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="start_date">Date de début *</label>
                                <input type="datetime-local" 
                                       name="start_date" 
                                       id="start_date" 
                                       class="form-control" 
                                       value="{{ \Carbon\Carbon::parse($reservation->start_date)->format('Y-m-d\TH:i') }}"
                                       required>
                                @error('start_date')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="end_date">Date de fin *</label>
                                <input type="datetime-local" 
                                       name="end_date" 
                                       id="end_date" 
                                       class="form-control" 
                                       value="{{ \Carbon\Carbon::parse($reservation->end_date)->format('Y-m-d\TH:i') }}"
                                       required>
                                @error('end_date')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Justification -->
                        <div class="form-group">
                            <label for="justification">Justification *</label>
                            <textarea name="justification" 
                                      id="justification" 
                                      class="form-control" 
                                      rows="4" 
                                      required>{{ old('justification', $reservation->justification) }}</textarea>
                            @error('justification')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                💾 Enregistrer les modifications
                            </button>
                            <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-outline">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/reservations.js') }}"></script>
</body>
</html>
