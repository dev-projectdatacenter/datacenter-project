<?php
/**
 * ReservationController.php
 * Gestion des réservations
 * Géré par HALIMA
 */

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\Incident;
use App\Services\ReservationValidationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected $validationService;

    public function __construct(ReservationValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    /**
     * Liste des réservations de l'utilisateur
     */
    public function index(Request $request)
    {
        $query = auth()->user()->reservations()->with('resource');
        
        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) === 2) {
                $query->whereBetween('start_date', $dates);
            }
        }
        
        $reservations = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Formulaire de réservation
     */
    public function create()
    {
        $resources = Resource::where('status', 'active')
            ->where('is_in_maintenance', false)
            ->with('category')
            ->get();
            
        return view('reservations.create', compact('resources'));
    }

    /**
     * Créer une réservation
     */
    public function store(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'purpose' => 'required|string|max:1000',
            'participants' => 'nullable|array',
            'participants.*' => 'email|exists:users,email',
        ]);

        $resource = Resource::findOrFail($request->resource_id);
        
        // Vérifier la disponibilité
        $isAvailable = $this->validationService->checkAvailability(
            $resource->id,
            $request->start_date,
            $request->end_date
        );

        if (!$isAvailable) {
            return back()->withInput()
                ->with('error', 'La ressource n\'est pas disponible pour cette période.');
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'resource_id' => $request->resource_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'purpose' => $request->purpose,
            'participants' => $request->participants ? json_encode($request->participants) : null,
            'status' => 'pending',
        ]);

        // Notifier le gestionnaire de la ressource
        $this->notifyResourceManager($resource, $reservation);

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation soumise avec succès. En attente d\'approbation.');
    }

    /**
     * Détails d'une réservation
     */
    public function show(Reservation $reservation)
    {
        // Vérifier que l'utilisateur a le droit de voir cette réservation
        if ($reservation->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $reservation->load(['resource', 'resource.manager', 'user']);
        
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Modifier une réservation (seulement si en attente)
     */
    public function edit(Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id() || $reservation->status !== 'pending') {
            abort(403);
        }

        $resources = Resource::where('status', 'active')
            ->where('is_in_maintenance', false)
            ->with('category')
            ->get();
            
        return view('reservations.edit', compact('reservation', 'resources'));
    }

    /**
     * Mettre à jour une réservation
     */
    public function update(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id() || $reservation->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'purpose' => 'required|string|max:1000',
        ]);

        $resource = Resource::findOrFail($request->resource_id);
        
        // Vérifier la disponibilité
        $isAvailable = $this->validationService->checkAvailability(
            $resource->id,
            $request->start_date,
            $request->end_date,
            $reservation->id // Exclure cette réservation de la vérification
        );

        if (!$isAvailable) {
            return back()->withInput()
                ->with('error', 'La ressource n\'est pas disponible pour cette période.');
        }

        $reservation->update($request->all());

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation mise à jour avec succès.');
    }

    /**
     * Annuler une réservation
     */
    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($reservation->status, ['pending', 'approved'])) {
            return back()->with('error', 'Impossible d\'annuler cette réservation.');
        }

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation annulée avec succès.');
    }

    /**
     * Historique des réservations
     */
    public function history()
    {
        $reservations = auth()->user()->reservations()
            ->with('resource')
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        return view('reservations.history', compact('reservations'));
    }

    /**
     * Statistiques personnelles
     */
    public function stats()
    {
        $user = auth()->user();
        
        $stats = [
            'total' => $user->reservations()->count(),
            'pending' => $user->reservations()->where('status', 'pending')->count(),
            'approved' => $user->reservations()->where('status', 'approved')->count(),
            'active' => $user->reservations()->where('status', 'active')->count(),
            'completed' => $user->reservations()->where('status', 'completed')->count(),
            'cancelled' => $user->reservations()->where('status', 'cancelled')->count(),
        ];

        $monthlyStats = $user->reservations()
            ->selectRaw('YEAR(start_date) as year, MONTH(start_date) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        return view('reservations.stats', compact('stats', 'monthlyStats'));
    }

    /**
     * API pour vérifier la disponibilité
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $isAvailable = $this->validationService->checkAvailability(
            $request->resource_id,
            $request->start_date,
            $request->end_date
        );

        return response()->json(['available' => $isAvailable]);
    }

    /**
     * Signaler un incident
     */
    public function reportIncident(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'description' => 'required|string|max:1000',
            'severity' => 'required|in:low,medium,high,critical',
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);
        
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        Incident::create([
            'reservation_id' => $reservation->id,
            'reported_by' => auth()->id(),
            'description' => $request->description,
            'severity' => $request->severity,
            'status' => 'open',
        ]);

        return back()->with('success', 'Incident signalé avec succès.');
    }

    /**
     * Voir ses incidents
     */
    public function myIncidents()
    {
        $incidents = Incident::where('reported_by', auth()->id())
            ->with(['reservation', 'reservation.resource'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('incidents.index', compact('incidents'));
    }

    private function notifyResourceManager($resource, $reservation)
    {
        // Implémenter la notification du gestionnaire
        // Pour l'instant, on utilise le service de notification
        \App\Services\NotificationService::create(
            $resource->managed_by,
            'Nouvelle demande de réservation',
            "Une nouvelle réservation pour {$resource->name} est en attente d'approbation.",
            'reservation_pending',
            $reservation->id
        );
    }
}
