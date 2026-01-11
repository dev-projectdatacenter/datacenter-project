<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'accès - DataCenter Manager</title>
    
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="guest-layout">

    <div style="text-align: center; margin-bottom: var(--space-md);">
        <i class="fas fa-plug" style="font-size: 3rem; color: #4C5760;"></i>
    </div>

    <div class="guest-card">
        <div class="card-header" style="text-align: center; border-bottom: none; padding-bottom: 0;">
            <h2 style="color: var(--text-main); margin: 0;">Demande d'accès</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem; font-weight: normal;">
                Remplissez ce formulaire pour solliciter un compte auprès de l'administrateur.
            </p>
        </div>

        <form action="{{ route('account.request.submit') }}" method="POST" style="margin-top: 1.5rem;">
            @csrf
            
            <div class="grid grid-2" style="gap: 1rem; margin-bottom: 1rem; grid-template-columns: 1fr 1fr;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="lastname" class="form-label">Nom</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" required placeholder="Votre nom">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="firstname" class="form-label">Prénom</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" required placeholder="Votre prénom">
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Adresse Email Professionnelle</label>
                <input type="email" id="email" name="email" class="form-control" required placeholder="nom@datacenter.com">
            </div>

            <div class="form-group">
                <label for="service" class="form-label">Service / Département</label>
                <select id="service" name="service" class="form-control" style="cursor: pointer;">
                    <option value="" disabled selected>Sélectionnez votre service...</option>
                    <option value="it">IT / Réseau</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="direction">Direction</option>
                    <option value="stagiaire">Stagiaire</option>
                    <option value="autre">Autre</option>
                </select>
            </div>

            <div class="form-group">
                <label for="reason" class="form-label">Motif de la demande</label>
                <textarea id="reason" name="reason" class="form-control" rows="3" placeholder="Ex: Besoin d'accès pour la maintenance du serveur B2..." style="resize: vertical; min-height: 80px; font-family: inherit;"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="margin-top: 0.5rem;">
                Envoyer la demande
            </button>
            
            <div style="text-align: center; margin-top: 1.5rem;">
                <a href="{{ route('login') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">
                    <i class="fas fa-arrow-left"></i> Retour à la connexion
                </a>
            </div>
        </form>
    </div>

    <footer style="margin-top: var(--space-md); color: var(--text-muted); font-size: 0.85rem;">
        &copy; 2024 DataCenter Manager
    </footer>

</body>
</html>