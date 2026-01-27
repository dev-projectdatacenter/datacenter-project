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
use App\Http\Requests\ReservationRequest;
use Carbon\Carbon;

class ReservationController extends Controller
{
    protected $validationService;

    public function __construct(ReservationValidationService $validationService = null)
    {
        $this->validationService = $validationService ?: new ReservationValidationService();
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
        $resources = Resource::with('category')->get();

        return view('reservations.create', compact('resources'));
    }

    /**
     * Créer une réservation
     */
    public function store(ReservationRequest $request)
    {
        // La validation est déjà faite automatiquement par ReservationRequest !

        $resource = Resource::findOrFail($request->resource_id);

        // Vérifier la disponibilité via le service
        try {
            $isAvailable = $this->validationService->checkAvailability(
                $resource->id,
                $request->start_date,
                $request->end_date
            );
        } catch (\Exception $e) {
            // Si la vérification échoue, on considère que la ressource n'est pas disponible
            \Log::error('Erreur vérification disponibilité: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Une erreur est survenue lors de la vérification de disponibilité.');
        }

        if (!$isAvailable) {
            return back()->withInput()
                ->with('error', 'La ressource n\'est pas disponible pour cette période.');
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'resource_id' => $request->resource_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'justification' => $request->justification,
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
        $user = auth()->user();
        $isAdmin = $user && $user->role && $user->role->name === 'admin';

        if ($reservation->user_id !== auth()->id() && !$isAdmin) {
            abort(403);
        }

        $reservation->load(['resource', 'resource.category', 'user']);

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

        $resources = Resource::where('status', 'available')
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
            'justification' => 'required|string|max:1000',
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
    public function history(Request $request)
    {
        $query = auth()->user()->reservations()
            ->with(['resource', 'resource.category'])
            ->whereIn('status', ['completed', 'cancelled']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) === 2) {
                $from = trim($dates[0]);
                $to = trim($dates[1]);

                try {
                    $fromDate = str_contains($from, '/')
                        ? Carbon::createFromFormat('d/m/Y', $from)->startOfDay()
                        : Carbon::parse($from)->startOfDay();

                    $toDate = str_contains($to, '/')
                        ? Carbon::createFromFormat('d/m/Y', $to)->endOfDay()
                        : Carbon::parse($to)->endOfDay();

                    $query->whereBetween('start_date', [$fromDate, $toDate]);
                } catch (\Exception $e) {
                    // Ignorer le filtre si le format est invalide
                }
            }
        }

        $statsQuery = clone $query;
        $historyStats = [
            'total' => $statsQuery->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
        ];

        $reservations = $query->orderBy('start_date', 'desc')->paginate(15);

        return view('reservations.history', compact('reservations', 'historyStats'));
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
            'user_id' => auth()->id(),
            'resource_id' => $reservation->resource_id, // Utiliser la ressource liée à la réservation
            'description' => $request->description,
            'status' => 'open',
        ]);

        return back()->with('success', 'Incident signalé avec succès.');
    }

    /**
     * Voir ses incidents
     */
    public function myIncidents()
    {
        $incidents = Incident::where('user_id', auth()->id())
            ->with(['resource'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('incidents.index', compact('incidents'));
    }

    private function notifyResourceManager($resource, $reservation)
    {
        try {
            // Pour l'instant, on crée une notification pour l'utilisateur lui-même
            // TODO: Implémenter la notification du gestionnaire de ressource quand le champ managed_by existera
            \App\Services\NotificationService::create(
                auth()->id(), // Utiliser l'ID de l'utilisateur actuel
                'Réservation soumise',
                "Votre réservation pour {$resource->name} est en attente d'approbation.",
                'reservation_pending',
                $reservation->id
            );
        } catch (\Exception $e) {
            // Si la notification échoue, on continue quand même
            // Log l'erreur pour le débogage
            \Log::error('Erreur notification: ' . $e->getMessage());
        }
    }
}
