<?php
/**
 * MaintenanceController.php
 * Gestion des maintenances de ressources
 * Géré par OUARDA
 */

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Resource;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Afficher la liste des maintenances
     */
    public function index(Request $request)
    {
        $query = Maintenance::with(['resource', 'resource.manager']);
        
        if ($request->filled('status')) {
            if ($request->status === 'upcoming') {
                $query->where('start_date', '>', now());
            } elseif ($request->status === 'ongoing') {
                $query->where('start_date', '<=', now())
                      ->where('end_date', '>=', now());
            } elseif ($request->status === 'completed') {
                $query->where('end_date', '<', now());
            }
        }
        
        $maintenances = $query->orderBy('start_date', 'desc')->paginate(15);
        
        return view('maintenances.index', compact('maintenances'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create(Resource $resource)
    {
        return view('maintenances.create', compact('resource'));
    }

    /**
     * Créer une nouvelle maintenance
     */
    public function store(Request $request, Resource $resource)
    {
        $request->validate([
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'reason' => 'required|string|max:1000',
        ]);

        // Vérifier les conflits avec les réservations
        $conflicts = $resource->reservations()
            ->where('status', 'approved')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                      ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                      });
            })
            ->exists();

        if ($conflicts) {
            return back()->with('error', 'Conflit détecté : des réservations existent pendant cette période.');
        }

        Maintenance::create([
            'resource_id' => $resource->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'created_by' => auth()->id(),
        ]);

        // Mettre la ressource en maintenance
        $resource->update(['is_in_maintenance' => true]);

        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance planifiée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Maintenance $maintenance)
    {
        $maintenance->load('resource');
        return view('maintenances.edit', compact('maintenance'));
    }

    /**
     * Mettre à jour une maintenance
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'reason' => 'required|string|max:1000',
        ]);

        $maintenance->update($request->all());

        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance mise à jour avec succès.');
    }

    /**
     * Supprimer une maintenance
     */
    public function destroy(Maintenance $maintenance)
    {
        $resource = $maintenance->resource;
        
        $maintenance->delete();

        // Vérifier s'il y a d'autres maintenances actives pour cette ressource
        $hasActiveMaintenance = $resource->maintenances()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->exists();

        if (!$hasActiveMaintenance) {
            $resource->update(['is_in_maintenance' => false]);
        }

        return redirect()->route('maintenances.index')
            ->with('success', 'Maintenance supprimée avec succès.');
    }
}
