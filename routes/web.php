<?php
/**
 * routes/web.php
 * Fichier principal - Import des routes de l'équipe
 * Géré par FATIMA (coordinatrice)
 */

use Illuminate\Support\Facades\Route;

// ════════════════════════════════════════════════════════════
// PAGE D'ACCUEIL
// ════════════════════════════════════════════════════════════
Route::get('/', function () {
    return '<h1>🏢 Data Center Management</h1><p>Page de test - Système fonctionnel!</p><p><a href="/login">Connexion</a> | <a href="/register">Inscription</a> | <a href="/test-db">Test BDD</a> | <a href="/test-route">Test Route</a></p>';
})->name('home');

// ════════════════════════════════════════════════════════════
// ROUTE DE TEST DIRECTE
// ════════════════════════════════════════════════════════════
Route::get('/test-route', function () {
    return '<h1>✅ Route directe fonctionne!</h1><p><a href="/">← Accueil</a></p>';
});

// ════════════════════════════════════════════════════════════
// ROUTES D'AUTHENTIFICATION (ZAHRAE)
// ════════════════════════════════════════════════════════════

// Page de connexion
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Traitement connexion
Route::post('/login', function () {
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->attempt($credentials)) {
        request()->session()->regenerate();
        return redirect('/dashboard');
    }

    return back()->withErrors(['email' => 'Identifiants incorrects']);
});

// Page d'inscription
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Traitement inscription
Route::post('/register', function () {
    $data = request()->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'phone' => 'nullable|string|max:20',
        'department' => 'required|string|max:100',
        'role_requested' => 'required|string|in:user,tech_manager',
        'motivation' => 'required|string|max:500',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Déterminer le rôle selon la demande
    $roleId = ($data['role_requested'] == 'tech_manager') ? 2 : 3; // TECH_MANAGER ou USER

    \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'phone' => $data['phone'],
        'role_id' => $roleId,
        'status' => 'active',
        'department' => $data['department'],
        'motivation' => $data['motivation'],
    ]);

    return redirect('/login')->with('success', 'Votre demande a été traitée avec succès ! Vous pouvez maintenant vous connecter.');
});

// Déconnexion
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

// Dashboard
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }
    
    $user = auth()->user();
    $roleName = $user->role ? $user->role->name : 'Non défini';
    
    // Dashboard selon le rôle
    switch($roleName) {
        case 'ADMIN':
            return view('dashboard.admin', compact('user'));
        case 'TECH_MANAGER':
            return view('dashboard.tech', compact('user'));
        case 'USER':
            return view('dashboard.user', compact('user'));
        case 'INVITE':
            return view('dashboard.invite', compact('user'));
        default:
            return "<h1>🎉 Dashboard de {$user->name}!</h1>
                    <p>Email: {$user->email}</p>
                    <p>Rôle: {$roleName}</p>
                    <form method='POST' action='/logout'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button type='submit'>Déconnexion</button>
                    </form>
                    <p><a href='/'>← Accueil</a></p>";
    }
})->middleware('auth');

// Test base de données
Route::get('/test-db', function () {
    try {
        $users = \App\Models\User::count();
        $roles = \App\Models\Role::count();
        return "<h1>✅ Base de données connectée!</h1>
                <p>Utilisateurs: {$users}</p>
                <p>Rôles: {$roles}</p>
                <p><a href='/'>Retour accueil</a></p>";
    } catch (\Exception $e) {
        return "<h1>❌ Erreur base de données</h1><p>{$e->getMessage()}</p>";
    }
});

// ════════════════════════════════════════════════════════════
// MOT DE PASSE OUBLIÉ (ZAHRAE)
// ════════════════════════════════════════════════════════════

// Page demande de réinitialisation
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// Envoi lien de réinitialisation
Route::post('/forgot-password', function () {
    $data = request()->validate([
        'email' => 'required|email|exists:users,email',
    ], [
        'email.required' => 'L\'adresse email est obligatoire.',
        'email.email' => 'Veuillez entrer une adresse email valide.',
        'email.exists' => 'Cette adresse email n\'existe pas dans notre système.',
    ]);

    // Générer un token temporaire
    $token = Str::random(60);
    
    // Stocker le token en session (pour développement)
    session([
        'password_reset_token' => $token,
        'password_reset_email' => $data['email'],
        'password_reset_expires' => now()->addMinutes(60),
    ]);

    return redirect('/forgot-password')->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
})->name('password.email');

// ════════════════════════════════════════════════════════════
// IMPORT DES ROUTES DE CHAQUE MEMBRE DE L'ÉQUIPE
// ════════════════════════════════════════════════════════════

// Authentification & Admin - ZAHRAE ✅ (Désactivé - routes directement ici)
// require __DIR__.'/auth.php';

// Gestion des Ressources - OUARDA (En attente)
// require __DIR__.'/resources.php';

// Gestion des Réservations - HALIMA (En attente)
// require __DIR__.'/reservations.php';

// Dashboards - FATIMA (En attente)
// require __DIR__.'/dashboard.php';
