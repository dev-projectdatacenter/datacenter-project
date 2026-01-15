<?php
/**
 * routes/resources.php
 * Auteur : OUARDA
 * Description : Gestion des ressources du Data Center
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ResourceCategoryController;
use App\Http\Controllers\IncidentController;

// ════════════════════════════════════════════════════════════
// ROUTES PUBLIQUES - CONSULTATION DES RESSOURCES
// ════════════════════════════════════════════════════════════

// Voir les ressources sans authentification (lecture seule)
Route::get('/resources', [ResourceController::class, 'publicIndex'])
    ->name('resources.public');


// ════════════════════════════════════════════════════════════
// ROUTES PROTÉGÉES - GESTION DES RESSOURCES
// ════════════════════════════════════════════════════════════

// TEMPORAIRE : Désactivé pour tester les nouvelles vues (create, show, edit)
// Route::middleware(['auth'])->group(function () {
    
    // CRUD complet des ressources (liste, créer, voir, éditer, supprimer)
    Route::resource('resources', ResourceController::class);
    
    // JOUR 4 : CRUD complet des catégories
    Route::resource('categories', ResourceCategoryController::class);
    
    // Routes additionnelles
    // Route::get('/resources/available', [ResourceController::class, 'available'])->name('resources.available');

    // JOUR 5 : Signalement d'incidents
    Route::get('/incidents/report/{resource}', [IncidentController::class, 'create'])->name('incidents.report');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
    
// });

// TODO JOUR 4 : Ajouter routes categories
// TODO JOUR 6 : Ajouter routes maintenances
// TODO JOUR 7 : Ajouter routes statistiques