<?php
/**
 * routes/web.php
 * Fichier principal - Import des routes de l'équipe
 * Géré par FATIMA (coordinatrice)
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;

// ══════════════════════════════════════════════════════════
// DASHBOARD INVITÉ (Public - accessible sans authentification)
// ════════════════════════════════════════════════════════════

Route::get('/dashboard/guest', [\App\Http\Controllers\Dashboard\DashboardController::class, 'guest'])
    ->name('dashboard.guest');

// ══════════════════════════════════════════════════════════
// PAGE D'ACCUEIL
// ══════════════════════════════════════════════════════════

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Paramètres utilisateur
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// ══════════════════════════════════════════════════════════
// IMPORT DES ROUTES DE CHAQUE MEMBRE DE L'ÉQUIPE
// ══════════════════════════════════════════════════════════

// Authentification & Admin - ZAHRAE
require __DIR__.'/auth.php';

// Gestion des Ressources - OUARDA
require __DIR__.'/resources.php';

// Gestion des Réservations - HALIMA
require __DIR__.'/reservations.php';

// Dashboards - FATIMA
require __DIR__.'/dashboard.php';