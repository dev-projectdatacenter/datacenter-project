<?php
/**
 * routes/resources.php
 * Routes de gestion des ressources et catégories
 * Géré par OUARDA
 */

use App\Http\Controllers\ResourceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

// ════════════════════════════════════════════════════════════
// RESSOURCES (Authentification requise)
// ════════════════════════════════════════════════════════════

Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    
    // ════════════════════════════════════════════════════════════
    // RESSOURCES (Tous les utilisateurs authentifiés peuvent voir)
    // ════════════════════════════════════════════════════════════
    
    Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
    Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');
    
    // ════════════════════════════════════════════════════════════
    // GESTION RESSOURCES (Admin et Tech Manager uniquement)
    // ════════════════════════════════════════════════════════════
    
    Route::middleware('role:tech_manager')->group(function () {
        Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
        Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
        Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
        Route::put('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
        Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');
        
        // Maintenance des ressources
        Route::get('/resources/{resource}/maintenance', [MaintenanceController::class, 'create'])->name('resources.maintenance.create');
        Route::post('/resources/{resource}/maintenance', [MaintenanceController::class, 'store'])->name('resources.maintenance.store');
        Route::get('/maintenances', [MaintenanceController::class, 'index'])->name('maintenances.index');
        Route::get('/maintenances/{maintenance}/edit', [MaintenanceController::class, 'edit'])->name('maintenances.edit');
        Route::put('/maintenances/{maintenance}', [MaintenanceController::class, 'update'])->name('maintenances.update');
        Route::delete('/maintenances/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenances.destroy');
    });
    
    // ════════════════════════════════════════════════════════════
    // CATÉGORIES (Admin uniquement)
    // ════════════════════════════════════════════════════════════
    
    Route::middleware('role:admin')->prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });
    
    // ════════════════════════════════════════════════════════════
    // STATISTIQUES
    // ════════════════════════════════════════════════════════════
    
    Route::prefix('statistics')->name('statistics.')->group(function () {
        // Statistiques globales (Admin uniquement)
        Route::get('/global', [StatisticsController::class, 'global'])
            ->middleware('role:admin')
            ->name('global');
        
        // Statistiques des ressources gérées (Tech Manager)
        Route::get('/my-resources', [StatisticsController::class, 'myResources'])
            ->middleware('role:tech_manager')
            ->name('my-resources');
        
        // Statistiques personnelles (Tous les utilisateurs)
        Route::get('/personal', [StatisticsController::class, 'personal'])->name('personal');
        
        // API pour graphiques
        Route::get('/api/usage-chart', [StatisticsController::class, 'usageChartData'])->name('api.usage-chart');
        Route::get('/api/occupancy-rate', [StatisticsController::class, 'occupancyRateData'])->name('api.occupancy-rate');
        Route::get('/api/top-resources', [StatisticsController::class, 'topResourcesData'])->name('api.top-resources');
    });
});
