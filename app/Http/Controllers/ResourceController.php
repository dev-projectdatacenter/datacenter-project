<?php
/**
 * ResourceController.php
 * Gestion des ressources du Data Center
 * Géré par OUARDA
 */

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResourceController extends Controller
{
    /**
     * Afficher la liste des ressources
     */
    public function index(Request $request)
    {
        $query = Resource::with(['category', 'manager']);
        
        // Filtres
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $resources = $query->paginate(12);
        $categories = ResourceCategory::all();
        
        return view('resources.index', compact('resources', 'categories'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $categories = ResourceCategory::all();
        return view('resources.create', compact('categories'));
    }

    /**
     * Créer une nouvelle ressource
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:resource_categories,id',
            'specifications' => 'required|array',
            'location' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $resource = Resource::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'specifications' => json_encode($request->specifications),
            'location' => $request->location,
            'status' => $request->status,
            'managed_by' => auth()->id(),
            'is_in_maintenance' => $request->status === 'maintenance',
        ]);

        return redirect()->route('resources.index')
            ->with('success', 'Ressource créée avec succès.');
    }

    /**
     * Afficher les détails d'une ressource
     */
    public function show(Resource $resource)
    {
        $resource->load(['category', 'manager', 'reservations' => function ($query) {
            $query->orderBy('start_date', 'desc')->limit(5);
        }]);
        
        return view('resources.show', compact('resource'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Resource $resource)
    {
        $categories = ResourceCategory::all();
        return view('resources.edit', compact('resource', 'categories'));
    }

    /**
     * Mettre à jour une ressource
     */
    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:resource_categories,id',
            'specifications' => 'required|array',
            'location' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $resource->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'specifications' => json_encode($request->specifications),
            'location' => $request->location,
            'status' => $request->status,
            'is_in_maintenance' => $request->status === 'maintenance',
        ]);

        return redirect()->route('resources.index')
            ->with('success', 'Ressource mise à jour avec succès.');
    }

    /**
     * Supprimer une ressource
     */
    public function destroy(Resource $resource)
    {
        // Vérifier qu'il n'y a pas de réservations actives
        if ($resource->reservations()->whereIn('status', ['active', 'approved'])->exists()) {
            return back()->with('error', 'Impossible de supprimer une ressource avec des réservations actives.');
        }

        $resource->delete();

        return redirect()->route('resources.index')
            ->with('success', 'Ressource supprimée avec succès.');
    }
}
