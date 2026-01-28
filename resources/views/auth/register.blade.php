@extends('layouts.app')

@section('style')
<style>
  /* Header / Topbar */
.topbar {
    background: #0f1e3f !important; /* Bleu Nuit de ta palette */
    border-bottom: 2px solid #997953 !important; /* Liseré Doré */
    color: #ffffff !important;
    padding: 15px 30px !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2) !important;
}

/* Logo ou Texte dans le header */
.topbar .logo, .topbar h1 {
    color: #cdaa80 !important; /* Doré clair */
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Liens de navigation du header */
.topbar a {
    color: #e2d1b9 !important; /* Crème de ta palette */
    transition: color 0.3s ease;
    font-weight: 500;
}

.topbar a:hover {
    color: #997953 !important; /* Changement vers le Doré au survol */
}
/* Footer */
.app-footer {
    background-color: #213a56 !important; /* Bleu Delft */
    border-top: 1px solid #cdaa80 !important; /* Bordure Dorée fine */
    color: #e2d1b9 !important; /* Texte clair pour la lisibilité */
    padding: 25px !important;
    text-align: center;
    font-size: 0.9rem;
}

/* Liens dans le footer */
.app-footer a {
    color: #997953 !important; /* Doré Ocre */
    text-decoration: none;
    font-weight: 600;
}

.app-footer a:hover {
    color: #ffffff !important;
    text-decoration: underline;
}

/* Copyright ou texte secondaire */
.app-footer .muted-text {
    color: rgba(226, 209, 185, 0.6) !important;
}
</style>

@endsection
@section('content')
    {{-- Le conteneur utilise maintenant une ombre douce et une bordure aux teintes de la palette --}}
    <div
        style="max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #e2d1b9; border-radius: 8px; background: white; box-shadow: 0 4px 6px rgba(15, 30, 63, 0.05);">
        
        {{-- Titre en Delft Blue --}}
        <h2 style="text-align: center; margin-bottom: 30px; color: #213a56;">Inscription</h2>

        @if ($errors->any())
            {{-- Alerte d'erreur stylisée avec le rouge de la palette --}}
            <div style="background: #fee2e2; color: #742a2a; padding: 10px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #feb2b2;">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold; color: #213a56;">Nom complet</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold; color: #213a56;">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="phone" style="display: block; margin-bottom: 5px; font-weight: bold; color: #213a56;">Téléphone
                    (optionnel)</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                    style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="department" style="display: block; margin-bottom: 5px; font-weight: bold; color: #213a56;">Département</label>
                <input type="text" id="department" name="department" value="{{ old('department') }}" required
                    style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="role_requested" style="display: block; margin-bottom: 5px; font-weight: bold; color: #213a56;">Rôle
                    demandé</label>
                <select id="role_requested" name="role_requested" required
                    style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px; background: white;">
                    <option value="">Sélectionner un rôle</option>
                    <option value="user">Utilisateur</option>
                    <option value="tech_manager">Responsable technique</option>
                    <option value="admin">Administrateur</option>
                    <option value="invite">Invité</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="motivation" style="display: block; margin-bottom: 5px; font-weight: bold; color: #213a56;">Motivation</label>
                <textarea id="motivation" name="motivation" rows="3" required
                    style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px;">{{ old('motivation') }}</textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold; color: #213a56;">Mot de passe</label>
                <input type="password" id="password" name="password" required minlength="8"
                    style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="password_confirmation" style="display: block; margin-bottom: 5px; font-weight: bold; color: #213a56;">Confirmer
                    le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8"
                    style="width: 100%; padding: 10px; border: 1px solid #e2d1b9; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 20px;">
                {{-- Bouton principal en Bleu Nuit (#0f1e3f) --}}
                <button type="submit"
                    style="width: 100%; padding: 12px; background: #424665;; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: bold;">
                    S'inscrire
                </button>
            </div>

            <div style="text-align: center;">
                {{-- Lien en Doré Ocre (#997953) --}}
                <p style="color: #64748b;">Déjà un compte? <a href="{{ route('login') }}" style="color: #997953; font-weight: bold; text-decoration: none;">Se connecter</a></p>
            </div>
        </form>
    </div>
@endsection