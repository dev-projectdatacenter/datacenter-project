<?php

/**
 * routes/dashboard.php
 * Auteur : FATIMA
 * Description : Dashboards selon les rôles
 */

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestServicesController;

/*
|--------------------------------------------------------------------------
| ROUTES DE TEST (SANS AUTHENTIFICATION)
|--------------------------------------------------------------------------
| Ces routes servent UNIQUEMENT à tester le backend
| sans frontend (login automatique par ID)
*/

// Tester les services
Route::get('/test-services', [TestServicesController::class, 'test']);

// ===== LOGIN DE TEST PAR RÔLE =====
Route::get('/login-test-admin', function () {
    Auth::loginUsingId(1); // ADMIN
    return redirect('/dashboard');
});

Route::get('/login-test-user', function () {
    Auth::loginUsingId(3); // USER
    return redirect('/dashboard');
});

Route::get('/login-test-tech-manager', function () {
    Auth::loginUsingId(2); // TECH_MANAGER
    return redirect('/dashboard');
});

Route::get('/login-test-invite', function () {
    Auth::loginUsingId(7); // INVITE
    return redirect('/dashboard');
});

// ===== LOGOUT DE TEST =====
Route::get('/logout-test', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES - DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Dashboard principal (auto selon rôle)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Réservations : Valider / Refuser
    Route::post('/reservation/{id}/validate', [DashboardController::class, 'validateReservation'])->name('reservation.validate');
    Route::post('/reservation/{id}/refuse', [DashboardController::class, 'refuseReservation'])->name('reservation.refuse');

    // Ressources : Maintenance
    Route::post('/resource/{id}/maintenance', [DashboardController::class, 'toggleMaintenance'])->name('resource.maintenance');

    // Incidents : Supprimer
    Route::post('/incident/{id}/delete', [DashboardController::class, 'deleteIncident'])->name('incident.delete');
});