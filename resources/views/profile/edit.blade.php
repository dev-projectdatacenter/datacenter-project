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
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --secondary: #3f37c9;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
            --light-gray: #e2e8f0;
            --border-radius: 8px;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        
        body {
            background-color: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            padding: 1.5rem 0;
            position: fixed;
            height: 100%;
            overflow-y: auto;
            transition: var(--transition);
            z-index: 100;
        }
        
        .logo {
            text-align: center;
            padding: 20px 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            border-bottom: 1px solid var(--light-gray);
            margin-bottom: 20px;
        }
        
        .nav-menu {
            list-style: none;
            padding: 0 15px;
        }
        
        .nav-item {
            margin-bottom: 5px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--gray);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(108, 117, 125, 0.1);
            color: var(--primary);
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2rem;
        }
        
        /* Header */
        .header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-title h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }
        
        .header-subtitle {
            color: var(--gray);
            font-size: 0.875rem;
        }
        
        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .notification-icon {
            position: relative;
            cursor: pointer;
            color: var(--gray);
            transition: var(--transition);
        }
        
        .notification-icon:hover {
            color: var(--primary);
        }
        
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--light);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .user-menu:hover {
            background: var(--light-gray);
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        /* Profile Form */
        .profile-container {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            max-width: 800px;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--light-gray);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        .form-label .required {
            color: var(--danger);
            margin-left: 2px;
        }
        
        .form-input {
            padding: 0.75rem 1rem;
            border: 1px solid var(--light-gray);
            border-radius: 6px;
            font-size: 0.875rem;
            transition: var(--transition);
            background: white;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .form-input.error {
            border-color: var(--danger);
        }
        
        .form-error {
            color: var(--danger);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .form-help {
            color: var(--gray);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 1.5rem;
            border-top: 1px solid var(--light-gray);
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }
        
        .btn-outline {
            background: white;
            color: var(--gray);
            border: 1px solid var(--light-gray);
        }
        
        .btn-outline:hover {
            background: var(--light);
            border-color: var(--gray);
        }
        
        /* Alert */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <span>DataCenter</span>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('dashboard.user') }}" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reservations.index') }}" class="nav-link">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Mes réservations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('notifications.index') }}" class="nav-link">
                            <i class="fas fa-bell"></i>
                            <span>Notifications</span>
                            @php
                                $unreadCount = auth()->user()->unreadNotificationsCount();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="notification-badge">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link active">
                            <i class="fas fa-cog"></i>
                            <span>Paramètres</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-title">
                    <h1>Paramètres du profil</h1>
                    <p class="header-subtitle">Gérez vos informations personnelles et votre mot de passe</p>
                </div>
                <div class="header-actions">
                    <div class="notification-icon" onclick="window.location.href='{{ route('notifications.index') }}'">
                        <i class="fas fa-bell"></i>
                        @php
                            $unreadCount = auth()->user()->unreadNotificationsCount();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="notification-badge">{{ $unreadCount }}</span>
                        @endif
                    </div>
                    <div class="user-menu">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </header>

            <!-- Profile Form -->
            <div class="profile-container">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h2 class="section-title">Informations personnelles</h2>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                Nom complet <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $user->name) }}" 
                                class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                                required
                            >
                            @if($errors->has('name'))
                                <div class="form-error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">
                                Adresse email <span class="required">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', $user->email) }}" 
                                class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                                required
                            >
                            @if($errors->has('email'))
                                <div class="form-error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>

                    <h2 class="section-title">Changer le mot de passe</h2>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="current_password" class="form-label">
                                Mot de passe actuel
                            </label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password" 
                                class="form-input {{ $errors->has('current_password') ? 'error' : '' }}"
                            >
                            @if($errors->has('current_password'))
                                <div class="form-error">{{ $errors->first('current_password') }}</div>
                            @endif
                            <div class="form-help">Laissez vide si vous ne voulez pas changer votre mot de passe</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password" class="form-label">
                                Nouveau mot de passe
                            </label>
                            <input 
                                type="password" 
                                id="new_password" 
                                name="new_password" 
                                class="form-input {{ $errors->has('new_password') ? 'error' : '' }}"
                            >
                            @if($errors->has('new_password'))
                                <div class="form-error">{{ $errors->first('new_password') }}</div>
                            @endif
                            <div class="form-help">Minimum 8 caractères</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password_confirmation" class="form-label">
                                Confirmer le nouveau mot de passe
                            </label>
                            <input 
                                type="password" 
                                id="new_password_confirmation" 
                                name="new_password_confirmation" 
                                class="form-input {{ $errors->has('new_password_confirmation') ? 'error' : '' }}"
                            >
                            @if($errors->has('new_password_confirmation'))
                                <div class="form-error">{{ $errors->first('new_password_confirmation') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('dashboard.user') }}" class="btn btn-outline">
                            <i class="fas fa-arrow-left"></i>
                            Retour au tableau de bord
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
