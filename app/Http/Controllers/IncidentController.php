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
        $resources = Resource::all();
        return view('incidents.create', compact('resource', 'resources'));
    }

    /**
     * Affiche la liste globale des incidents.
     */
    public function index()
    {
        $incidents = Incident::with(['resource', 'user'])->latest()->get();
        return view('incidents.index', compact('incidents'));
    }

    /**
     * Affiche les détails d'un incident.
     */
    public function show(Incident $incident)
    {
        $incident->load(['resource', 'user']);
        return view('incidents.show', compact('incident'));
    }

    /**
     * Marque un incident comme résolu.
     */
    public function resolve(Incident $incident)
    {
        $incident->update(['status' => 'resolved']);

        return redirect()->route('incidents.index')
            ->with('success', 'L\'incident a été marqué comme résolu.');
    }

    /**
     * Enregistre un nouvel incident.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'description' => 'required|string|min:10',
        ]);

        $userId = Auth::id() ?? 1;

        $incident = Incident::create([
            'user_id' => $userId,
            'resource_id' => $validated['resource_id'],
            'description' => $validated['description'],
            'status' => 'open',
        ]);



        return redirect()->route('resources.show', $validated['resource_id'])
            ->with('success', 'Incident signalé avec succès. Il sera examiné par un administrateur.');
    }
}
