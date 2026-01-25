<?php
/**
 * routes/auth.php
 * Routes d'authentification et de gestion utilisateurs
 * Géré par ZAHRAE
 */

use Illuminate\Support\Facades\Route;

// ════════════════════════════════════════════════════════════
// ROUTES PUBLIQUES D'AUTHENTIFICATION
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

        $user = auth()->user();
        $user->load('role'); // ensure role is loaded
        $roleName = $user && $user->role ? $user->role->name : 'guest';

        // Debug temporaire
        if (request()->has('debug')) {
            dd([
                'user_id' => $user->id,
                'user_email' => $user->email,
                'role_id' => $user->role_id,
                'role_name' => $roleName,
                'target_route' => $roleName === 'tech_manager' ? 'dashboard.tech' : '/dashboard'
            ]);
        }

        if ($roleName === 'tech_manager') {
            return redirect()->route('dashboard.tech');
        }

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
        'role_requested' => 'required|string|in:user,tech_manager,admin,invite',
        'motivation' => 'required|string|max:500',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Déterminer le rôle selon la demande
    switch($data['role_requested']) {
        case 'admin':
            $roleId = 1; // ADMIN
            break;
        case 'tech_manager':
            $roleId = 2; // TECH_MANAGER
            break;
        case 'user':
            $roleId = 3; // USER
            break;
        case 'invite':
            $roleId = 4; // INVITE
            break;
        default:
            $roleId = 3; // USER par défaut
    }

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

// ════════════════════════════════════════════════════════════
// ROUTES PROTÉGÉES (AUTHENTIFICATION REQUISE)
// ════════════════════════════════════════════════════════════

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $roleName = $user && $user->role ? $user->role->name : 'guest';
        
        // Dashboard selon le rôle
        switch ($roleName) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'tech_manager':
                return redirect()->route('dashboard.tech');
            case 'user':
                return redirect()->route('dashboard.user');
            default:
                return redirect()->route('dashboard.guest');
        }
    })->name('dashboard');

    // Déconnexion
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

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
    })->name('test.db');

    // Route de test
    Route::get('/test-route', function () {
        return '<h1>✅ Route directe fonctionne!</h1><p><a href="/">← Accueil</a></p>';
    })->name('test.route');
});

// ════════════════════════════════════════════════════════════
// MOT DE PASSE OUBLIÉ
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

// Page de réinitialisation du mot de passe
Route::get('/reset-password/{token}', function ($token) {
    // Vérifier si le token est valide et n'a pas expiré
    if (!session('password_reset_token') || session('password_reset_token') !== $token || now()->gt(session('password_reset_expires'))) {
        return redirect('/forgot-password')->with('error', 'Le lien de réinitialisation est invalide ou a expiré.');
    }

    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

// Traitement de la réinitialisation
Route::post('/reset-password', function () {
    $data = request()->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|string|min:8|confirmed',
    ], [
        'password.required' => 'Le mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit faire au moins 8 caractères.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ]);

    // Vérifier le token
    if (!session('password_reset_token') || session('password_reset_token') !== $data['token']) {
        return back()->with('error', 'Token invalide.');
    }

    // Vérifier l'email
    if (session('password_reset_email') !== $data['email']) {
        return back()->with('error', 'Email incorrect.');
    }

    // Mettre à jour le mot de passe
    $user = \App\Models\User::where('email', $data['email'])->first();
    if (!$user) {
        return back()->with('error', 'Utilisateur non trouvé.');
    }

    $user->update([
        'password' => bcrypt($data['password']),
    ]);

    // Nettoyer la session
    session()->forget(['password_reset_token', 'password_reset_email', 'password_reset_expires']);

    return redirect('/login')->with('success', 'Votre mot de passe a été réinitialisé avec succès!');
})->name('password.update');

// ════════════════════════════════════════════════════════════
// ROUTES ADMINISTRATION (ZAHRAE)
// ════════════════════════════════════════════════════════════

// Ici vous pourrez ajouter vos routes d'administration plus tard
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//     // Vos routes admin ici
// });