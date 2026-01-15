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
            ->where('status', 'disponible');
        
        // Filtres de recherche
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
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
        $query = Resource::with('category');
        
        // Filtres de recherche
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
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
        $categories = ResourceCategory::all();
        return view('resources.create', compact('categories'));
    }
    
    /**
     * Enregistrer une nouvelle ressource
     * Route : POST /resources
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:disponible,reservee,maintenance,hors_service',
            'specifications' => 'nullable|string'
        ]);
        
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
        $resource->load('category', 'reservations.user');
        
        return view('resources.show', compact('resource'));
    }
    
    /**
     * Afficher le formulaire d'édition
     * Route : GET /resources/{id}/edit
     */
    public function edit(Resource $resource)
    {
        $categories = ResourceCategory::all();
        return view('resources.edit', compact('resource', 'categories'));
    }
    
    /**
     * Mettre à jour une ressource
     * Route : PUT/PATCH /resources/{id}
     */
    public function update(Request $request, Resource $resource)
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:disponible,reservee,maintenance,hors_service',
            'specifications' => 'nullable|string'
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
        // Vérifier s'il y a des réservations actives
        $hasActiveReservations = $resource->reservations()
            ->whereIn('status', ['en_attente', 'approuvee'])
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