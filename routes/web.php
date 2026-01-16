<?php
/**
 * routes/web.php
 * Fichier principal - Import des routes de l'équipe
 * Géré par FATIMA (coordinatrice)
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;

// ══════════════════════════════════════════════════════════
// PAGE D'ACCUEIL
// ══════════════════════════════════════════════════════════

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ══════════════════════════════════════════════════════════
// DÉCONNEXION
// ══════════════════════════════════════════════════════════

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

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