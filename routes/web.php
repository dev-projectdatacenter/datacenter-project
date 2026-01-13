<?php
use Illuminate\Support\Facades\Route;
use App\Models\Resource;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// ============================================
// ROUTES PUBLIQUES
// ============================================

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Test design (chaimae)
Route::get('/test-design', function () {
    return view('test');
});

Route::get('/test-login', function () {
    return view('test-login');
});

// Consultation des ressources (lecture seule)
Route::get('/resources', function () {
    $resources = Resource::all();
    return view('resources.index', compact('resources'));
})->name('resources.index');

// ============================================
// ROUTES D'AUTHENTIFICATION (publiques)
// ============================================

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route temporaire pour voir le login 
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route temporaire pour éviter l'erreur "logout not defined" 
Route::post('/logout', function () {
    return "Déconnexion (Test)";
})->name('logout');

Route::get('/logout', function () {
    return "Déconnexion (Test)";
})->name('logout.get');

// Demande de compte
Route::get('/demande-compte', [AuthController::class, 'showAccountRequest'])->name('account.request');
Route::post('/demande-compte', [AuthController::class, 'submitAccountRequest'])->name('account.request.submit');

// ============================================
// ROUTES RESSOURCES
// ============================================

Route::get('/catalogue', function () {
    return view('resources.catalog');
})->name('resources.catalog');

// Route temporaire pour voir le détail d'une ressource (ID 1 par exemple)
Route::get('/resources/1', function () {
    return view('resources.show');
});

// ============================================
// ROUTES PRIVÉES (authentifiées)
// ============================================

Route::middleware(['auth'])->group(function () {
    
    // Tableau de bord
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Tableaux de bord supplémentaires (Luis)
    Route::get('/dashboard-user', function () {
        return view('dashboard.user');
    });
    
    Route::get('/dashboard-responsable', function () {
        return view('dashboard.responsable');
    });
    
    Route::get('/dashboard-admin', function () {
        return view('dashboard.admin');
    });
    
    // Réservations
    Route::get('/reservations', function () {
        return view('reservations.index');
    })->name('reservations.index');
    
    Route::get('/mes-reservations', function () {
        return view('reservations.index');
    });
    
    Route::get('/reservations/create', function () {
        return view('reservations.create');
    });
    
    // Voir le détail d'une réservation (ID fictif 1)
    Route::get('/reservations/1', function () {
        return view('reservations.show');
    });
    
    // Notifications
    Route::get('/notifications', function () {
        return view('notifications.index');
    });
    
    // Profil
    Route::get('/profile', function () {
        return view('profile.edit');
    });
    
    // Panel admin (Admin et Tech Manager seulement)
    Route::get('/admin-panel', function () {
        return view('admin.panel');
    })->name('admin.panel')->middleware('role:ADMIN,TECH_MANAGER');
    
    Route::get('/admin/users', function () {
        return view('admin.users.index');
    });
    
    Route::get('/admin/account-requests', function () {
        return view('admin.account-requests.index');
    });
    
    Route::get('/admin/statistics', function () {
        return view('admin.statistics.index');
    });
    
    Route::get('/admin/logs', function () {
        return view('admin.logs.index');
    });
});