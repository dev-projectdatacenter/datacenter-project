<?php

use Illuminate\Support\Facades\Route;
use App\Models\Resource;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ============================================
// 1. ROUTES FRONTEND & TESTS (Pour le design)
// ============================================

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/test-design', function () {
    return view('test');
});

Route::get('/test-login', function () {
    return view('test-login');
});

// Consultation catalogue (Lecture seule pour invités)
Route::get('/catalogue', function () {
    return view('resources.catalog');
})->name('resources.catalog');

Route::get('/resources', function () {
    // Si la DB est vide, ça ne plantera pas, on envoie une liste vide
    $resources = class_exists(Resource::class) ? Resource::all() : []; 
    return view('resources.index', compact('resources'));
})->name('resources.index');

Route::get('/resources/{id}', function ($id) {
    return view('resources.show', compact('id'));
})->name('resources.show');


// ============================================
// 2. ROUTES D'AUTHENTIFICATION (Backend)
// ============================================

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Demande de compte
Route::get('/demande-compte', [AuthController::class, 'showAccountRequest'])->name('account.request');
Route::post('/demande-compte', [AuthController::class, 'submitAccountRequest'])->name('account.request.submit');


// ============================================
// 3. ROUTES PRIVÉES (Utilisateurs connectés)
// ============================================

Route::middleware(['auth'])->group(function () {
    
    // --- DASHBOARD CENTRAL ---
    Route::get('/dashboard', function () {
        // Redirection intelligente selon le rôle (Logique Backend)
        // Tu peux adapter cette logique selon tes besoins frontend
        return view('dashboard'); 
    })->name('dashboard');
    
    // Vues spécifiques par rôle
    Route::get('/dashboard-user', function () {
        return view('dashboard.user');
    })->name('dashboard.user');
    
    Route::get('/dashboard-responsable', function () {
        return view('dashboard.responsable');
    })->name('dashboard.responsable');
    
    Route::get('/dashboard-admin', function () {
        return view('dashboard.admin');
    })->name('dashboard.admin');
    
    // --- RÉSERVATIONS ---
    Route::get('/mes-reservations', function () {
        return view('reservations.index');
    })->name('reservations.index');
    
    Route::get('/reservations/create', function () {
        return view('reservations.create');
    })->name('reservations.create');
    
    Route::get('/reservations/{id}', function ($id) {
        return view('reservations.show', compact('id'));
    })->name('reservations.show');
    
    // --- NOTIFICATIONS & PROFIL ---
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications.index');
    
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    
    
    // ============================================
    // 4. PANEL ADMIN (Admin et Tech Manager)
    // ============================================
    // Note : Assure-toi que le Middleware 'role' est bien créé, sinon commente la ligne ci-dessous
    // Route::middleware(['role:ADMIN,TECH_MANAGER'])->group(function () {
        
        Route::get('/admin-panel', function () {
            return view('admin.panel');
        })->name('admin.panel');
        
        Route::get('/admin/users', function () {
            return view('admin.users.index');
        })->name('admin.users.index');
        
        Route::get('/admin/account-requests', function () {
            return view('admin.account-requests.index');
        })->name('admin.account-requests.index');
        
        Route::get('/admin/statistics', function () {
            return view('admin.statistics.index');
        })->name('admin.statistics.index');
        
        Route::get('/admin/logs', function () {
            return view('admin.logs.index');
        })->name('admin.logs.index');
        
    // }); // Fin du groupe middleware role
});