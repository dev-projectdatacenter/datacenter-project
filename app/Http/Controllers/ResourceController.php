<?php
/**
 * app/Http/Controllers/ResourceController.php
 * Auteur : OUARDA
 * Description : Gestion des ressources du Data Center
 */

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    // ════════════════════════════════════════════════════════════
    // ROUTE PUBLIQUE - Voir les ressources (invités)
    // ════════════════════════════════════════════════════════════
    
    /**
     * Afficher la liste des ressources (VERSION PUBLIQUE - invités)
     * Route : GET /resources (public)
     */
    public function publicIndex(Request $request)
    {
        // Récupérer seulement les ressources disponibles
        $query = Resource::with('category')
            ->where('status', 'available');
        
        // Filtres de recherche
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('cpu')) {
            $query->where('cpu', 'like', '%' . $request->cpu . '%');
        }

        if ($request->filled('ram')) {
            $query->where('ram', 'like', '%' . $request->ram . '%');
        }

        if ($request->filled('bandwidth')) {
            $query->where('bandwidth', 'like', '%' . $request->bandwidth . '%');
        }

        if ($request->filled('os')) {
            $query->where('os', 'like', '%' . $request->os . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        
        $resources = $query->paginate(12);
        $categories = ResourceCategory::all();
        
        return view('resources.public-index', compact('resources', 'categories'));
    }
    
    // ════════════════════════════════════════════════════════════
    // ROUTES PROTÉGÉES - Gestion complète (authentifiés)
    // ════════════════════════════════════════════════════════════
    
    /**
     * Afficher la liste des ressources (VERSION ADMIN - authentifiés)
     * Route : GET /resources (avec auth)
     */
    public function index(Request $request)
    {
        // Récupérer TOUTES les ressources (tous statuts)
        $query = Resource::with(['category', 'supervisor']);
        
        // Filtres de recherche
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cpu')) {
            $query->where('cpu', 'like', '%' . $request->cpu . '%');
        }

        if ($request->filled('ram')) {
            $query->where('ram', 'like', '%' . $request->ram . '%');
        }

        if ($request->filled('bandwidth')) {
            $query->where('bandwidth', 'like', '%' . $request->bandwidth . '%');
        }

        if ($request->filled('os')) {
            $query->where('os', 'like', '%' . $request->os . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        
        $resources = $query->paginate(15);
        $categories = ResourceCategory::all();
        
        return view('resources.index', compact('resources', 'categories'));
    }
    
    /**
     * Afficher le formulaire de création
     * Route : GET /resources/create
     */
    public function create()
    {
        $this->authorize('create', Resource::class);
        
        $categories = ResourceCategory::all();
        $techManagers = \App\Models\User::whereHas('role', function($q) {
            $q->where('name', 'tech_manager');
        })->get();

        return view('resources.create', compact('categories', 'techManagers'));
    }
    
    /**
     * Enregistrer une nouvelle ressource
     * Route : POST /resources
     */
    public function store(Request $request)
    {
        $this->authorize('create', Resource::class);

        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:resource_categories,id',
            'status' => 'required|in:available,busy,maintenance,out_of_service',
            'cpu' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'bandwidth' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'managed_by' => 'nullable|exists:users,id'
        ]);
        
        // Si c'est un tech manager qui crée la ressource, l'assigner automatiquement
        if (auth()->user()->role->name === 'tech_manager') {
            $validated['managed_by'] = auth()->user()->id;
        }
        
        // Créer la ressource
        Resource::create($validated);
        
        return redirect()
            ->route('resources.index')
            ->with('success', 'Ressource créée avec succès !');
    }
    
    /**
     * Afficher les détails d'une ressource
     * Route : GET /resources/{id}
     */
    public function show(Resource $resource)
    {
        // Charger les relations
        $resource->load('category', 'reservations.user', 'comments.user');
        
        return view('resources.show', compact('resource'));
    }
    
    /**
     * Afficher le formulaire d'édition
     * Route : GET /resources/{id}/edit
     */
    public function edit(Resource $resource)
    {
        $this->authorize('update', $resource);

        $categories = ResourceCategory::all();
        $techManagers = \App\Models\User::whereHas('role', function($q) {
            $q->where('name', 'tech_manager');
        })->get();

        return view('resources.edit', compact('resource', 'categories', 'techManagers'));
    }
    
    /**
     * Mettre à jour une ressource
     * Route : PUT/PATCH /resources/{id}
     */
    public function update(Request $request, Resource $resource)
    {
        $this->authorize('update', $resource);

        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:resource_categories,id',
            'status' => 'required|in:available,busy,maintenance,out_of_service',
            'cpu' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'bandwidth' => 'nullable|string|max:255',
            'storage' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'managed_by' => 'nullable|exists:users,id'
        ]);
        
        // Mettre à jour
        $resource->update($validated);
        
        return redirect()
            ->route('resources.index')
            ->with('success', 'Ressource mise à jour avec succès !');
    }
    
    /**
     * Supprimer une ressource
     * Route : DELETE /resources/{id}
     */
    public function destroy(Resource $resource)
    {
        $this->authorize('delete', $resource);

        // Vérifier s'il y a des réservations actives
        $hasActiveReservations = $resource->reservations()
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
        
        if ($hasActiveReservations) {
            return back()->with('error', 'Impossible de supprimer : cette ressource a des réservations actives.');
        }
        
        $resource->delete();
        
        return redirect()
            ->route('resources.index')
            ->with('success', 'Ressource supprimée avec succès !');
    }
}