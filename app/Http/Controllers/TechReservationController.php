<?php
/**
 * TechReservationController.php
 * Gestion des réservations pour les gestionnaires techniques
 * Géré par HALIMA - Jour 6
 */

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\User;
use App\Services\ReservationValidationService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class TechReservationController extends Controller
{
    protected $validationService;

    public function __construct(ReservationValidationService $validationService = null)
    {
        $this->validationService = $validationService ?: new ReservationValidationService();
    }

    /**
     * Liste de toutes les réservations (approuvées, refusées, en attente)
     */
    public function all(Request $request)
    {
        $query = Reservation::with(['user', 'resource'])
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('resource_id')) {
            $query->where('resource_id', $request->resource_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $reservations = $query->paginate(15);
        $resources = Resource::all();
        $users = User::where('role_id', 3)->get(); // 3 = role 'user' uniquement

        return view('tech.reservations.all', compact('reservations', 'resources', 'users'));
    }

    /**
     * Liste des réservations en attente d'approbation
     */
    public function pending(Request $request)
    {
        $query = Reservation::with(['user', 'resource'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('resource_id')) {
            $query->where('resource_id', $request->resource_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $reservations = $query->paginate(15);
        $resources = Resource::where('status', 'available')->get();
        $users = User::where('role_id', 3)->get(); // 3 = role 'user'

        return view('tech.reservations.pending', compact('reservations', 'resources', 'users'));
    }

    /**
     * Approuver une réservation
     */
    public function approve(Request $request, Reservation $reservation)
    {
        // Vérifier que la réservation est bien en attente
        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Cette réservation ne peut plus être approuvée.');
        }

        // Vérifier à nouveau la disponibilité
        $isAvailable = $this->validationService->checkAvailability(
            $reservation->resource_id,
            $reservation->start_date,
            $reservation->end_date,
            $reservation->id
        );

        if (!$isAvailable) {
            return back()->with('error', 'La ressource n\'est plus disponible pour cette période.');
        }

        try {
            // Mettre à jour le statut
            $reservation->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Mettre à jour le statut de la ressource si nécessaire
            $this->updateResourceStatus($reservation->resource);

            // Notifier l'utilisateur
            NotificationService::create(
                $reservation->user_id,
                'Réservation approuvée',
                "Votre réservation pour {$reservation->resource->name} a été approuvée.",
                'success',
                $reservation->id
            );

            // Envoyer un email (optionnel)
            $this->sendApprovalEmail($reservation);

            return back()->with('success', 'Réservation approuvée avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'approbation: ' . $e->getMessage());
        }
    }

    /**
     * Refuser une réservation
     */
    public function reject(Request $request, Reservation $reservation)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        // Vérifier que la réservation est bien en attente
        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Cette réservation ne peut plus être refusée.');
        }

        try {
            // Mettre à jour le statut
            $reservation->update([
                'status' => 'rejected',
                'rejected_by' => auth()->id(),
                'rejected_at' => now(),
                'rejection_reason' => $request->reason,
            ]);

            // Notifier l'utilisateur
            NotificationService::create(
                $reservation->user_id,
                'Réservation refusée',
                "Votre réservation pour {$reservation->resource->name} a été refusée. Raison: {$request->reason}",
                'error',
                $reservation->id
            );

            // Envoyer un email (optionnel)
            $this->sendRejectionEmail($reservation, $request->reason);

            return back()->with('success', 'Réservation refusée avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du refus: ' . $e->getMessage());
        }
    }

    /**
     * Approuver plusieurs réservations en lot
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'reservations' => 'required|array',
            'reservations.*' => 'exists:reservations,id',
        ]);

        $approvedCount = 0;
        $errors = [];

        foreach ($request->reservations as $reservationId) {
            $reservation = Reservation::find($reservationId);
            
            if (!$reservation || $reservation->status !== 'pending') {
                $errors[] = "Réservation #{$reservationId} invalide";
                continue;
            }

            // Vérifier la disponibilité
            $isAvailable = $this->validationService->checkAvailability(
                $reservation->resource_id,
                $reservation->start_date,
                $reservation->end_date,
                $reservation->id
            );

            if (!$isAvailable) {
                $errors[] = "Réservation #{$reservationId} - ressource non disponible";
                continue;
            }

            try {
                $reservation->update([
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                ]);

                $this->updateResourceStatus($reservation->resource);
                
                NotificationService::create(
                    $reservation->user_id,
                    'Réservation approuvée',
                    "Votre réservation pour {$reservation->resource->name} a été approuvée.",
                    'success',
                    $reservation->id
                );

                $approvedCount++;
            } catch (\Exception $e) {
                $errors[] = "Réservation #{$reservationId} - erreur: " . $e->getMessage();
            }
        }

        $message = "{$approvedCount} réservation(s) approuvée(s) avec succès.";
        if (!empty($errors)) {
            $message .= " Erreurs: " . implode(', ', $errors);
        }

        return back()->with('success', $message);
    }

    /**
     * Refuser plusieurs réservations en lot
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'reservations' => 'required|array',
            'reservations.*' => 'exists:reservations,id',
            'reason' => 'required|string|max:500',
        ]);

        $rejectedCount = 0;
        $errors = [];

        foreach ($request->reservations as $reservationId) {
            $reservation = Reservation::find($reservationId);
            
            if (!$reservation || $reservation->status !== 'pending') {
                $errors[] = "Réservation #{$reservationId} invalide";
                continue;
            }

            try {
                $reservation->update([
                    'status' => 'rejected',
                    'rejected_by' => auth()->id(),
                    'rejected_at' => now(),
                    'rejection_reason' => $request->reason,
                ]);

                NotificationService::create(
                    $reservation->user_id,
                    'Réservation refusée',
                    "Votre réservation pour {$reservation->resource->name} a été refusée. Raison: {$request->reason}",
                    'error',
                    $reservation->id
                );

                $rejectedCount++;
            } catch (\Exception $e) {
                $errors[] = "Réservation #{$reservationId} - erreur: " . $e->getMessage();
            }
        }

        $message = "{$rejectedCount} réservation(s) refusée(s) avec succès.";
        if (!empty($errors)) {
            $message .= " Erreurs: " . implode(', ', $errors);
        }

        return back()->with('success', $message);
    }

    /**
     * Mettre à jour le statut de la ressource
     */
    private function updateResourceStatus(Resource $resource)
    {
        // Vérifier s'il y a des réservations actives
        $activeReservations = $resource->reservations()
            ->whereIn('status', ['approved', 'active'])
            ->where('end_date', '>', now())
            ->count();

        if ($activeReservations > 0) {
            $resource->update(['status' => 'busy']);
        } else {
            $resource->update(['status' => 'available']);
        }
    }

    /**
     * Envoyer un email d'approbation
     */
    private function sendApprovalEmail(Reservation $reservation)
    {
        try {
            \Illuminate\Support\Facades\Mail::raw(
                "Bonjour {$reservation->user->name},\n\n" .
                "Votre réservation pour la ressource '{$reservation->resource->name}' a été approuvée.\n" .
                "Date de début: {$reservation->start_date}\n" .
                "Date de fin: {$reservation->end_date}\n\n" .
                "Votre réservation est maintenant active.\n\n" .
                "Cordialement,\n" .
                "Équipe Data Center",
                function ($message) use ($reservation) {
                    $message->to($reservation->user->email)
                        ->subject('Réservation approuvée - Data Center');
                }
            );
        } catch (\Exception $e) {
            \Log::error('Erreur email approbation: ' . $e->getMessage());
        }
    }

    /**
     * Envoyer un email de refus
     */
    private function sendRejectionEmail(Reservation $reservation, $reason)
    {
        try {
            \Illuminate\Support\Facades\Mail::raw(
                "Bonjour {$reservation->user->name},\n\n" .
                "Votre réservation pour la ressource '{$reservation->resource->name}' a été refusée.\n" .
                "Date de début: {$reservation->start_date}\n" .
                "Date de fin: {$reservation->end_date}\n" .
                "Raison: {$reason}\n\n" .
                "Pour plus d'informations, veuillez contacter l'administrateur.\n\n" .
                "Cordialement,\n" .
                "Équipe Data Center",
                function ($message) use ($reservation) {
                    $message->to($reservation->user->email)
                        ->subject('Réservation refusée - Data Center');
                }
            );
        } catch (\Exception $e) {
            \Log::error('Erreur email refus: ' . $e->getMessage());
        }
    }

    /**
     * Statistiques des approbations
     */
    public function stats()
    {
        $stats = [
            'pending' => Reservation::where('status', 'pending')->count(),
            'approved_today' => Reservation::where('status', 'approved')
                ->whereDate('created_at', today())
                ->count(),
            'rejected_today' => Reservation::where('status', 'rejected')
                ->whereDate('created_at', today())
                ->count(),
            'total_approved' => Reservation::where('status', 'approved')->count(),
            'total_rejected' => Reservation::where('status', 'rejected')->count(),
        ];

        return view('tech.reservations.stats', compact('stats'));
    }
}
