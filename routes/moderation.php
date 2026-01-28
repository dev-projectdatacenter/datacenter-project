<?php
/**
 * routes/moderation.php
 * Routes de modération des discussions
 */

use Illuminate\Support\Facades\Route;

// ════════════════════════════════════════════════════════════
    // MODÉRATION (Tech Managers et Admins)
    // ════════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:tech_manager,admin'])->prefix('moderation')->name('moderation.')->group(function () {
    // Tableau de bord de modération
    Route::get('/dashboard', function() {
        return view('moderation.dashboard');
    })->name('dashboard');
    
    // Messages signalés (gérés côté client)
    Route::get('/reported', function() {
        return view('moderation.reported');
    })->name('reported');
});
