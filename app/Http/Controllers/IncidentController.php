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
    public function create(Resource $resource)
    {
        return view('incidents.create', compact('resource'));
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

        // TEMPORAIRE : On utilise un ID utilisateur par défaut (1) car l'auth est désactivée
        $userId = Auth::id() ?? 1;

        $incident = Incident::create([
            'user_id' => $userId,
            'resource_id' => $validated['resource_id'],
            'description' => $validated['description'],
            'status' => 'open',
        ]);

        // Optionnel : Mettre le statut de la ressource en 'maintenance' si l'incident est grave ?
        // On peut le suggérer à l'utilisateur plus tard.

        return redirect()->route('resources.show', $validated['resource_id'])
            ->with('success', 'Incident signalé avec succès. Il sera examiné par un administrateur.');
    }
}
