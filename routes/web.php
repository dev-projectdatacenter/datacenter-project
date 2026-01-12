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

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================
// ROUTES PRIVÉES (authentifiées)
// ============================================

Route::middleware(['auth'])->group(function () {
    // Tableau de bord
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Réservations
    Route::get('/reservations', function () {
        return view('reservations.index');
    })->name('reservations.index');

    // Panel admin (Admin et Tech Manager seulement)
    Route::get('/admin-panel', function () {
        return view('admin.panel');
    })->name('admin.panel')->middleware('role:ADMIN,TECH_MANAGER');
});