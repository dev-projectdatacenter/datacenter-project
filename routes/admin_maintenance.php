<?php
/**
 * routes/admin_maintenance.php
 * Routes de gestion des maintenances pour administrateur
 * Selon les spécifications: Gestion des périodes de maintenance planifiée
 */

use Illuminate\Support\Facades\Route;

// ════════════════════════════════════════════════════════════
// GESTION DES MAINTENANCES (Admin uniquement)
// ════════════════════════════════════════════════════════════

Route::prefix('admin/maintenances')
    ->name('admin.maintenances.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        
        // Lister toutes les maintenances
        Route::get('/', function () {
            $maintenances = \App\Models\Maintenance::with('resource')->get();
            return view('admin.maintenances.index', compact('maintenances'));
        })->name('index');
        
        // Formulaire de création de maintenance
        Route::get('/create', function () {
            $resources = \App\Models\Resource::all();
            return view('admin.maintenances.create', compact('resources'));
        })->name('create');
        
        // Enregistrer une nouvelle maintenance
        Route::post('/', function () {
            $data = request()->validate([
                'resource_id' => 'required|exists:resources,id',
                'start_date' => 'required|date|after:now',
                'end_date' => 'required|date|after:start_date',
                'reason' => 'nullable|string|max:500'
            ]);
            
            \App\Models\Maintenance::create($data);
            
            return redirect()->route('admin.maintenances.index')
                ->with('success', 'Maintenance planifiée avec succès!');
        })->name('store');
        
        // Voir les détails d'une maintenance
        Route::get('/{maintenance}', function (\App\Models\Maintenance $maintenance) {
            $maintenance->load('resource');
            return view('admin.maintenances.show', compact('maintenance'));
        })->name('show');
        
        // Modifier une maintenance
        Route::get('/{maintenance}/edit', function (\App\Models\Maintenance $maintenance) {
            $resources = \App\Models\Resource::all();
            return view('admin.maintenances.edit', compact('maintenance', 'resources'));
        })->name('edit');
        
        // Mettre à jour une maintenance
        Route::put('/{maintenance}', function (\App\Models\Maintenance $maintenance) {
            $data = request()->validate([
                'resource_id' => 'required|exists:resources,id',
                'start_date' => 'required|date|after:now',
                'end_date' => 'required|date|after:start_date',
                'reason' => 'nullable|string|max:500'
            ]);
            
            $maintenance->update($data);
            
            return redirect()->route('admin.maintenances.index')
                ->with('success', 'Maintenance mise à jour avec succès!');
        })->name('update');
        
        // Supprimer une maintenance
        Route::delete('/{maintenance}', function (\App\Models\Maintenance $maintenance) {
            $maintenance->delete();
            
            return redirect()->route('admin.maintenances.index')
                ->with('success', 'Maintenance supprimée avec succès!');
        })->name('destroy');
        
        // API: Maintenances à venir
        Route::get('/api/upcoming', function () {
            $maintenances = \App\Models\Maintenance::with('resource')
                ->where('start_date', '>', now())
                ->orderBy('start_date')
                ->limit(5)
                ->get();
            
            return response()->json($maintenances);
        })->name('api.upcoming');
    });
