<?php
/**
 * routes/reservations.php
 * Routes de gestion des réservations et notifications
 * Géré par HALIMA
 */

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TechReservationController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// ════════════════════════════════════════════════════════════
// RÉSERVATIONS (Authentification requise)
// ════════════════════════════════════════════════════════════

Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    
    // ════════════════════════════════════════════════════════════
    // RÉSERVATIONS UTILISATEURS (User, Tech Manager, Admin)
    // ════════════════════════════════════════════════════════════
    
    Route::middleware('role:user')->prefix('reservations')->name('reservations.')->group(function () {
        // Liste des réservations de l'utilisateur
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        
        // Formulaire de réservation
        Route::get('/create', [ReservationController::class, 'create'])->name('create');
        
        // Création réservation
        Route::post('/', [ReservationController::class, 'store'])->name('store');
        
        // Détails réservation
        Route::get('/{reservation}', [ReservationController::class, 'show'])->name('show');
        
        // Modification réservation (seulement si en attente)
        Route::get('/{reservation}/edit', [ReservationController::class, 'edit'])->name('edit');
        Route::put('/{reservation}', [ReservationController::class, 'update'])->name('update');
        
        // Annulation réservation
        Route::delete('/{reservation}', [ReservationController::class, 'cancel'])->name('cancel');
        
        // Historique des réservations
        Route::get('/history', [ReservationController::class, 'history'])->name('history');
        
        // Statistiques personnelles
        Route::get('/stats', [ReservationController::class, 'stats'])->name('stats');
        
        // API vérification disponibilité
        Route::get('/api/check-availability', [ReservationController::class, 'checkAvailability'])->name('api.check-availability');
    });
    
    // ════════════════════════════════════════════════════════════
    // GESTION RÉSERVATIONS (Tech Manager et Admin)
    // ════════════════════════════════════════════════════════════
    
    Route::middleware('role:tech_manager')->prefix('tech')->name('tech.')->group(function () {
        // Réservations en attente pour les ressources gérées
        Route::get('/reservations/pending', [TechReservationController::class, 'pending'])->name('reservations.pending');
        
        // Approuver une réservation
        Route::put('/reservations/{reservation}/approve', [TechReservationController::class, 'approve'])->name('reservations.approve');
        
        // Refuser une réservation
        Route::put('/reservations/{reservation}/reject', [TechReservationController::class, 'reject'])->name('reservations.reject');
        
        // Approuver plusieurs réservations
        Route::put('/reservations/bulk-approve', [TechReservationController::class, 'bulkApprove'])->name('reservations.bulk-approve');
        
        // Refuser plusieurs réservations
        Route::put('/reservations/bulk-reject', [TechReservationController::class, 'bulkReject'])->name('reservations.bulk-reject');
        
        // Statistiques des approbations
        Route::get('/reservations/stats', [TechReservationController::class, 'stats'])->name('reservations.stats');
        
        // Toutes les réservations (pour les ressources gérées)
        Route::get('/reservations', [TechReservationController::class, 'index'])->name('reservations.index');
        
        // Détails réservation
        Route::get('/reservations/{reservation}', [TechReservationController::class, 'show'])->name('reservations.show');
        
        // Signaler un problème/incident
        Route::post('/reservations/{reservation}/report-incident', [TechReservationController::class, 'reportIncident'])->name('reservations.report-incident');
    });
    
    // ════════════════════════════════════════════════════════════
    // NOTIFICATIONS - Routes pour JavaScript pur
    // ════════════════════════════════════════════════════════════
    
    Route::prefix('notifications')->name('notifications.')->group(function () {
        // Liste des notifications
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        
        // Marquer comme lue
        Route::patch('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        
        // Marquer toutes comme lues
        Route::patch('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        
        // Marquer plusieurs comme lues (pour JavaScript pur)
        Route::patch('/mark-multiple-read', [NotificationController::class, 'markMultipleAsRead'])->name('mark-multiple-read');
        
        // Supprimer notification
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
        
        // Supprimer plusieurs notifications (pour JavaScript pur)
        Route::delete('/delete-multiple', [NotificationController::class, 'destroyMultiple'])->name('delete-multiple');
        
        // API pour nouvelles notifications (polling)
        Route::get('/api/unread-count', [NotificationController::class, 'unreadCount'])->name('api.unread-count');
        Route::get('/api/recent', [NotificationController::class, 'recent'])->name('api.recent');
        Route::get('/api/stats', [NotificationController::class, 'stats'])->name('api.stats');
    });
    
    // ════════════════════════════════════════════════════════════
    // INCIDENTS (Tous les utilisateurs peuvent signaler)
    // ════════════════════════════════════════════════════════════
    
    Route::prefix('incidents')->name('incidents.')->group(function () {
        // Signaler un incident
        Route::post('/', [ReservationController::class, 'reportIncident'])->name('store');
        
        // Voir ses incidents
        Route::get('/', [ReservationController::class, 'myIncidents'])->name('index');
    });
});
