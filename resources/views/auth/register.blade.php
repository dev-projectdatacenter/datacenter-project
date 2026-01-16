<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Data Center</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .register-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }
        input, select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            width: 100%;
            padding: 0.75rem;
            background: #48bb78;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #38a169;
        }
        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-link {
            text-align: center;
            margin-top: 1rem;
        }
        .back-link a {
            color: #667eea;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .info-box {
            background: #e6fffa;
            border: 1px solid #81e6d9;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
        }
        .info-box h4 {
            color: #234e52;
            margin-bottom: 0.5rem;
        }
        .info-box p {
            color: #2c7a7b;
            font-size: 0.9rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <h2>📝 Demande de Compte Data Center</h2>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        
        <div class="info-box">
            <h4>🌟 Pourquoi rejoindre notre Data Center ?</h4>
            <p>
                Notre plateforme de gestion de Data Center vous permet de réserver des ressources 
                informatiques (serveurs, VMs, équipements réseau) pour vos projets professionnels. 
                Accédez à des infrastructures modernes, suivez vos utilisations et bénéficiez 
                d'un support technique dédié.
            </p>
        </div>
        
        <form method="POST" action="/register">
            @csrf
            
            <div class="form-group">
                <label for="name">Nom complet *</label>
                <input type="text" id="name" name="name" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="email">Email professionnel *</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Téléphone professionnel</label>
                <input type="tel" id="phone" name="phone" placeholder="06XXXXXXXX">
            </div>
            
            <div class="form-group">
                <label for="department">Département/Service *</label>
                <select id="department" name="department" required>
                    <option value="">-- Sélectionnez votre département --</option>
                    <option value="informatique">Direction Informatique</option>
                    <option value="recherche">Centre de Recherche</option>
                    <option value="enseignement">Département Enseignement</option>
                    <option value="administration">Services Administratifs</option>
                    <option value="technique">Services Techniques</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="role_requested">Type de compte souhaité *</label>
                <select id="role_requested" name="role_requested" required>
                    <option value="">-- Sélectionnez le type de compte --</option>
                    <option value="user">Utilisateur interne (Ingénieur/Enseignant/Doctorant)</option>
                    <option value="tech_manager">Responsable technique de ressources</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="motivation">Motivation de la demande *</label>
                <input type="text" id="motivation" name="motivation" required placeholder="Décrivez brièvement pourquoi vous avez besoin d'un accès...">
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe *</label>
                <input type="password" id="password" name="password" required minlength="8">
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            
            <button type="submit" class="btn">Envoyer la demande d'inscription</button>
        </form>
        
        <div class="back-link">
            <p>Déjà un compte ? <a href="/login">Se connecter</a></p>
            <p><a href="/">← Retour à l'accueil</a></p>
        </div>
    </div>
</body>
</html>