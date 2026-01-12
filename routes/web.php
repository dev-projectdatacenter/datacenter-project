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
// ROUTES PUBLIQUES
// ============================================

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Test design
Route::get('/test-design', function () {
    return view('test');
});

Route::get('/test-login', function () {
    return view('test-login');
});

// Catalogue (lecture seule)
Route::get('/catalogue', function () {
    return view('resources.catalog');
})->name('resources.catalog');

// Consultation des ressources (lecture seule)
Route::get('/resources', function () {
    $resources = Resource::all();
    return view('resources.index', compact('resources'));
})->name('resources.index');

// Détail d'une ressource
Route::get('/resources/{id}', function ($id) {
    return view('resources.show', compact('id'));
})->name('resources.show');

// ============================================
// ROUTES D'AUTHENTIFICATION
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
// ROUTES PRIVÉES (authentifiées)
// ============================================

Route::middleware(['auth'])->group(function () {
    
    // Dashboards
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/dashboard-user', function () {
        return view('dashboard.user');
    })->name('dashboard.user');
    
    Route::get('/dashboard-responsable', function () {
        return view('dashboard.responsable');
    })->name('dashboard.responsable');
    
    Route::get('/dashboard-admin', function () {
        return view('dashboard.admin');
    })->name('dashboard.admin');
    
    // Réservations
    Route::get('/mes-reservations', function () {
        return view('reservations.index');
    })->name('reservations.index');
    
    Route::get('/reservations/create', function () {
        return view('reservations.create');
    })->name('reservations.create');
    
    Route::get('/reservations/{id}', function ($id) {
        return view('reservations.show', compact('id'));
    })->name('reservations.show');
    
    // Notifications
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications.index');
    
    // Profil
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    
    // ============================================
    // PANEL ADMIN (Admin et Tech Manager)
    // ============================================
    
    Route::middleware(['role:ADMIN,TECH_MANAGER'])->group(function () {
        
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
        
    });
    
});