<?php
/**
 * routes/dashboard.php
 * Routes des tableaux de bord selon les rôles
 * Géré par FATIMA (coordinatrice)
 */

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ════════════════════════════════════════════════════════════
// TABLEAUX DE BORD (Authentification requise)
// ════════════════════════════════════════════════════════════

Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    
    // ════════════════════════════════════════════════════════════
    // DASHBOARD ADMIN (Admin uniquement)
    // ════════════════════════════════════════════════════════════
    
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('role:admin')
        ->name('admin.dashboard');
    
    // ════════════════════════════════════════════════════════════
    // DASHBOARD TECH MANAGER (Tech Manager uniquement)
    // ════════════════════════════════════════════════════════════
    
    Route::get('/dashboard/tech', [DashboardController::class, 'tech'])
        ->middleware('role:tech_manager')
        ->name('dashboard.tech');
    
    // ════════════════════════════════════════════════════════════
    // DASHBOARD UTILISATEUR (User, Tech Manager, Admin)
    // ════════════════════════════════════════════════════════════
    
    Route::get('/dashboard/user', [DashboardController::class, 'user'])
        ->middleware('role:user')
        ->name('dashboard.user');
    
    // ════════════════════════════════════════════════════════════
    // DASHBOARD INVITÉ (Public - redirection depuis login)
    // ════════════════════════════════════════════════════════════
    
    Route::get('/dashboard/guest', [DashboardController::class, 'guest'])
        ->name('dashboard.guest');
    
    // ════════════════════════════════════════════════════════════
    // API POUR LES DASHBOARDS (Données en temps réel)
    // ════════════════════════════════════════════════════════════
    
    Route::prefix('dashboard/api')->name('dashboard.api.')->group(function () {
        
        // API Admin
        Route::get('/admin/stats', [DashboardController::class, 'adminStats'])
            ->middleware('role:admin')
            ->name('admin.stats');
        
        Route::get('/admin/recent-activities', [DashboardController::class, 'adminRecentActivities'])
            ->middleware('role:admin')
            ->name('admin.recent-activities');
        
        Route::get('/admin/system-status', [DashboardController::class, 'adminSystemStatus'])
            ->middleware('role:admin')
            ->name('admin.system-status');
        
        // API Tech Manager
        Route::get('/tech/stats', [DashboardController::class, 'techStats'])
            ->middleware('role:tech_manager')
            ->name('tech.stats');
        
        Route::get('/tech/pending-reservations', [DashboardController::class, 'techPendingReservations'])
            ->middleware('role:tech_manager')
            ->name('tech.pending-reservations');
        
        Route::get('/tech/resource-status', [DashboardController::class, 'techResourceStatus'])
            ->middleware('role:tech_manager')
            ->name('tech.resource-status');
        
        // API User
        Route::get('/user/stats', [DashboardController::class, 'userStats'])
            ->middleware('role:user')
            ->name('user.stats');
        
        Route::get('/user/active-reservations', [DashboardController::class, 'userActiveReservations'])
            ->middleware('role:user')
            ->name('user.active-reservations');
        
        Route::get('/user/recent-activity', [DashboardController::class, 'userRecentActivity'])
            ->middleware('role:user')
            ->name('user.recent-activity');
        
        // API Guest (publique)
        Route::get('/guest/resource-overview', [DashboardController::class, 'guestResourceOverview'])
            ->name('guest.resource-overview');
    });
    
    // ════════════════════════════════════════════════════════════
    // ROUTE DE DÉFAUT (Redirection selon rôle)
    // ════════════════════════════════════════════════════════════
    
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('dashboard.guest');
        }
        
        $roleName = $user->role ? $user->role->name : 'guest';
        
        switch ($roleName) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'tech_manager':
                return redirect()->route('dashboard.tech');
            case 'user':
                return redirect()->route('dashboard.user');
            default:
                return redirect()->route('dashboard.guest');
        }
    })->name('dashboard');
});
