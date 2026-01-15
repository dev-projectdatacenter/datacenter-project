<?php
/**
 * routes/resources.php
 * Auteur : OUARDA
 * Description : Gestion des ressources du Data Center
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourceController;

// ════════════════════════════════════════════════════════════
// ROUTES PUBLIQUES - CONSULTATION DES RESSOURCES
// ════════════════════════════════════════════════════════════

// Voir les ressources sans authentification (lecture seule)
Route::get('/resources', [ResourceController::class, 'publicIndex'])
    ->name('resources.public');


// ════════════════════════════════════════════════════════════
// ROUTES PROTÉGÉES - GESTION DES RESSOURCES
// ════════════════════════════════════════════════════════════

Route::middleware(['auth'])->group(function () {
    
    // CRUD complet des ressources (liste, créer, voir, éditer, supprimer)
    Route::resource('resources', ResourceController::class);
    
    // Routes additionnelles
    // Route::get('/resources/available', [ResourceController::class, 'available'])->name('resources.available');
    
});

// TODO JOUR 4 : Ajouter routes categories
// TODO JOUR 6 : Ajouter routes maintenances
// TODO JOUR 7 : Ajouter routes statistiques