<?php
/**
 * routes/dashboard.php
 * Routes des tableaux de bord selon les rôles
 * Géré par FATIMA (coordinatrice)
 */

use App\Http\Controllers\Dashboard\DashboardController;
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
    // ADMINISTRATION
    // ════════════════════════════════════════════════════════════
    
    // Gestion des utilisateurs
    Route::prefix('admin/users')
        ->name('admin.users.')
        ->middleware('role:admin')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminUserController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\AdminUserController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\AdminUserController::class, 'store'])->name('store');
            Route::get('/{user}', [\App\Http\Controllers\AdminUserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [\App\Http\Controllers\AdminUserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [\App\Http\Controllers\AdminUserController::class, 'update'])->name('update');
            Route::patch('/{user}/toggle-status', [\App\Http\Controllers\AdminUserController::class, 'toggleStatus'])->name('toggle-status');
            Route::delete('/{user}', [\App\Http\Controllers\AdminUserController::class, 'destroy'])->name('destroy');
        });
    
    // Gestion des rôles - Désactivée pour le moment
    /*
    Route::prefix('admin/roles')
        ->name('admin.roles.')
        ->middleware('role:admin')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->name('store');
            Route::get('/{role}/edit', [\App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('edit');
            Route::put('/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])->name('update');
            Route::delete('/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('destroy');
        });
    */
    
    // Statistiques
    Route::get('/admin/statistics', [\App\Http\Controllers\StatisticsController::class, 'index'])
        ->name('admin.statistics.index')
        ->middleware('role:admin');
        
    // Mes statistiques
    Route::get('/my-statistics', [\App\Http\Controllers\StatisticsController::class, 'myResources'])
        ->name('statistics.my_resources')
        ->middleware('auth');
    
    // Logs d'activité
    Route::prefix('admin/logs')
        ->name('admin.logs.')
        ->middleware('role:admin')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\LogController::class, 'index'])->name('index');
            Route::get('/{log}', [\App\Http\Controllers\Admin\LogController::class, 'show'])->name('show');
        });
    
    // Gestion des ressources
    Route::prefix('admin/resources')
        ->name('admin.resources.')
        ->middleware('role:admin,tech_manager')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ResourceController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\ResourceController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\ResourceController::class, 'store'])->name('store');
            Route::get('/{resource}/edit', [\App\Http\Controllers\Admin\ResourceController::class, 'edit'])->name('edit');
            Route::put('/{resource}', [\App\Http\Controllers\Admin\ResourceController::class, 'update'])->name('update');
            Route::delete('/{resource}', [\App\Http\Controllers\Admin\ResourceController::class, 'destroy'])->name('destroy');
        });
    
    // Gestion des réservations
    Route::prefix('admin/reservations')
        ->name('admin.reservations.')
        ->middleware('role:admin,tech_manager')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\ReservationController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\ReservationController::class, 'store'])->name('store');
            Route::get('/{reservation}/edit', [\App\Http\Controllers\Admin\ReservationController::class, 'edit'])->name('edit');
            Route::put('/{reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'update'])->name('update');
            Route::delete('/{reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'destroy'])->name('destroy');
            Route::put('/{reservation}/status', [\App\Http\Controllers\Admin\ReservationController::class, 'updateStatus'])->name('updateStatus');
        });
    
    // Configuration système
    Route::prefix('admin/settings')
        ->name('admin.settings.')
        ->middleware('role:admin')
        ->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('index');
            Route::put('/', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update');
        });
    
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
