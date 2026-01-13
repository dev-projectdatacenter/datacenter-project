php<?php
/**
 * routes/dashboard.php
 * Auteur : FATIMA
 * Description : Dashboards selon les rôles
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// ════════════════════════════════════════════════════════════
// ROUTES PROTÉGÉES - DASHBOARDS
// ════════════════════════════════════════════════════════════

Route::middleware(['auth'])->group(function () {
    
    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Dashboards spécifiques (à créer plus tard)
    // Route::get('/dashboard/guest', [DashboardController::class, 'guest'])->name('dashboard.guest');
    // Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');
    // Route::get('/dashboard/tech', [DashboardController::class, 'tech'])->name('dashboard.tech');
    // Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    
});