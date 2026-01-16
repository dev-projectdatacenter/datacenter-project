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
    return view('welcome');
})->name('home');


// ════════════════════════════════════════════════════════════
// IMPORT DES ROUTES DE CHAQUE MEMBRE DE L'ÉQUIPE
// ════════════════════════════════════════════════════════════

// Authentification & Admin - ZAHRAE
require _DIR_.'/auth.php';

// Gestion des Ressources - OUARDA
require _DIR_.'/resources.php';

// Gestion des Réservations - HALIMA
require _DIR_.'/reservations.php';

// Dashboards - FATIMA
require _DIR_.'/dashboard.php';