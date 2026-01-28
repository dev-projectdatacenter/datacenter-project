<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
    /**
     * Affiche le formulaire pour signaler un incident.
     */
    public function create(Resource $resource = null)
    {
        $this->authorize('create', Incident::class);
        $resources = Resource::all();
        return view('incidents.create', compact('resource', 'resources'));
    }

    /**
     * Affiche la liste globale des incidents.
     */
    public function index()
    {
        $this->authorize('viewAny', Incident::class);

        $user = Auth::user();

        if (in_array($user->role->name, ['admin', 'tech_manager'])) {
            // Admins and Tech Managers see all incidents
            $incidents = Incident::with(['resource.supervisor', 'user'])->latest()->get();
        } else {
            // Regular users only see their own incidents
            $incidents = Incident::where('user_id', $user->id)
                ->with(['resource.supervisor', 'user'])
                ->latest()
                ->get();
        }

        return view('incidents.index', compact('incidents'));
    }

    /**
     * Affiche les détails d'un incident.
     */
    public function show(Incident $incident)
    {
        $this->authorize('view', $incident);
        $incident->load(['resource.supervisor', 'user']);
        return view('incidents.show', compact('incident'));
    }

    /**
     * Convertit un incident en maintenance.
     */
    public function convertToMaintenance(Incident $incident)
    {
        $this->authorize('update', $incident);

        if ($incident->status !== 'open') {
            return back()->with('error', 'Seuls les incidents ouverts peuvent être convertis en maintenance.');
        }

        $resource = $incident->resource;
        $resource->update(['status' => 'maintenance']);

        $incident->update([
            'status' => 'resolved',
            'notes' => 'Converti en maintenance par ' . Auth::user()->name
        ]);

        return redirect()->route('incidents.index')
            ->with('success', 'L\'incident a été converti en maintenance et la ressource marquée comme en maintenance.');
    }

    /**
     * Marque un incident comme résolu.
     */
    public function resolve(Incident $incident)
    {
        $this->authorize('update', $incident);
        $incident->update(['status' => 'resolved']);

        return redirect()->route('incidents.index')
            ->with('success', 'L\'incident a été marqué comme résolu.');
    }

    /**
     * Enregistre un nouvel incident.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Incident::class);

        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'description' => 'required|string|min:10',
            'severity' => 'required|in:low,medium,high,critical',
        ]);

        Incident::create([
            'user_id' => Auth::id(),
            'resource_id' => $validated['resource_id'],
            'description' => $validated['description'],
            'severity' => $validated['severity'],
            'status' => 'open',
        ]);

        return redirect()->route('resources.show', $validated['resource_id'])
            ->with('success', 'Incident signalé avec succès. Il sera examiné par un administrateur.');
    }
}
