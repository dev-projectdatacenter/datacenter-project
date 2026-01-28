<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resources.
     */
    public function index(Request $request)
    {
        $resources = Resource::with('category')
            ->orderBy('name')
            ->paginate(20);
            
        return view('admin.resources.index', compact('resources'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ResourceCategory::all();
        return view('admin.resources.create', compact('categories'));
    }
    
    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:resource_categories,id',
            'cpu' => 'nullable|string|max:100',
            'ram' => 'nullable|string|max:100',
            'storage' => 'nullable|string|max:100',
            'bandwidth' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,maintenance'
        ]);
        
        Resource::create($request->all());
        
        return redirect()->route('admin.resources.index')
            ->with('success', 'Ressource créée avec succès!');
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        $categories = ResourceCategory::all();
        return view('admin.resources.edit', compact('resource', 'categories'));
    }
    
    /**
     * Update the specified resource.
     */
    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:resource_categories,id',
            'cpu' => 'nullable|string|max:100',
            'ram' => 'nullable|string|max:100',
            'storage' => 'nullable|string|max:100',
            'bandwidth' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,maintenance'
        ]);
        
        $resource->update($request->all());
        
        return redirect()->route('admin.resources.index')
            ->with('success', 'Ressource mise à jour avec succès!');
    }
    
    /**
     * Remove the specified resource.
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();
        
        return redirect()->route('admin.resources.index')
            ->with('success', 'Ressource supprimée avec succès!');
    }
}
