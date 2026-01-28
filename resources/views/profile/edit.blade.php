<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres du profil - DataCenter</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-slate: #434861;   /* Ton bleu-gris signature */
            --sidebar-bg: #d1d5db;      /* Ton gris sidebar signature */
            --sidebar-hover: #c4c9d4;
            --bg-main: #f3f4f6;
            --white: #ffffff;
            --success: #10b981;
            --danger: #ef4444;
            --text-dark: #2d3748;
            --text-gray: #718096;
            --light-gray: #e2e8f0;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        * {
            margin: 0; padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: var(--bg-main);
            color: var(--text-dark);
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* --- SIDEBAR STYLE SIGNATURE --- */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-right: 1px solid rgba(0,0,0,0.05);
            padding: 2rem 0;
            position: fixed;
            height: 100%;
            z-index: 100;
        }
        
        .logo {
            padding: 0 25px 40px;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary-slate);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .nav-menu { list-style: none; padding: 0 10px; }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: var(--text-gray);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            margin-bottom: 5px;
            transition: 0.2s;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: var(--sidebar-hover);
            color: var(--primary-slate) !important;
        }

        .nav-link i { width: 20px; text-align: center; }
        
        /* --- MAIN CONTENT --- */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px 40px;
        }
        
        /* --- HEADER CARD --- */
        .header-card {
            background: var(--white);
            padding: 20px 30px;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }
        
        .header-info h1 { font-size: 1.4rem; color: var(--text-dark); margin: 0; }
        .header-info p { color: var(--text-gray); font-size: 0.9rem; margin-top: 5px; }

        .user-profile { display: flex; align-items: center; gap: 12px; }
        .avatar-circle {
            width: 40px; height: 40px;
            background: var(--primary-slate);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold;
        }
        
        /* --- FORM CONTAINER --- */
        .profile-card {
            background: var(--white);
            border-radius: 15px;
            padding: 35px;
            box-shadow: var(--shadow);
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-slate);
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--bg-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .form-group { display: flex; flex-direction: column; }
        
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 0.85rem;
        }
        
        .form-input {
            padding: 12px 15px;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            font-size: 0.9rem;
            background: #fcfcfc;
            transition: 0.3s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary-slate);
            background: white;
            box-shadow: 0 0 0 3px rgba(67, 72, 97, 0.1);
        }

        .form-help { color: var(--text-gray); font-size: 0.75rem; margin-top: 5px; }
        
        /* --- BUTTONS --- */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            padding-top: 25px;
            border-top: 1px solid var(--bg-main);
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.3s;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .btn-primary { background: var(--primary-slate); color: white; }
        .btn-primary:hover { background: #33384d; transform: translateY(-1px); }
        
        .btn-outline { background: #f8fafc; color: var(--text-gray); border: 1px solid var(--light-gray); }
        .btn-outline:hover { background: #edf2f7; }

        /* --- ALERTS --- */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }
        .alert-success { background: #ecfdf5; color: var(--success); border: 1px solid #d1fae5; }
        .alert-danger { background: #fef2f2; color: var(--danger); border: 1px solid #fee2e2; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">
                <i class="fas fa-server"></i>
                <span>DataCenter</span>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.user') }}" class="nav-link">
                            <i class="fas fa-home"></i> <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reservations.index') }}" class="nav-link">
                            <i class="fas fa-calendar-alt"></i> <span>Mes réservations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('notifications.index') }}" class="nav-link">
                            <i class="fas fa-bell"></i> <span>Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link active">
                            <i class="fas fa-user-cog"></i> <span>Paramètres</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header-card">
                <div class="header-info">
                    <h1>Paramètres du profil</h1>
                    <p>Mettez à jour vos informations et sécurisez votre compte</p>
                </div>
                <div class="user-profile">
                    <div class="avatar-circle">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span style="font-weight: 600;">{{ auth()->user()->name }}</span>
                </div>
            </header>

            <div class="profile-card">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            @foreach($errors->all() as $error) <div>{{ $error }}</div> @endforeach
                        </div>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h2 class="section-title"><i class="fas fa-id-card"></i> Informations personnelles</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nom complet *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Adresse email *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                        </div>
                    </div>

                    <h2 class="section-title"><i class="fas fa-shield-alt"></i> Sécurité</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="form-input" placeholder="••••••••">
                            <p class="form-help">Requis pour changer le mot de passe</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="new_password" class="form-input" placeholder="••••••••">
                            <p class="form-help">8 caractères minimum</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="new_password_confirmation" class="form-input" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('dashboard.user') }}" class="btn btn-outline">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>