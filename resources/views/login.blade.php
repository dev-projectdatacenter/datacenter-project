<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - DataCenter</title>
    
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
</head>
<body class="guest-layout">

    <div style="margin-bottom: 2rem; text-align: center;">
        <span style="font-size: 3rem;">🔌</span>
    </div>

    <div class="guest-card">
        <h2 style="text-align: center; margin-bottom: 2rem; color: var(--text-main);">Connexion</h2>

        <form action="" method="POST">
            <div class="form-group">
                <label class="form-label">Adresse Email</label>
                <input type="email" class="form-control" name="email" placeholder="exemple@datacenter.com" required>
            </div>

            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <input type="password" class="form-control" name="password" placeholder="••••••••" required>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); cursor: pointer;">
                    <input type="checkbox"> Se souvenir de moi
                </label>
                <a href="#" style="color: var(--primary); text-decoration: none; font-size: 0.9rem;">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Se connecter
            </button>
        </form>
    </div>

    <p style="margin-top: 2rem; color: var(--text-muted); font-size: 0.9rem;">
        © 2024 DataCenter Manager
    </p>

</body>
</html>