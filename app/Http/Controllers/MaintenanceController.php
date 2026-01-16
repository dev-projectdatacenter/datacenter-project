<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Resource;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Affiche la liste des maintenances.
     */
    public function index()
    {
        $maintenances = Maintenance::with('resource')->orderBy('start_date', 'asc')->get();
        return view('maintenances.index', compact('maintenances'));
    }

    /**
     * Formulaire pour planifier une maintenance.
     */
    public function create(Request $request)
    {
        $resourceId = $request->query('resource_id');
        $resource = $resourceId ? Resource::findOrFail($resourceId) : null;
        $resources = Resource::all();

        return view('maintenances.create', compact('resource', 'resources'));
    }

    /**
     * Enregistre une maintenance.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date|after_or_equal:now',
            'end_date' => 'required|date|after:start_date',
            'reason' => 'required|string|max:500',
        ]);

        Maintenance::create($validated);

        // Mettre à jour le statut de la ressource si la maintenance commence maintenant
        // Optionnel : on pourrait utiliser un job planifié pour ça.
        $resource = Resource::find($validated['resource_id']);
        $resource->update(['status' => 'maintenance']);

        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance planifiée avec succès. Le serveur est passé en mode maintenance.');
    }

    /**
     * Supprime/Annule une maintenance.
     */
    public function destroy(Maintenance $maintenance)
    {
        $resource = $maintenance->resource;
        $maintenance->delete();

        // Remettre la ressource en 'available' après suppression ?
        // On laisse l'utilisateur décider via l'édition de ressource pour plus de sécurité.
        
        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance annulée / supprimée.');
    }
}
