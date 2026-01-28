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
        $this->authorize('viewAny', Maintenance::class);
        $maintenances = Maintenance::with('resource')->orderBy('start_date', 'asc')->get();
        return view('maintenances.index', compact('maintenances'));
    }

    /**
     * Formulaire pour planifier une maintenance.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Maintenance::class);

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
        $this->authorize('create', Maintenance::class);

        $validated = $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date|after_or_equal:now',
            'end_date' => 'required|date|after:start_date',
            'reason' => 'required|string|max:500',
        ]);

        Maintenance::create($validated);

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
        $this->authorize('delete', $maintenance);

        $maintenance->delete();
        
        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance annulée / supprimée.');
    }
}
