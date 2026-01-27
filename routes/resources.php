<?php
/**
 * routes/resources.php
 * Auteur : OUARDA
 * Description : Gestion des ressources du Data Center
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\ResourceCategoryController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\StatisticsController;

// ════════════════════════════════════════════════════════════
// ROUTES PUBLIQUES - CONSULTATION DES RESSOURCES
// ════════════════════════════════════════════════════════════

// Voir les ressources sans authentification (lecture seule)
Route::get('/all-resources', function() {
    $resources = \App\Models\Resource::with('category')
        ->get();
        
    return view('resources.public-index', compact('resources'));
})->name('resources.public');

// Voir uniquement les ressources disponibles
Route::get('/disponibilites', function() {
    $resources = \App\Models\Resource::with('category')
        ->where('status', 'available')
        ->get();
        
    return view('resources.available-index', compact('resources'));
})->name('public.resources.available');

// Voir le détail d'une ressource spécifique
Route::get('/resource/{resource}', function(\App\Models\Resource $resource) {
    return view('resources.public-show', compact('resource'));
})->name('resources.public.show');


// ════════════════════════════════════════════════════════════
// ROUTES PROTÉGÉES - GESTION DES RESSOURCES
// ════════════════════════════════════════════════════════════

Route::middleware(['auth'])->group(function () {
    
    // CRUD complet des ressources (liste, créer, voir, éditer, supprimer)
    Route::resource('resources', ResourceController::class);
    
    // JOUR 4 : CRUD complet des catégories
    Route::resource('categories', ResourceCategoryController::class);
    
    // JOUR 6 : CRUD complet des maintenances
    Route::resource('maintenances', MaintenanceController::class);
    
    // Routes additionnelles
    Route::get('/resources/available', [ResourceController::class, 'available'])->name('resources.available');

    // JOUR 5 & 6 : Gestion des incidents
    Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index');
    Route::get('/incidents/create', [IncidentController::class, 'create'])->name('incidents.create');
    Route::get('/incidents/report/{resource}', [IncidentController::class, 'create'])->name('incidents.report');
    Route::get('/incidents/{incident}', [IncidentController::class, 'show'])->name('incidents.show');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');
    Route::patch('/incidents/{incident}/resolve', [IncidentController::class, 'resolve'])->name('incidents.resolve');

    // JOUR 7 & 8 : Statistiques
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/my-resources', [StatisticsController::class, 'myResources'])->name('statistics.my_resources');
    
});
