<?php
/**
 * routes/user-simple.php
 * Routes simplifiées pour l'Utilisateur Interne
 * Évite les conflits avec les contrôleurs manquants
 */

use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════════
// ROUTES UTILISATEUR (Authentification requise)
// ══════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:user'])->group(function () {
    
    // Voir les ressources disponibles
    Route::get('/user/resources', function () {
        $resources = \App\Models\Resource::with('category')
            ->where('status', 'available')
            ->paginate(15);
            
        return '<h1>💻 Ressources disponibles</h1>
        <table border="1" cellpadding="5">
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>CPU</th>
                <th>RAM</th>
                <th>Stockage</th>
                <th>Actions</th>
            </tr>
            @foreach($resources as $resource)
            <tr>
                <td>{{ $resource->name }}</td>
                <td>{{ $resource->category->name ?? \'N/A\' }}</td>
                <td>{{ $resource->cpu ?? \'N/A\' }}</td>
                <td>{{ $resource->ram ?? \'N/A\' }}</td>
                <td>{{ $resource->storage ?? \'N/A\' }}</td>
                <td>
                    <a href="/user/reservations/create?resource={{ $resource->id }}">📅 Réserver</a> |
                    <a href="/user/resources/{{ $resource->id }}">👁️ Détails</a>
                </td>
            </tr>
            @endforeach
        </table>
        <p><a href="/dashboard/user">← Retour dashboard</a></p>';
    })->name('user.resources.index');
    
    // Détails d'une ressource
    Route::get('/user/resources/{resource}', function ($resourceId) {
        $resource = \App\Models\Resource::with('category')->findOrFail($resourceId);
        
        return '<h1>💻 Détails de la ressource</h1>
        <table border="1" cellpadding="5">
            <tr><th>Nom</th><td>{{ $resource->name }}</td></tr>
            <tr><th>Type</th><td>{{ $resource->category->name ?? \'N/A\' }}</td></tr>
            <tr><th>CPU</th><td>{{ $resource->cpu ?? \'N/A\' }}</td></tr>
            <tr><th>RAM</th><td>{{ $resource->ram ?? \'N/A\' }}</td></tr>
            <tr><th>Stockage</th><td>{{ $resource->storage ?? \'N/A\' }}</td></tr>
            <tr><th>Statut</th><td>{{ $resource->status }}</td></tr>
            <tr><th>Description</th><td>{{ $resource->description ?? \'N/A\' }}</td></tr>
        </table>
        <p><a href="/user/reservations/create?resource={{ $resource->id }}" class="btn">📅 Réserver cette ressource</a></p>
        <p><a href="/user/resources">← Retour aux ressources</a></p>';
    })->name('user.resources.show');
    
    // Formulaire de demande de réservation
    Route::get('/user/reservations/create', function () {
        $resourceId = request()->get('resource');
        $resource = $resourceId ? \App\Models\Resource::find($resourceId) : null;
        $resources = \App\Models\Resource::where('status', 'available')->get();
        
        return '<h1>📅 Nouvelle demande de réservation</h1>
        <form method="POST" action="/user/reservations">
            @csrf
            <table border="1" cellpadding="5">
                <tr>
                    <th><label for="resource_id">Ressource *</label></th>
                    <td>
                        <select name="resource_id" required>
                            <option value="">-- Choisissez une ressource --</option>
                            @foreach($resources as $res)
                                <option value="{{ $res->id }}" {{ $resource && $resource->id == $res->id ? \'selected\' : \'\' }}>
                                    {{ $res->name }} ({{ $res->category->name ?? \'N/A\' }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="start_date">Date de début *</label></th>
                    <td><input type="date" name="start_date" required></td>
                </tr>
                <tr>
                    <th><label for="end_date">Date de fin *</label></th>
                    <td><input type="date" name="end_date" required></td>
                </tr>
                <tr>
                    <th><label for="motivation">Motivation *</label></th>
                    <td><textarea name="motivation" required placeholder="Expliquez pourquoi vous avez besoin de cette ressource..."></textarea></td>
                </tr>
            </table>
            <button type="submit" class="btn">📅 Envoyer la demande</button>
            <a href="/dashboard/user">← Annuler</a>
        </form>';
    })->name('user.reservations.create');
    
    // Soumettre la demande de réservation
    Route::post('/user/reservations', function () {
        try {
            $data = request()->validate([
                'resource_id' => 'required|exists:resources,id',
                'start_date' => 'required|date|after:today',
                'end_date' => 'required|date|after:start_date',
                'motivation' => 'required|string|max:500',
            ]);
            
            $user = auth()->user();
            
            // Vérifier les conflits
            $conflict = \App\Models\Reservation::where('resource_id', $data['resource_id'])
                ->where('status', '!=', 'cancelled')
                ->where(function($query) use ($data) {
                    $query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                          ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']])
                          ->orWhere(function($q) use ($data) {
                              $q->where('start_date', '<=', $data['start_date'])
                                ->where('end_date', '>=', $data['end_date']);
                          });
                })
                ->exists();
                
            if ($conflict) {
                return '<h1>❌ Conflit de réservation</h1>
                <p>Cette ressource est déjà réservée pour cette période.</p>
                <p><a href="/user/reservations/create">← Réessayer</a></p>';
            }
            
            // Créer la réservation
            $reservation = \App\Models\Reservation::create([
                'user_id' => $user->id,
                'resource_id' => $data['resource_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'motivation' => $data['motivation'],
                'status' => 'pending',
            ]);
            
            // Logger l'action
            \App\Services\ActivityLogService::log(
                'reservation_created',
                "Demande de réservation créée pour la ressource ID: {$data['resource_id']}",
                $user->id
            );
            
            return '<h1>✅ Demande envoyée !</h1>
            <p>Votre demande de réservation a été soumise et est en attente de validation.</p>
            <p>Vous recevrez une notification dès qu\'elle sera traitée.</p>
            <p><a href="/user/reservations">← Voir mes réservations</a></p>';
            
        } catch (\Exception $e) {
            return '<h1>❌ Erreur</h1>
            <p>Une erreur est survenue: ' . $e->getMessage() . '</p>
            <p><a href="/user/reservations/create">← Réessayer</a></p>';
        }
    })->name('user.reservations.store');
    
    // Voir mes réservations
    Route::get('/user/reservations', function () {
        $user = auth()->user();
        $reservations = \App\Models\Reservation::with('resource')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(20);
            
        return '<h1>📋 Mes réservations</h1>
        <table border="1" cellpadding="5">
            <tr>
                <th>Ressource</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Motivation</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
            @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->resource->name }}</td>
                <td>{{ $reservation->start_date->format(\'d/m/Y\') }}</td>
                <td>{{ $reservation->end_date->format(\'d/m/Y\') }}</td>
                <td>{{ substr($reservation->motivation ?? \'\', 0, 50) }}...</td>
                <td>{{ $reservation->status }}</td>
                <td>
                    <a href="/user/reservations/{{ $reservation->id }}">👁️ Détails</a>
                    @if($reservation->status === \'pending\')
                        <form method="POST" action="/user/reservations/{{ $reservation->id }}/cancel" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:red;color:white;padding:5px;">❌ Annuler</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
        <p><a href="/dashboard/user">← Retour dashboard</a></p>';
    })->name('user.reservations.index');
    
    // Détails d'une réservation
    Route::get('/user/reservations/{reservation}', function ($reservationId) {
        $user = auth()->user();
        $reservation = \App\Models\Reservation::with(['resource', 'resource.category'])
            ->where('user_id', $user->id)
            ->findOrFail($reservationId);
            
        return '<h1>📋 Détails de la réservation</h1>
        <table border="1" cellpadding="5">
            <tr><th>Ressource</th><td>{{ $reservation->resource->name }}</td></tr>
            <tr><th>Type</th><td>{{ $reservation->resource->category->name ?? \'N/A\' }}</td></tr>
            <tr><th>Date début</th><td>{{ $reservation->start_date->format(\'d/m/Y H:i\') }}</td></tr>
            <tr><th>Date fin</th><td>{{ $reservation->end_date->format(\'d/m/Y H:i\') }}</td></tr>
            <tr><th>Motivation</th><td>{{ $reservation->motivation }}</td></tr>
            <tr><th>Statut</th><td>{{ $reservation->status }}</td></tr>
            <tr><th>Date de demande</th><td>{{ $reservation->created_at->format(\'d/m/Y H:i\') }}</td></tr>
        </table>
        <p><a href="/user/reservations">← Retour à mes réservations</a></p>';
    })->name('user.reservations.show');
    
    // Annuler une réservation
    Route::post('/user/reservations/{reservation}/cancel', function ($reservationId) {
        $user = auth()->user();
        $reservation = \App\Models\Reservation::where('user_id', $user->id)
            ->where('status', 'pending')
            ->findOrFail($reservationId);
            
        $reservation->status = 'cancelled';
        $reservation->cancelled_by = $user->id;
        $reservation->cancelled_at = now();
        $reservation->save();
        
        // Logger l'action
        \App\Services\ActivityLogService::log(
            'reservation_cancelled',
            "Réservation annulée par l'utilisateur",
            $user->id
        );
        
        return '<h1>✅ Réservation annulée</h1>
        <p>Votre réservation a été annulée avec succès.</p>
        <p><a href="/user/reservations">← Retour à mes réservations</a></p>';
    })->name('user.reservations.cancel');
    
    // Signaler un incident
    Route::get('/user/incidents/create', function () {
        $resources = \App\Models\Resource::where('status', 'available')->get();
        
        return '<h1>🚨 Signaler un incident technique</h1>
        <form method="POST" action="/user/incidents">
            @csrf
            <table border="1" cellpadding="5">
                <tr>
                    <th><label for="resource_id">Ressource concernée *</label></th>
                    <td>
                        <select name="resource_id" required>
                            <option value="">-- Choisissez une ressource --</option>
                            @foreach($resources as $resource)
                                <option value="{{ $resource->id }}">{{ $resource->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="title">Titre de l\'incident *</label></th>
                    <td><input type="text" name="title" required placeholder="Ex: Problème de connexion"></td>
                </tr>
                <tr>
                    <th><label for="description">Description détaillée *</label></th>
                    <td><textarea name="description" required placeholder="Décrivez le problème en détail..."></textarea></td>
                </tr>
                <tr>
                    <th><label for="severity">Gravité *</label></th>
                    <td>
                        <select name="severity" required>
                            <option value="low">Faible</option>
                            <option value="medium">Moyenne</option>
                            <option value="high">Élevée</option>
                            <option value="critical">Critique</option>
                        </select>
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn">🚨 Signaler l\'incident</button>
            <a href="/dashboard/user">← Annuler</a>
        </form>';
    })->name('user.incidents.create');
    
    // Soumettre l'incident
    Route::post('/user/incidents', function () {
        try {
            $data = request()->validate([
                'resource_id' => 'required|exists:resources,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'severity' => 'required|in:low,medium,high,critical',
            ]);
            
            $user = auth()->user();
            
            // Créer l'incident
            $incident = \App\Models\Incident::create([
                'user_id' => $user->id,
                'resource_id' => $data['resource_id'],
                'title' => $data['title'],
                'description' => $data['description'],
                'severity' => $data['severity'],
                'status' => 'pending',
            ]);
            
            // Logger l'action
            \App\Services\ActivityLogService::log(
                'incident_reported',
                "Incident signalé pour la ressource ID: {$data['resource_id']}",
                $user->id
            );
            
            return '<h1>✅ Incident signalé !</h1>
            <p>Votre incident a été enregistré et sera traité par le responsable technique.</p>
            <p>Vous recevrez une notification dès qu\'une action sera entreprise.</p>
            <p><a href="/dashboard/user">← Retour dashboard</a></p>';
            
        } catch (\Exception $e) {
            return '<h1>❌ Erreur</h1>
            <p>Une erreur est survenue: ' . $e->getMessage() . '</p>
            <p><a href="/user/incidents/create">← Réessayer</a></p>';
        }
    })->name('user.incidents.store');
});
