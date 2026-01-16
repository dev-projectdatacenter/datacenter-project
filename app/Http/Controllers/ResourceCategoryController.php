<?php

namespace App\Http\Controllers;

use App\Models\ResourceCategory;
use Illuminate\Http\Request;

class ResourceCategoryController extends Controller
{
    /**
     * Affiche la liste des catégories.
     */
    public function index()
    {
        $categories = ResourceCategory::all();
        return view('resource_categories.index', compact('categories'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        return view('resource_categories.create');
    }

    /**
     * Enregistre une nouvelle catégorie.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:resource_categories',
            'description' => 'nullable|string|max:500',
        ]);

        ResourceCategory::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(ResourceCategory $category)
    {
        return view('resource_categories.edit', compact('category'));
    }

    /**
     * Met à jour la catégorie.
     */
    public function update(Request $request, ResourceCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:resource_categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Supprime la catégorie.
     */
    public function destroy(ResourceCategory $category)
    {
        // Vérifier si la catégorie contient des ressources avant de supprimer
        if ($category->resources()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Impossible de supprimer : cette catégorie contient des ressources.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }
}
