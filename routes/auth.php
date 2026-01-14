<?php
// routes/auth.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AccountRequestController;
use App\Http\Controllers\AdminLogController;
use Illuminate\Support\Facades\Route;

// ============================================
// ROUTES PUBLIQUES (Accessibles sans connexion)
// ============================================

Route::middleware('guest')->group(function () {
    // --- Connexion ---
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // --- Inscription / Demande de compte ---
    Route::get('/register', [AccountRequestController::class, 'create'])->name('register');
    Route::post('/register', [AccountRequestController::class, 'store']);
    
    // --- Demande de compte (version alternative) ---
    // Si vous voulez séparer l'inscription de la demande de compte
    Route::get('/account/request', [AccountRequestController::class, 'createRequest'])
        ->name('account.request');
    Route::post('/account/request', [AccountRequestController::class, 'storeRequest'])
        ->name('account.request.store');
});

// ============================================
// ROUTES PROTÉGÉES (Nécessite d'être connecté)
// ============================================

Route::middleware('auth')->group(function () {
    // --- Déconnexion (accessible à tous les rôles connectés) ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ============================================
    // ESPACE UTILISATEUR STANDARD (Rôle: USER)
    // ============================================
    Route::middleware('role:USER')->group(function () {
        Route::get('/dashboard/user', function () {
            return view('dashboard.user');
        })->name('dashboard.user');
        
        // Mon profil utilisateur
        Route::get('/profile', function () {
            return view('profile.index');
        })->name('profile.index');
        
        Route::put('/profile/update', function () {
            // Logique de mise à jour du profil
        })->name('profile.update');
    });
    
    // ============================================
    // ESPACE TECHNICIEN / MANAGER (Rôle: TECH_MANAGER)
    // ============================================
    Route::middleware('role:TECH_MANAGER')->group(function () {
        // Dashboard tech
        Route::get('/dashboard/tech', function () {
            return view('dashboard.tech');
        })->name('dashboard.tech');
        
        // Gestion des réservations (en attente d'approbation)
        Route::prefix('tech')->name('tech.')->group(function () {
            Route::get('/reservations/pending', function () {
                return view('tech.reservations.pending');
            })->name('reservations.pending');
            
            // Approuver/refuser une réservation
            Route::post('/reservations/{id}/approve', function ($id) {
                // Logique d'approbation
            })->name('reservations.approve');
            
            Route::post('/reservations/{id}/reject', function ($id) {
                // Logique de refus
            })->name('reservations.reject');
        });
    });
    
    // ============================================
    // ESPACE ADMINISTRATEUR (Rôle: ADMIN)
    // ============================================
    Route::middleware('role:ADMIN')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard admin
        Route::get('/dashboard', function () {
            return view('dashboard.admin');
        })->name('dashboard');
        
        // ============================
        // GESTION DES UTILISATEURS (CRUD complet)
        // ============================
        Route::prefix('users')->name('users.')->group(function () {
            // Liste des utilisateurs
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            
            // Formulaire création utilisateur
            Route::get('/create', [AdminUserController::class, 'create'])->name('create');
            
            // Enregistrer nouvel utilisateur
            Route::post('/', [AdminUserController::class, 'store'])->name('store');
            
            // Voir détails utilisateur
            Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
            
            // Formulaire modification utilisateur
            Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
            
            // Mettre à jour utilisateur
            Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
            
            // Supprimer utilisateur
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
            
            // Activer/désactiver utilisateur
            Route::patch('/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])
                ->name('toggle-status');
            
            // Changer le rôle d'un utilisateur
            Route::patch('/{user}/change-role', [AdminUserController::class, 'changeRole'])
                ->name('change-role');
        });
        
        // ============================
        // GESTION DES DEMANDES DE COMPTE
        // ============================
        Route::prefix('account-requests')->name('requests.')->group(function () {
            // Liste des demandes en attente
            Route::get('/', [AccountRequestController::class, 'index'])->name('index');
            
            // Approuver une demande
            Route::post('/{request}/approve', [AccountRequestController::class, 'approve'])
                ->name('approve');
            
            // Refuser une demande
            Route::post('/{request}/reject', [AccountRequestController::class, 'reject'])
                ->name('reject');
            
            // Voir historique des demandes traitées
            Route::get('/history', [AccountRequestController::class, 'history'])
                ->name('history');
        });
        
        // ============================
        // JOURNAL D'ACTIVITÉ (LOGS)
        // ============================
        Route::prefix('logs')->name('logs.')->group(function () {
            // Voir les logs d'activité
            Route::get('/', [AdminLogController::class, 'index'])->name('index');
            
            // Voir les logs de sécurité
            Route::get('/security', [AdminLogController::class, 'security'])->name('security');
            
            // Voir les logs d'un utilisateur spécifique
            Route::get('/user/{user}', [AdminLogController::class, 'userLogs'])->name('user');
            
            // Exporter les logs
            Route::get('/export', [AdminLogController::class, 'export'])->name('export');
        });
        
        // ============================
        // PARAMÈTRES SYSTÈME
        // ============================
        Route::prefix('settings')->name('settings.')->group(function () {
            // Page des paramètres généraux
            Route::get('/', function () {
                return view('admin.settings.index');
            })->name('index');
            
            // Mettre à jour les paramètres
            Route::put('/', function () {
                // Logique de mise à jour des paramètres
            })->name('update');
            
            // Paramètres d'authentification
            Route::get('/auth', function () {
                return view('admin.settings.auth');
            })->name('auth');
        });
    });
    
    // ============================================
    // ROUTES DE TEST ET DÉVELOPPEMENT
    // ============================================
    if (app()->environment('local')) {
        // Tester les permissions de rôle
        Route::get('/test-role/{role}', function ($role) {
            return "Vous avez accès à cette page avec le rôle: " . $role;
        })->middleware('role:' . request()->role);
        
        // Voir les informations de session
        Route::get('/debug/session', function () {
            return response()->json([
                'session' => session()->all(),
                'user' => auth()->user(),
                'role' => auth()->user()->role ?? 'guest'
            ]);
        })->name('debug.session');
    }
});

// ============================================
// ROUTES POUR LES ERREURS D'AUTHENTIFICATION
// ============================================

// Page d'erreur 403 - Accès interdit
Route::get('/403', function () {
    return view('errors.403');
})->name('error.403');

// Redirection en cas d'accès non autorisé
Route::get('/unauthorized', function () {
    return redirect()->route('login')->withErrors([
        'auth' => 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.'
    ]);
})->name('unauthorized');

// ============================================
// ROUTES POUR LA RÉINITIALISATION DE MOT DE PASSE
// (À IMPLÉMENTER PLUS TARD)
// ============================================

// Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])
//     ->middleware('guest')->name('password.request');

// Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])
//     ->middleware('guest')->name('password.email');

// Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
//     ->middleware('guest')->name('password.reset');

// Route::post('/reset-password', [PasswordResetController::class, 'reset'])
//     ->middleware('guest')->name('password.update');

// ============================================
// ROUTES API POUR L'AUTHENTIFICATION
// (Optionnel - pour applications mobiles/frontends JS)
// ============================================

// Route::prefix('api/auth')->name('api.auth.')->group(function () {
//     Route::post('/login', [Api\AuthController::class, 'login']);
//     Route::post('/register', [Api\AuthController::class, 'register']);
//     Route::post('/logout', [Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
//     Route::get('/user', [Api\AuthController::class, 'user'])->middleware('auth:sanctum');
// });